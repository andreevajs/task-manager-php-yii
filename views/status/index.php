<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="list-group">
        <?php foreach ($statuses as $status): ?>
            <li class="list-group-item">
                <?= $status->name ?>
                <?= Html::a('delete', ['status/delete', 'id' => $status->id],['class' => 'badge']) ?>
                <?= Html::a('edit', ['status/update', 'id' => $status->id],['class' => 'badge']) ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
<?= Html::a('Add status', ['status/create'],['class' => 'btn btn-primary']) ?>

