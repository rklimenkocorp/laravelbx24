<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'b24_products';

    protected $fillable = [
        'ACTIVE',
        'CATALOG_ID',
        'CODE',
        'CREATED_BY',
        'DATE_CREATE',
        'DESCRIPTION',
        'ID',
        'MEASURE',
        'MODIFIED_BY',
        'NAME',
        'PRICE',
        'SECTION_ID',
        'XML_ID',
        'CUSTOM_FIELDS',
    ];

    public $timestamps = false;

    public $jsonFields = [
    ];


    public function setDateCreateAttribute($value)
    {
        $this->attributes['DATE_CREATE'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $times = [
        'DATE_CREATE',
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
