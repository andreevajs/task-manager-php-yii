<?php

/* @var $commentForm app\models\CommentForm */
/* @var $comments array */
/* @var $pagination Pagination */

use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<div class="mt-3">
    <?=count($comments)?> comments
    <li class="list-group-item">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($commentForm, 'text')->textarea(['rows'=>3])->label('Add comment:') ?>
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>

        <?php ActiveForm::end(); ?>
    </li>
    <ul class="list-group">
        <?php foreach ($comments as $comment): ?>
            <li class="list-group-item">
                <span class="alert-warning"><?= $comment->user_login ?></span>:
                <?= $comment->text ?>

                <?= $comment->editable ?
                    Html::a('delete', ['comments/delete', 'id' => $comment->id,'task'=>$comment->task_id],['class' => 'badge btn-danger']) : ''
                ?>
                <br/>
                <p class="text-muted"><?= $comment->creation_date ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>