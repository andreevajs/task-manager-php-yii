<?php

/* @var $dataProvider ActiveDataProvider */
/* @var $searchForm SearchForm */

use app\models\SearchForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
?>

<?= Html::a('Create new task', ['tasks/create'],['class' => 'btn btn-success btn-block']) ?>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchForm,
    'columns' =>[
        [
            'attribute'=>'title',
            'filterAttribute'=>'title_part',
            'header'=>'Title'
        ],
        [
            'attribute'=>'creation_date',
            'header'=>'Created interval',
            'filter' => Html::tag('div',
                DatePicker::widget([
                    'model'=>$searchForm, 'attribute'=>'date_from',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class'=>'form-control col-lg-2']]).
                DatePicker::widget([
                    'model'=>$searchForm, 'attribute'=>'date_to',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class'=>'form-control col-lg-2']])),
            'format'=>['date', 'php:Y-m-d (H:i)']
        ],
        [
            'attribute' => 'status_id',
            'header' => 'Status',
            'filterAttribute'=>'status_id',
            'filter' => ArrayHelper::map($statuses, 'id', 'name'),
            'content' => function($model) { return $model['status']; }
        ],
        [
            'attribute' => 'author_id',
            'header' => 'Author',
            'filterAttribute'=>'author_id',
            'filter' => ArrayHelper::map($users, 'id', 'login'),
            'content' => function($model) { return $model['author']; }
        ],
        [
            'attribute' => 'executor_id',
            'header' => 'Executor',
            'filterAttribute'=>'executor_id',
            'filter' => ArrayHelper::map($users, 'id', 'login'),
            'content' => function($model) { return $model['executor']; }
        ],
        [
            'header'=>'Actions',
            'content' => function($model)
            {
                return Html::tag('div',
                    Html::a('edit', ['tasks/edit', 'id' => $model['id']], ['class' => 'badge']).
                    Html::a('view', ['tasks/view', 'id' => $model['id']], ['class' => 'badge'])
                );
            }
        ]
    ]
])?>
