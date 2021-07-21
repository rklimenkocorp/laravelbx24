<?php

namespace Mind4me\Bx24_integration\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'b24_tasks';

    protected $fillable = [
        'accomplices',
        'activityDate',
        'auditors',
        'changedBy',
        'changedDate',
        'createdBy',
        'createdDate',
        'deadline',
        'description',
        'forumId',
        'closedDate',
        'forumTopicId',
        'groupId',
        'guid',
        'group',
        'id',
        'responsibleId',
        'status',
        'statusChangedBy',
        'stageId',
        'title',
        'CUSTOM_FIELDS',
    ];

    public $timestamps = false;


    public function setActivityDateAttribute($value)
    {
        $this->attributes['activityDate'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setChangedDateAttribute($value)
    {
        $this->attributes['changedDate'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setClosedDateAttribute($value)
    {
        $this->attributes['closedDate'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public function setCreatedDateAttribute($value)
    {
        $this->attributes['createdDate'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] =  date_format(date_create($value), 'Y-m-d H:i:s');
    }

    public $times = [
        'activityDate',
        'changedDate',
        'closedDate',
        'createdDate',
        'deadline',
    ];

    public $jsonFields = [
        'accomplices',
        'auditors',
        'group',
    ];

    public function saveField($fields){
        if(isset($fields['id'])){
            $model = self::where(['id'=>$fields['id']])->first();
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
