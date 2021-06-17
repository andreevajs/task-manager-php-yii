<?php

/* @var $search app\models\Search */
/* @var $tasks app\models\TaskListItem */
/* @var $view_tasks_search string */
/* @var $pagination \yii\data\Pagination */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="btn-group" role="group">
    <?= Html::a('All tasks', ['tasks/index'],['class' => 'btn btn-primary','type'=>'button']) ?>
    <?=  Html::a('My TO DO', ['tasks/todo'],['class' => 'btn btn-success','type'=>'button']) ?>
    <?= Html::a('My Created', ['tasks/created'],['class' => 'btn btn-warning','type'=>'button']) ?>
</div>
- - -
<?= Html::a('Create new task', ['tasks/create'],['class' => 'btn btn-primary']) ?>

<div class="mt-3">
    <ul class="list-group">
        <li class="list-group-item">
            <?=$view_tasks_search?>
        </li>
        <?php foreach ($tasks as $task): ?>
            <li class="list-group-item">
                <a href="<?=Url::toRoute(['tasks/view', 'id' => $task->id]);?>">
                    <span class="alert-warning"><?= $task->author ?></span>
                    says
                    <span class="alert-success"> <?= $task->executor != null ? $task->executor : 'somebody' ?></span>
                    must close
                    <span class="alert-info"><?= $task->title ?></span>
                    by
                    <span class="alert-warning"> <?= $task->stop_date != null ? $task->stop_date : 'someday' ?> </span>
                    <?= Html::a('edit', ['tasks/edit', 'id' => $task->id],['class' => 'badge btn-warning']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>

