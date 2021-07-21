<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Requisite extends Model
{
    protected $table = 'b24_requisities';

    protected $fillable = [
        'ACTIVE',
        'CREATED_BY_ID',
        'DATE_CREATE',
        'DATE_MODIFY',
        'ENTITY_ID',
        'ENTITY_TYPE_ID',
        'ID',
        'MODIFY_BY_ID',
        'NAME',
        'ORIGINATOR_ID',
        'PRESET_ID',
        'RQ_COMPANY_FULL_NAME',
        'RQ_COMPANY_NAME',
        'RQ_COMPANY_REG_DATE',
        'RQ_CONTACT',
        'RQ_DIRECTOR',
        'RQ_FIRST_NAME',
        'RQ_EMAIL',
        'RQ_IFNS',
        'RQ_INN',
        'RQ_LAST_NAME',
        'RQ_NAME',
        'RQ_OGRN',
        'RQ_OGRNIP',
        'RQ_OKVED',
        'RQ_PHONE',
        'RQ_SECOND_NAME',
        'XML_ID',
        'CUSTOM_FIELDS',
    ];

    public function setDateModifyAttribute($value)
    {
        $this->attributes['DATE_MODIFY'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setDateCreateAttribute($value)
    {
        $this->attributes['DATE_CREATE'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $times = [
        'DATE_CREATE',
        'DATE_MODIFY',
    ];

    public $timestamps = false;

    public $jsonFields = [
    ];

    public function saveField($fields){
        if(isset($fields['ID'])){
            $model = self::where(['ID'=>$fields['ID']])->first();
            if(!isset($model->ID)){
                $model = new self();
            }
        }else{
            $model = new self();
        }
        $user_fields = [];
        foreach ($fields as $key=>$value){
            if(in_array($key, $this->fillable)){
                if(in_array($key, $this->jsonFields)){
                    $model->$key = $value ? json_encode($value) : json_encode([]);
                }else{
                    if($value)
                        $model->$key = $value;
                }
            }else{
                if($value)
                    $user_fields[$key] = $value;
            }
        }
        $model->CUSTOM_FIELDS = json_encode($user_fields);
        $model->save();
    }
}
