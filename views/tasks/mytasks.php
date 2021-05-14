<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'My Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<ul class="list-group">
    <?php if ($tasks == null || $tasks->isEmpty) echo 'It seems like you don\'t have any tasks.' ?>
    <?php foreach ($tasks as $task): ?>
        <li class="list-group-item">
            <?= $task->name ?>
            <?= $task->stop_date ?>
            <?= Html::a('edit', ['status/update', 'id' => $task->id],['class' => 'badge']) ?>
        </li>
    <?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
