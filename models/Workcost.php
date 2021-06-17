<?php


namespace app\models;


use yii\db\ActiveRecord;

class Workcost extends ActiveRecord
{
    public static function tableName()
    {
        return "{{workcosts}}";
    }
}