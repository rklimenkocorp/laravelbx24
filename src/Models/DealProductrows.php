<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class DealProductrows extends Model
{
    protected $table = 'b24_dealproducts';

    protected $fillable = [
        'DISCOUNT_RATE',
        'DISCOUNT_SUM',
        'DISCOUNT_TYPE_ID',
        'MEASURE_CODE',
        'MEASURE_NAME',
        'ORIGINAL_PRODUCT_NAME',
        'OWNER_ID',
        'OWNER_TYPE',
        'PRICE',
        'PRICE_BRUTTO',
        'PRICE_EXCLUSIVE',
        'PRICE_NETTO',
        'PRODUCT_ID',
        'PRODUCT_NAME',
        'QUANTITY',
        'TAX_INCLUDED',
        'TAX_RATE',
        'CUSTOM_FIELDS',
    ];

    public $jsonFields = [
    ];

    public $timestamps = false;

    public function saveField($fields, $id_deal){
        if($id_deal){
            self::where('OWNER_ID', $id_deal)->delete();
        }

        foreach ($fields as $product){
            $model = new self();
            $user_fields = [];
            foreach ($product as $key=>$value){
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
}
