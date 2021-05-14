<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
    <h1>Users</h1>
    <ul>
        <?php foreach ($users as $status): ?>
            <li>
                <?= Html::encode("({$users->login})") ?>
                creation date: <?= Html::encode("({$users->creation_date})") ?>
                email: <?= Html::encode("({$users->email})") ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>