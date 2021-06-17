<?php


namespace app\models;


use yii\base\Model;

class WorkcostForm extends Model
{
    public $id;
    public $task_id;
    public $days;
    public $hours;
    public $minutes;
    public $comment;

    public function rules()
    {
        return [
            [['id','task_id','days','hours','minutes'], 'integer'],
            [['comment'], 'string']
        ];
    }
}