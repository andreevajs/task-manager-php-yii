<?php

namespace app\models;

use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title','description'], 'string'],
            [['id','status_id','author_id','executor_id'], 'integer'],
            [['creation_date','stop_date'], 'date'],
            [['work_cost_assumption'], 'time'],
            ['status_id','validateStatus'],
            ['executor_id','validateExecutor']
        ];
    }

    public static function tableName()
    {
        return "{{tasks}}";
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && !\Yii::$app->user->isGuest) {
                $this->author_id = \Yii::$app->user->id;
                $this->creation_date = date('Y-m-d');
            } else {
                $this->creation_date = date('Y-m-d',strtotime($this->creation_date));
                if ($this->stop_date != null) {
                    $this->stop_date = date('Y-m-d',strtotime($this->stop_date));
                }
            }
            return true;
        }
        return false;
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
