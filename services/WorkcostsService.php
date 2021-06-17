<?php


namespace app\services;


use app\models\Workcost;
use app\models\WorkCostModel;
use Yii;
use yii\data\Pagination;

class WorkcostsService
{
    private $tasksService;
    private $usersService;

    public function __construct($tasksService, $usersService)
    {
        $this->tasksService = $tasksService;
        $this->usersService = $usersService;
    }

    public function getWorkcostsByTaskId($task_id) : array
    {
        $workcosts = Workcost::findAll(['task_id'=>$task_id]);

        $workcostModels = [];
        foreach ($workcosts as $workcost){
            $workcostModels[] = $this->mapWorkCostToWorkcostModel($workcost);
        }
        return $workcostModels;
    }

    public function getPaginatedWorkcostsByUserId($user_id) : array
    {
        $query = Workcost::find()
            -> where(['user_id'=>$user_id]);

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);

        $workcosts = Workcost::find()
            ->where(['user_id'=>$user_id])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $workcostModels = [];
        foreach ($workcosts as $workcost){
            $workcostModels[] = $this->mapWorkCostToWorkcostModel($workcost);
        }

        return [
            'workcosts' => $workcostModels,
            'pagination' => $pagination
        ];
    }

    public function addWorkcost($workcostForm, $task_id) : bool
    {
        $workcost = new Workcost();
        $workcost->user_id = Yii::$app->user->id;
        $workcost->task_id = $task_id;
        $workcost->days = $workcostForm->days ?? 0;
        $workcost->hours = $workcostForm->hours ?? 0;
        $workcost->minutes = $workcostForm->minutes ?? 0;
        $workcost->comment = $workcostForm->comment;

        return $workcost->save();
    }

    public function deleteWorkCost($id) : bool
    {
        $workcost = Workcost::findOne(['id'=>$id]);
        if ($workcost == null || $workcost->user_id != Yii::$app->user->id) {
            return false;
        }
        return $workcost->delete();
    }

    private function mapWorkCostToWorkcostModel($workcost)
    {
        $workcostModel = new WorkCostModel();
        $workcostModel->id = $workcost->id;
        $workcostModel->task_id = $workcost->task_id;
        $workcostModel->user = $this->usersService
            ->mapUserToUserListItem($this->usersService
            ->getUserById($workcost->user_id));
        $workcostModel->editable = $workcost->user_id == Yii::$app->user->id;
        $workcostModel->hours=$workcost->hours;
        $workcostModel->minutes=$workcost->minutes;
        $workcostModel->days=$workcost->days;
        $workcostModel->comment=$workcost->comment;

        return $workcostModel;
    }
}