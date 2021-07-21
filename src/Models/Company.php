<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'b24_companies';

    protected $fillable = [
        'ID',
        'TITLE',
        'COMPANY_TYPE',
        'ASSIGNED_BY_ID',
        'CREATED_BY_ID',
        'MODIFY_BY_ID',
        'COMMENTS',
        'DATE_CREATE',
        'DATE_MODIFY',
        'ORIGIN_ID',
        'UF_CRM_COMPANYINN',
        'UF_CRM_COMPANYKPP',
        'UF_CRM_POTENTIAL',
        'UF_MAIN_COMPANY_YN',
        'UF_HOLDING',
        'UF_MAIN_COMPANY',
        'PHONE',
        'EMAIL',
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
