<?php

namespace Mind4me\Bx24_integration\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Mind4me\Bx24_integration\Models\DealProductrows;

class B24
{
    private $CRM_HOST = '';
    private $CLIENT_ID = '';
    private $CLIENT_SECRET = '';
    private $AUTH_TOKEN = '';
    private $CODE = '';


    public function __construct()
    {
        $this->CRM_HOST = config('integration.CRM_HOST');
        $this->CLIENT_ID = config('integration.CLIENT_ID');
        $this->CLIENT_SECRET = config('integration.CLIENT_SECRET');

        $this->USER = config('integration.USER');
        $this->PASSWORD = config('integration.PASSWORD');

        $this->httpClient = new Client([
            'base_uri' => $this->CRM_HOST,
            'cookies' => true,
            'allow_redirects' => [
                'max' => 10,        // allow at most 10 redirects.
                'protocols' => ['https', 'http'], // only allow https URLs
                'track_redirects' => true
            ],
            'verify' => false,
            'protocols' => ['https', 'http'],
        ]);

        $auth_user = $this->httpClient->request('post', "/?login=yes", [
            'form_params' => [
                'backurl' => '/',
                'AUTH_FORM' => 'Y',
                'TYPE' => 'AUTH',
                'USER_LOGIN' => $this->USER,
                'USER_PASSWORD' => $this->PASSWORD,
                'USER_REMEMBER' => 'Y',
            ]
        ]);

        $auth_app = $this->httpClient->request('get', "/oauth/authorize/?client_id={$this->CLIENT_ID}", [
            'query' => [
                'client_id' => $this->CLIENT_ID,
            ]
        ]);

        if(isset($auth_app->getHeaders()['X-Guzzle-Redirect-History']) && isset($auth_app->getHeaders()['X-Guzzle-Redirect-History'][0])){
            $auth_link = $auth_app->getHeaders()['X-Guzzle-Redirect-History'][0];
            parse_str(parse_url($auth_link)['query'], $params);
            if(isset($params['code'])){
                $this->CODE = $params['code'];

                $auth = $this->httpClient->request('get', "/oauth/token/", [
                    'query' => [
                        'grant_type' => 'authorization_code',
                        'client_id' => $this->CLIENT_ID,
                        'client_secret' => $this->CLIENT_SECRET,
                        'code' => $this->CODE,
                    ]
                ]);
                $auth_data = json_decode($auth->getBody()->getContents());
                if(isset($auth_data->access_token)){
                    $this->AUTH_TOKEN = $auth_data->access_token;
                }
            }
        }
    }

    public static function getEntityByEventName($event_name){
        if (strpos($event_name, 'DEAL') !== false) {
            $entity = 'deal';
            $request = 'crm.deal.get';
        } elseif(strpos($event_name, 'LEAD') !== false){
            $entity = 'lead';
            $request = 'crm.lead.get';
        } elseif(strpos($event_name, 'COMPANY') !== false){
            $entity = 'company';
            $request = 'crm.company.get';
        } elseif(strpos($event_name, 'INVOICE') !== false){
            $entity = 'invoice';
            $request = 'crm.invoice.get';
        } elseif(strpos($event_name, 'PRODUCT') !== false){
            $entity = 'product';
            $request = 'crm.product.get';
        } elseif(strpos($event_name, 'CONTACT') !== false){
            $entity = 'contact';
            $request = 'crm.contact.get';
        } elseif(strpos($event_name, 'ACTIVITY') !== false){
            $entity = 'activity';
            $request = 'crm.activity.get';
        } elseif(strpos($event_name, 'REQUISITE') !== false){
            $entity = 'requisite';
            $request = 'crm.requisite.get';
        } elseif(strpos($event_name, 'TASK') !== false){
            $entity = 'task';
            $request = 'tasks.task.get';
        } else {
            $entity = null;
            $request = null;
        }
        return ['entity'=>$entity, 'request'=>$request];
    }

