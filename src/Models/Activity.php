<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'b24_activities';

    public $timestamps = false;

    protected $fillable = [
        'ASSOCIATED_ENTITY_ID',
        'AUTHOR_ID',
        'COMPLETED',
        'CREATED',
        'DEADLINE',
        'DESCRIPTION',
        'DIRECTION',
        'EDITOR_ID',
        'END_TIME',
        'ID',
        'LAST_UPDATED',
        'OWNER_ID',
        'OWNER_TYPE_ID',
        'PRIORITY',
        'RESPONSIBLE_ID',
        'PROVIDER_TYPE_ID',
        'PROVIDER_ID',
        'START_TIME',
        'SETTINGS',
        'STATUS',
        'SUBJECT',
        'TYPE_ID',
        'CUSTOM_FIELDS',
    ];

    public function setStartTimeAttribute($value)
    {
        $this->attributes['START_TIME'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setLastUpdatedAttribute($value)
    {
        $this->attributes['LAST_UPDATED'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['END_TIME'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setCreatedAttribute($value)
    {
        $this->attributes['CREATED'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }
    public function setDeadlineAttribute($value)
    {
        $this->attributes['DEADLINE'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $times = [
        'START_TIME',
        'LAST_UPDATED',
        'END_TIME',
        'CREATED',
        'DEADLINE',
    ];

    public $jsonFields = [
        'SETTINGS',
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
