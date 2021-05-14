<?php

namespace app\controllers;

use app\models\Search;
use app\models\Task;
use app\models\TaskForm;
use app\models\TaskListItem;
use app\models\User;
use app\models\UserListItem;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Status;

class TasksController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create','delete','update','todo','created'],
                'rules' => [
                    [
                        'actions' => ['create','delete','update','todo','created'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'todo' => ['get'],
                    'created' => ['get'],
                    'create' => ['get','post'],
                    'update' => ['get','put'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->showListView('index',[]);
    }

    public function actionTodo()
    {
        return $this->showListView('index',['executor_id'=>Yii::$app->user->id]);
    }

    public function actionCreated()
    {
        return $this->showListView('index',['author_id'=>Yii::$app->user->id]);
    }

    public function actionView($id)
    {
        $task = Task::findOne(['id' => $id]);
        if ($task == null) {
            return $this->goBack();
        }

        return $this->render('view', [
            'task' => $task,
        ]);
    }

    public function actionCreate()
    {
        $model = new Task;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view','id'=>$model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Task::findOne(['id' => $id]);
        if ($model != null && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view','id'=>$model->id]);
        }

        return $this->render('update', [
            'model' => Task::findOne(['id' => $id]),
            'users' => $this->mapUsersToUserListItems(User::find()->all()),
            'statuses' => Status::find()->all()
        ]);
    }

    public function actionDelete($id)
    {
        $model = Task::findOne(['id' => $id]);
        if ($model != null) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    private function showListView($view, $condition)
    {
        $query = Task::find()
            -> where($condition);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $tasks = Task::find()
            ->where($condition)
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render($view, [
            'tasks' => $this->mapTasksToTaskListItems($tasks),
            'pagination' => $pagination,
        ]);
    }

    private function mapTasksToTaskListItems($tasks)
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

    private function mapUsersToUserListItems($users)
    {
        $list = [];
        foreach ($users as $user) {
            $item = new UserListItem();
            $item->id = $user->id;
            $item->login = $user->login;
            array_push($list,$item);
        }
        return $list;
    }
}
