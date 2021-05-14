<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Task */
/* @var $statuses app\models\Status */
/* @var $users app\models\User */

use app\models\Status;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Edit task';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="task-edit">
        <h1><?= Html::encode($this->title) ?></h1>

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
            <?= $form->field($model, 'id')->hiddenInput() ?>
            <?= $form->field($model, 'author_id')->hiddenInput() ?>
            <?= $form->field($model, 'creation_date')->widget(DatePicker::class, ['clientOptions' => ['dateFormat' => 'yyyy-mm-dd']])?>
        </div>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'creation_date')->widget(DatePicker::class, ['clientOptions' => ['dateFormat' => 'yyyy-mm-dd'],'options'=>['disabled'=>'disabled']])?>
        <?= $form->field($model, 'stop_date')->widget(DatePicker::class, ['clientOptions' => ['dateFormat' => 'yyyy-mm-dd']])?>

        <?= $form->field($model, 'status_id')->dropDownList(
            ArrayHelper::map($statuses,'id','name'),
            ['prompt'=>'Select Status'])?>

        <?= $form->field($model, 'executor_id')->dropDownList(
            ArrayHelper::map($users,'id','login'),
            ['prompt'=>'Select Executor'])?>

        <?= $form->field($model, 'description')->textarea(['rows'=>12]) ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>