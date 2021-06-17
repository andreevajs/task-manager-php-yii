<?php


namespace app\controllers;


use app\models\WorkcostForm;
use Yii;

class WorkcostsController extends BaseController
{
    public function actionMy()
    {
        return $this->render('list', $this->workcostsService->getPaginatedWorkcostsByUserId(Yii::$app->user->id));
    }

    public function actionAdd($task)
    {
        $workcostForm = new WorkcostForm();
        if ($workcostForm->load(Yii::$app->request->post())
            && $this->workcostsService->addWorkcost($workcostForm,$task)) {
            return $this->redirect(['tasks/view','id'=>$task]);
        }

        return $this->render('form',[
            'workcostForm' => $workcostForm,
            'task_title' => $this->tasksService->getTaskById($task)->title
        ]);
    }

    public function actionDelete($id,$task)
    {
        $this->workcostsService->deleteWorkCost($id);
        return $this->redirect(['tasks/view','id'=>$task]);
    }
}