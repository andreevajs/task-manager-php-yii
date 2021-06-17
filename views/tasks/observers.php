<?php

/* @var $users array */
/* @var $pagination \yii\data\Pagination */
/* @var $currentUserIsObserver bool */
/* @var $task_id int */

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<div>
    <b>Task observers: </b>
    <?= $currentUserIsObserver
        ? Html::a('stop observing', ['tasks/stopobserve','id'=>$task_id],['class' => 'btn-primary btn-sm'])
        : Html::a('observe', ['tasks/observe','id'=>$task_id],['class' => 'btn-primary btn-sm'])
    ?>
    <br/>
    <?php foreach ($users as $user): ?>
        <span class="badge">
            <?=$user->login?>
        </span>
    <?php endforeach; ?>

    <?php if ($pagination != null) {
        echo LinkPager::widget(['pagination' => $pagination]);
    }?>
</div>