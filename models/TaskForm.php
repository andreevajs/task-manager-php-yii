<?php

namespace app\models;

use yii\base\Model;

class TaskForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $status_id;
    public $executor_id;
    public $stop_date;
    public $stop_hour;
    public $stop_min;
    public $work_cost_day;
    public $work_cost_hour;
    public $work_cost_min;


    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title','description'], 'string'],
            [['id','status_id','author_id','executor_id','stop_hour','stop_min','work_cost_day','work_cost_hour','work_cost_min'], 'integer'],
            [['creation_date','stop_date'], 'date'],
            [['work_cost_assumption'], 'time'],
            ['status_id','validateStatus'],
            ['executor_id','validateExecutor']
        ];
    }

    public function validateStatus($status_id)
    {
        return $status_id == null || Status::findOne(['id'=>$status_id]) != null;
    }

    public function validateExecutor($executor_id)
    {
        return $executor_id == null || User::findOne(['id'=>$executor_id]) != null;
    }
}
