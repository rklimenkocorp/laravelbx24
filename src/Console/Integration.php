<?php

namespace Mind4me\Bx24_integration\Console;

use Illuminate\Console\Command;

class Integration extends Command
{

    protected $signature = 'integration:get-events';

    protected $description = 'Get offline events end save';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $b24 = new B24();
        $data = $b24->callMethod('/rest/event.offline.get', 'get', [
            'clear' => 0,
            'auth_connector' => 'bxapp',
        ]);


        if(isset($data->result) && isset($data->result->events) &&  isset($data->result->process_id)){
            $count = count($data->result->events);
            echo "FOR UPDATE: ".count($data->result->events)."\n";
            $entities = $b24->sendBatchRequest($data->result->events);
            $data = $b24->callMethod('/rest/event.offline.clear', 'get', [
                'process_id' => $data->result->process_id,
            ]);
            if(isset($data->result) && $data->result){
                echo "SUCCESS UPDATED!  \n".implode(', ', $entities)." \n-----------\n";
                if($count == 50)
                    $this->handle();
            }
        }
    }

}
