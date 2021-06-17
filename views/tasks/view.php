<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $task app\models\TaskModel */
/* @var $author string */
/* @var $executor string */
/* @var $commentForm app\models\CommentForm */
/* @var $comments array */
/* @var $workcosts array */
/* @var $pagination Pagination */

use app\models\Status;
use app\models\User;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;

?>
<div class="task-edit">
    <?= Html::a('All tasks', ['tasks/index'],['class' => 'btn btn-primary','type'=>'button']) ?>
    - - -
    <?= Html::a('Edit', ['tasks/edit', 'id' => $task->id],['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['tasks/delete', 'id' => $task->id],['class' => 'btn btn-danger']) ?>

    <h1><?= Html::encode($task->title) ?></h1>
    <p class="alert-info">
        started:
        <b><?= $task->creation_date ?></b>
        - - - ends:
        <b> <?= $task->stop_date != null ? $task->stop_date : 'someday' ?> </b>
    </p>

    <p><b>Author: </b> <?=$task->author->login?> </p>
    <p><b>Executor: </b> <?=$task->executor == null ? 'nobody' : $task->executor->login?> </p>
    <p><b>Status: </b> <?=$task->status == null ? 'none' : $task->status->name?> </p>

    <p><b>Description: </b>
        <?= $task->description != null ? $task->description : 'no description' ?>
    </p>

    <p><b>Work cost prediction: </b>
        <?=$task->work_cost_day?> days,
        <?=$task->work_cost_hour?> hours,
        <?=$task->work_cost_min?> min.
        <?= Html::a('add work cost', ['workcosts/add','task'=>$task->id],['class' => 'btn-primary btn-sm']) ?>
    </p>

    <?=$view_workcosts_summary?>
    <?=$view_tasks_observers?>
    <?=$view_comments_list?>
</div>