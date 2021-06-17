<?php


namespace app\services;


use app\models\TaskObserver;
use Yii;
use yii\data\Pagination;

class TaskOberversService
{
    private $tasksService;
    private $usersService;


    public function __construct($tasksService,$usersService)
    {
        $this->tasksService = $tasksService;
        $this->usersService = $usersService;
    }

    public function userObservesTask($user_id, $task_id)
    {
        return TaskObserver::find()
            ->where(['task_id'=>$task_id])
            ->andWhere(['user_id'=>$user_id])
            ->exists();
    }

    public function getUsersWhoObserveTask($task_id)
    {
        $query = TaskObserver::find()
            -> where(['task_id'=>$task_id]);

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);

        $observers = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $users = [];
        foreach ($observers as $observer){
            $user = $this->usersService->getUserById($observer->user_id);
            $users[]=$this->usersService->mapUserToUserListItem($user);
        }

        return [
            'users' => $users,
            'pagination' => $pagination
        ];
    }

    public function observeTask($task_id) : bool
    {
        $user_id = Yii::$app->user->id;

        if (!$this->tasksService->taskExists($task_id)
            || $this->userObservesTask($user_id, $task_id)){
            return false;
        }

        $taskObserver = new TaskObserver();
        $taskObserver->task_id = $task_id;
        $taskObserver->user_id = $user_id;
        return $taskObserver->save();
    }

    public function stopObservingTask($task_id)
    {
        $user_id = Yii::$app->user->id;
        TaskObserver::findOne(['task_id' => $task_id, 'user_id'=>$user_id])->delete();
    }
}