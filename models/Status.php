<?php

namespace app\models;

use yii\db\ActiveRecord;

class Status extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['id'], 'integer'],
        ];
    }

    public static function tableName()
    {
        return "{{statuses}}";
    }
}
