<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $task app\models\TaskForm */
/* @var $statuses app\models\Status */
/* @var $users app\models\User */

use app\models\Status;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-edit">
    <h1><?= Html::encode($task->id == 0 ? 'Create task' : 'Edit task') ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'task-edit-form',
        'layout' => 'horizontal',
        'method' => 'put',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <div style="display: none">
        <?= $form->field($task, 'id')->hiddenInput() ?>
    </div>

    <?= $form->field($task, 'title')->textInput() ?>

    <div>
        <?= $form->field($task, 'stop_date')->widget(DatePicker::class, ['clientOptions' => ['dateFormat' => 'yyyy-mm-dd']])?>
        <?= $form->field($task, 'stop_hour')->textInput(['type'=>'number','max'=>23,'min'=>0])?>
        <?= $form->field($task, 'stop_min')->textInput(['type'=>'number','max'=>59,'min'=>0])?>
    </div>

    <div>
        <?= $form->field($task, 'work_cost_day')->textInput(['type'=>'number','min'=>0])?>
        <?= $form->field($task, 'work_cost_hour')->textInput(['type'=>'number','max'=>23,'min'=>0])?>
        <?= $form->field($task, 'work_cost_min')->textInput(['type'=>'number','max'=>59,'min'=>0])?>
    </div>

    <?= $form->field($task, 'status_id')->dropDownList(
        ArrayHelper::map($statuses,'id','name'),
        ['prompt'=>'Select Status'])?>

    <?= $form->field($task, 'executor_id')->dropDownList(
        ArrayHelper::map($users,'id','login'),
        ['prompt'=>'Select Executor'])?>

    <?= $form->field($task, 'description')->textarea(['rows'=>12]) ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>