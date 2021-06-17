<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'My work costs';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<ul class="list-group">
    <?php foreach ($workcosts as $workcost): ?>
        <li class="list-group-item">
            <?=$workcost->days?>d <?=$workcost->hours?>h <?=$workcost->minutes?>m
            <?= Html::a('delete', ['workcosts/delete', 'id' => $workcost->id,'task'=>$workcost->task_id],['class' => 'badge btn-danger'])?>
            <?= Html::a('view task', ['tasks/view', 'id' => $workcost->task_id],['class' => 'badge']) ?><br/>
            <?= $workcost->comment ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php if ($pagination != null) {
    echo LinkPager::widget(['pagination' => $pagination]);
}?>