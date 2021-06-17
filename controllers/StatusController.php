<?php

namespace app\controllers;

use Yii;
use app\models\Status;

class StatusController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index', $this->statusesService->getPaginatedStatuses());
    }

    public function actionCreate()
    {
        $status = new Status;
        if ($status->load(Yii::$app->request->post())
            && $this->statusesService->saveStatus($status)) {
                return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $status,
        ]);
    }

    public function actionUpdate($id)
    {
        $status = $this->statusesService->getStatusById($id);
        if ($status != null
            && $status->load(Yii::$app->request->post())
            && $this->statusesService->saveStatus($status)) {
            return $this->redirect(['index']);
        }

        $status = $this->statusesService->getStatusById($id);
        return $this->render('update', [
            'model' => $status,
        ]);
    }

    public function actionDelete($id)
    {
        $this->statusesService->deleteStatus($id);
        return $this->goBack();
    }
}
