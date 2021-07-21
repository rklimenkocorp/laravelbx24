<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'b24_deals';

    protected $fillable = [
        'ID',
        'TITLE',
        'TYPE_ID',
        'STAGE_ID',
        'OPPORTUNITY',
        'LEAD_ID',
        'COMPANY_ID',
        'CONTACT_ID',
        'ASSIGNED_BY_ID',
        'CREATED_BY_ID',
        'DATE_CREATE',
        'DATE_MODIFY',
        'COMMENTS',
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
    ];

    public function test(){
        $key = 'ID';
        $model = new self();
        $model->$key = '234';
    }


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
