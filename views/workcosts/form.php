<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $workcostForm app\models\WorkcostForm */
/* @var $task_title string */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add work cost';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">
    <h1>Add work cost to task "<?=$task_title?>"</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'status',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>"
        ],
    ]); ?>

    <?= $form->field($workcostForm, 'days')->textInput(['type'=>'number','min'=>0])?>
    <?= $form->field($workcostForm, 'hours')->textInput(['type'=>'number','max'=>23,'min'=>0])?>
    <?= $form->field($workcostForm, 'minutes')->textInput(['type'=>'number','max'=>59,'min'=>0])?>
    <?= $form->field($workcostForm, 'comment')->textarea(['rows'=>3])?>

    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>

    <?php ActiveForm::end(); ?>
</div>
