<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TaskListItem extends Model
{
    public  $id;
    public $title;
    public $author;
    public $executor;
    public $stop_date;
}
