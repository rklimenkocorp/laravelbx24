<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'b24_leads';

    protected $fillable = [
        'ID',
        'TITLE',
        'STATUS_ID',
        'STATUS_SEMANTIC_ID',
        'SOURCE_ID',
        'SOURCE_DESCRIPTION',
        'SECOND_NAME',
        'PHONE',
        'ORIGIN_ID',
        'ORIGINATOR_ID',
        'OPPORTUNITY',
        'CURRENCY_ID',
        'MODIFY_BY_ID',
        'LAST_NAME',
        'COMMENTS',
        'CREATED_BY_ID',
        'ASSIGNED_BY_ID',
        'COMPANY_ID',
        'CONTACT_ID',
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

    public $jsonFields = [
        'PHONE',
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
