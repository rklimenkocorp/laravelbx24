<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'b24_users';

    protected $fillable = [
        'ID',
        'ACTIVE',
        'EMAIL',
        'DATE_REGISTER',
        'NAME',
        'LAST_NAME',
        'SECOND_NAME',
        'PERSONAL_GENDER',
        'PERSONAL_PHOTO',
        'PERSONAL_BIRTHDAY',
        'PERSONAL_PHONE',
        'PERSONAL_MOBILE',
        'PERSONAL_CITY',
        'PERSONAL_STATE',
        'WORK_POSITION',
        'UF_DEPARTMENT',
        'CUSTOM_FIELDS',
    ];

    public $timestamps = false;

    public function setDateRegisterAttribute($value)
    {
        $this->attributes['DATE_REGISTER'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setPersonalBirthdayAttribute($value)
    {
        $this->attributes['PERSONAL_BIRTHDAY'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $times = [
        'DATE_REGISTER',
        'PERSONAL_BIRTHDAY',
    ];

    public $jsonFields = [
        'UF_DEPARTMENT',
    ];

    public function saveField($fields){
        if(isset($fields['ID'])){
            $model = self::where(['ID'=>$fields['ID']])->first();
            if(!isset($model->id)){
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
