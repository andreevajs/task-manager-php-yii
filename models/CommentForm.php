<?php


namespace app\models;


use yii\base\Model;

class CommentForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            ['text','validateText']
        ];
    }

    public function validateText($text)
    {
        return $text != null || $text != '';
    }
}