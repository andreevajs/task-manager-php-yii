<?php

namespace app\controllers;

use app\models\StatusForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Status;

class StatusController extends Controller
{
    public function actionIndex()
    {
        $query = Status::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $statuses = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'statuses' => $statuses,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $model = new Status;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Status::findOne(['id'=>$id]);
        if ($model != null && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $model = Status::findOne(['id'=>$id]);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Status::findOne(['id' => $id]);
        if ($model != null) {
            $model->delete();
        }

        return $this->goBack();
    }
}
