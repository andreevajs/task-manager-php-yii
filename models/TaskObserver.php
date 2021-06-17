<?php


namespace app\models;


use yii\db\ActiveRecord;

class TaskObserver extends ActiveRecord
{
    public static function tableName()
    {
        return "{{task_observers}}";
    }
}