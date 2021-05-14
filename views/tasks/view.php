<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $task app\models\Task */
/* @var $author string */
/* @var $executor string */
/* @var $comment app\models\Comment */


use app\models\Status;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

?>
<div class="task-edit">
    <?= Html::a('All tasks', ['tasks/index'],['class' => 'btn btn-primary','type'=>'button']) ?>
    <?= Html::a('Edit', ['tasks/update', 'id' => $task->id],['class' => 'btn btn-primary']) ?>

    <h1><?= Html::encode($task->title) ?></h1>
    <p class="alert-info">
        started:
        <b><?= $task->creation_date ?></b>
        - - - ends:
        <b> <?= $task->stop_date != null ? $task->stop_date : 'someday' ?> </b>
    </p>
    <p>
        <?= $task->description != null ? $task->description : 'no description' ?>
    </p>
    <?= Html::a('Delete', ['tasks/delete', 'id' => $task->id],['class' => 'btn btn-danger']) ?>
</div>