    public function callMethod($apiMethod = '', $httpMethod = 'get', $params = [])
    {
        $params['auth'] = $this->AUTH_TOKEN;
        if ($httpMethod == 'get') {
            $requestBody = [
                'query' => $params
            ];
        } else {
            $requestBody = [
                'form_params' => $params,
            ];
        }
        try {
            $response = $this->httpClient->request($httpMethod, $apiMethod, $requestBody);
            if ($response->getStatusCode() === 200) {
                $responseData = $response->getBody()->getContents();
                return json_decode($responseData);
            } else {
                return ['success' => false, 'error' => 'Нет связи с срм ' . $apiMethod . '. Ответ - ' . $response->getStatusCode()];
            }
        } catch (GuzzleException $e) {
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function sendBatchRequest($offline_events){
        $cmd = []; $cmd_entity = [];
        $cmd_deal = []; $cmd_deal_id = [];
        $entities = [];
        foreach ($offline_events as $key => $event){
            $message_id = $event->MESSAGE_ID; // ид записи, чтоб вычистить ее потом из очереди
            $entity = self::getEntityByEventName($event->EVENT_NAME)['entity'];
            $rest_request = self::getEntityByEventName($event->EVENT_NAME)['request'];

            // находим ид сделки, контакта, компании, того, что изменяли
            $entity_id = isset($event->EVENT_DATA) && isset($event->EVENT_DATA->FIELDS) && isset($event->EVENT_DATA->FIELDS->ID) ? $event->EVENT_DATA->FIELDS->ID : null;
            if(!$entity_id){
                $entity_id = isset($event->EVENT_DATA) && isset($event->EVENT_DATA->FIELDS_AFTER) && isset($event->EVENT_DATA->FIELDS_AFTER->ID) ? $event->EVENT_DATA->FIELDS_AFTER->ID : null;
            }

            if($rest_request && $entity_id){
                $cmd_entity["q$key"] = $entity; // сохраним сущность чтоб потом не запрашивать ее
                $cmd["q$key"] = "$rest_request?id=$entity_id"; // собираем запросы на поиск сущностей
                $entities[] = "$entity: $entity_id";
                if($entity == 'deal'){
                    $cmd_deal["q$key"] = "crm.deal.productrows.get?id=$entity_id"; // если это сделка, то соберем запросы на обновление товарных позиций
                    $cmd_deal_id["q$key"] = $entity_id; // если это сделка, save id
                }
            }
        }

        if(count($cmd)){ // обновим сущности
            $data = $this->callMethod('/rest/batch', 'get', [ // отправляем
                'halt' => 0,
                'cmd' => $cmd,
            ]);

            if(isset($data->result) && isset($data->result->result)){
                $batch_responses = json_decode(json_encode($data->result->result), true); // так по тупому битрикс присылает
                foreach ($batch_responses as $key => $fields){ // проходимся по каждой сущности которую запросили

                    if($cmd_entity[$key] == 'task')
                        $fields = $fields['task'];

                    if(isset($fields['ID']) || isset($fields['id'])){ // запрос без ошибок отработал
                        $class_name = "Mind4me\\Bx24_integration\\Models\\".ucfirst($cmd_entity[$key]); // имя сущности (сделка, контакт или др.) с большой буквы начнем, чтоб потом класс найти
                        $model = new $class_name();
                        $model->saveField($fields);
                    }
                }
            }
        }

        if(count($cmd_deal)){ // обновим товары в сделках
            $data = $this->callMethod('/rest/batch', 'get', [ // отправляем
                'halt' => 0,
                'cmd' => $cmd_deal,
            ]);
            if(isset($data->result) && isset($data->result->result)) {
                $batch_responses = json_decode(json_encode($data->result->result), true);  // так по тупому битрикс присылает
                foreach ($batch_responses as $key => $fields) { // проходимся по каждой сущности которую запросили
                    $model = new DealProductrows();
                    $model->saveField($fields, $cmd_deal_id[$key]); // передаем поля и все ид сделки
                }
            }
        }

        return $entities;
    }



}

?>
