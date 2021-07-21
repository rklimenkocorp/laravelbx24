<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'b24_contacts';

    protected $fillable = [
        'ASSIGNED_BY_ID',
        'COMPANY_ID',
        'CREATED_BY_ID',
        'DATE_CREATE',
        'DATE_MODIFY',
        'ID',
        'LAST_NAME',
        'MODIFY_BY_ID',
        'NAME',
        'ORIGIN_ID',
        'PHONE',
        'EMAIL',
        'SECOND_NAME',
        'TYPE_ID',
        'CUSTOM_FIELDS',
    ];

    public $times = [
        'DATE_CREATE',
        'DATE_MODIFY',
    ];


    public function setDateModifyAttribute($value)
    {
        $this->attributes['DATE_MODIFY'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setDateCreateAttribute($value)
    {
        $this->attributes['DATE_CREATE'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $jsonFields = [
        'PHONE',
        'EMAIL',
    ];

    public $timestamps = false;

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
