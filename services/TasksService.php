<?php

namespace app\services;

use app\models\Task;
use app\models\TaskForm;
use app\models\TaskListItem;
use app\models\TaskModel;
use app\models\TaskObserver;
use app\models\User;
use app\models\UserListItem;
use Cassandra\Date;
use DateTime;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Query;

class TasksService
{
    private $statusesService;
    private $usersService;

    public function __construct($usersService,$statusesService)
    {
        $this->statusesService = $statusesService;
        $this->usersService = $usersService;
    }

    public function getTaskById($id)
    {
        return Task::findOne(['id' => $id]);
    }

    public function taskExists($id)
    {
        return Task::find()
            ->where(['id'=>$id])
            ->exists();
    }

    public function getTasks($searchForm = null) : array
    {
        $query = Task::find();

        $this->buildQueryFromSearchForm($query,$searchForm);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $tasks = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'tasks' => $this->mapTasksToTaskListItems($tasks),
            'pagination' => $pagination,
        ];
    }

    public function getSearchQuery($searchForm)
    {
        $query = (new Query())
            ->select([
                't.id as id',
                't.title as title',
                'a.login as author','e.id as author_id',
                'e.login as executor','e.id as executor_id',
                't.stop_date as stop_date',
                't.creation_date as creation_date',
                's.name as status','s.id as status_id'])
            ->from('tasks as t')
            ->leftJoin('users as a','t.author_id = a.id')
            ->leftJoin('users as e','t.executor_id = e.id')
            ->leftJoin('statuses as s','t.status_id = s.id');

        $this->buildQueryFromSearchForm($query, $searchForm);
        return $query;
    }

    public function createTask($title) : Task
    {
        $task = new Task();
        $task->title = htmlspecialchars($title);
        $task->author_id = Yii::$app->user->id;
        $task->creation_date = (new DateTime())->format('Y-m-d H:i:s');
        return $task;
    }

    public function saveTask($task) : bool
    {
        return $task->save();
    }

    public function deleteTask($id)
    {
        $task = Task::findOne(['id' => $id]);
        if ($task != null) {
            $task->delete();
        }
    }

    public function createFormForTask($task)
    {
        $taskForm = new TaskForm();

        $taskForm->id = $task->id;
        $taskForm->title = $task->title;
        $taskForm->description = $task->description;
        $taskForm->status_id = $task->status_id;
        $taskForm->executor_id = $task->executor_id;
        if ($task->stop_date != null) {
            $taskForm->stop_date = $task->stop_date;
            $stop_date = DateTime::createFromFormat('Y-m-d H:i:s',$task->stop_date);
            $taskForm->stop_hour = intval($stop_date->format('H'));
            $taskForm->stop_min = intval($stop_date->format('i'));
        }
        if ($task->work_cost_assumption != null) {
            $work_cost = DateTime::createFromFormat('Y-m-d H:i:s',$task->creation_date)
                ->diff(DateTime::createFromFormat('Y-m-d H:i:s',$task->work_cost_assumption));
            $taskForm->work_cost_day = $work_cost->d;
            $taskForm->work_cost_hour = $work_cost->h;
            $taskForm->work_cost_min = $work_cost->i;
        }

        return $taskForm;
    }

    public function saveTaskFromForm($taskForm):bool
    {
        $task = Task::findOne($taskForm->id) ?? $this->createTask($taskForm->title);
        if ($task != null && $task->author_id != Yii::$app->user->id) {
            return false;
        }

        $task->title = $taskForm->title;
        $task->description = $taskForm->description;
        $task->status_id = $taskForm->status_id;
        $task->executor_id = $taskForm->executor_id;
        if ($taskForm->stop_date != null) {
            $task->stop_date = DateTime::createFromFormat('Y-m-d H:i:s', sprintf("%s %'.02d:%'.02d:00",
                DateTime::createFromFormat('M d, Y', $taskForm->stop_date)->format('Y-m-d'),
                $taskForm->stop_hour,
                $taskForm->stop_min))
                ->format('Y-m-d H:i:s');
        }

        $work_cost = new \DateInterval('PT0M');
        $work_cost->d = $taskForm->work_cost_day;
        $work_cost->h = $taskForm->work_cost_hour;
        $work_cost->i = $taskForm->work_cost_min;
        $creation_date = DateTime::createFromFormat('Y-m-d H:i:s', $task->creation_date);
        $task->work_cost_assumption = $creation_date->add($work_cost)->format('Y-m-d H:i:s');

        return $task->save();
    }

    public function createModelFromTask($task)
    {
        $taskModel = new TaskModel();

        $taskModel->id = $task->id;
        $taskModel->title = $task->title;
        $taskModel->description = $task->description;
        $taskModel->creation_date = $task->creation_date;
        $taskModel->stop_date = $task->stop_date;
        $taskModel->status = $this->statusesService->getStatusById($task->status_id);

        $author = $this->usersService->getUserById($task->author_id);
        $taskModel->author = $this->usersService->mapUserToUserListItem($author);

        $executor = $this->usersService->getUserById($task->executor_id);
        if ($executor != null) {
            $taskModel->executor = $this->usersService->mapUserToUserListItem($executor);
        }

        if ($task->work_cost_assumption != null) {
            $work_cost = DateTime::createFromFormat('Y-m-d H:i:s',$task->creation_date)
                ->diff(DateTime::createFromFormat('Y-m-d H:i:s',$task->work_cost_assumption));
            $taskModel->work_cost_day = $work_cost->d;
            $taskModel->work_cost_hour = $work_cost->h;
            $taskModel->work_cost_min = $work_cost->i;
        }

        return $taskModel;
    }

    private function mapTasksToTaskListItems($tasks): array
    {
        $list = [];
        foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->id = $task->id;
            $item->title = $task->title;
            $item->stop_date = $task->stop_date;
            $item->author = User::findOne(['id'=>$task->author_id])->login;
            $executor = User::findOne(['id'=>$task->executor_id]);
            $item->executor = $executor != null ? $executor->login : null;
            array_push($list,$item);
        }
        return $list;
    }

    private function buildQueryFromSearchForm($query, $searchForm)
    {
        if ($searchForm!=null) {
            if ($searchForm->title_part != null && $searchForm->title_part != ' ') {
                $query->where(['like', 't.title', $searchForm->title_part]);
            }
            if ($searchForm->status_id != null) {
                $query->andWhere(['t.status_id' => $searchForm->status_id]);
            }
            if ($searchForm->author_id != null) {
                $query->andWhere(['t.author_id' => $searchForm->author_id]);
            }
            if ($searchForm->executor_id != null) {
                $query->andWhere(['t.executor_id' => $searchForm->executor_id]);
            }
            if ($searchForm->date_from != null) {
                $date_from = DateTime::createFromFormat('Y-m-d', $searchForm->date_from)->format('Y-m-d 00:00:00');
                $query->andWhere(['>=', 't.creation_date', $date_from]);
            }
            if ($searchForm->date_to != null) {
                $date_to = DateTime::createFromFormat('Y-m-d', $searchForm->date_to)->format('Y-m-d 00:00:00');
                $query->andWhere(['<=', 't.creation_date', $date_to]);
            }
        }
    }
}