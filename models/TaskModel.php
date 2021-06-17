<?php


namespace app\models;


use yii\base\Model;

class TaskModel extends Model
{
    public $id;
    public $title;
    public $description;
    public $status;
    public $author;
    public $executor;
    public $creation_date;
    public $stop_date;
    public $work_cost_day;
    public $work_cost_hour;
    public $work_cost_min;
}