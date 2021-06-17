<?php


namespace app\models;


use yii\base\Model;

class SearchForm extends Model
{
    public $author_id;
    public $executor_id;
    public $status_id;
    public $title_part;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['author_id', 'executor_id', 'status_id'], 'integer'],
            [['title_part'], 'string'],
            [['date_from', 'date_to'], 'datetime'],
        ];
    }
}