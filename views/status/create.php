<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Status */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Create status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter status name:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'status',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
