<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Tasks</h2>
                <p>Check your tasks and create new ones.</p>
                <p><?= Yii::$app->user->isGuest
                        ? Html::a('Login', ['users/login'],['class' => 'btn btn-primary'])
                        : Html::a('Tasks >>', ['tasks/index'],['class' => 'btn btn-success'])
                    ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Statuses</h2>
                <p>Edit statuses list.</p>
                <p><?= Yii::$app->user->isGuest
                        ? Html::a('Login', ['users/login'],['class' => 'btn btn-primary'])
                        : Html::a('Statuses >>', ['status/index'],['class' => 'btn btn-success'])
                    ?></p>
            </div>
        </div>

    </div>
</div>
