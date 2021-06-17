<?php

namespace app\controllers;

use app\models\CommentForm;
use app\models\SearchField;
use app\models\SearchForm;
use app\models\Task;
use app\models\TaskForm;
use app\models\TaskObserver;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class TasksController extends BaseController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create','delete','edit','todo','created'],
                'rules' => [
                    [
                        'actions' => ['create','delete','edit','todo','created'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $searchForm = new SearchForm();
        $searchForm->load($this->request->getQueryParams());

        $dataProvider = new ActiveDataProvider([
            'query' => $this->tasksService->getSearchQuery($searchForm),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm,
            'statuses' => $this->statusesService->getStatuses(),
            'users' => $this->usersService->getUsers()
        ]);
    }

    public function actionView($id)
    {
        $task = $this->tasksService->getTaskById($id);
        if ($task == null) {
            return $this->goBack();
        }

        $commentForm = new CommentForm();
        if ($commentForm->load(Yii::$app->request->post())
            && $this->commentsService->addComment($commentForm->text,$id)) {
            return $this->redirect(['view','id'=>$id]);
        }

        $paginatedComments = $this->commentsService->getCommentsByTaskId($id);
        $paginatedObservers = $this->taskObserversService->getUsersWhoObserveTask($id);

        return $this->render('view', [
            'task' => $this->tasksService->createModelFromTask($task),
            'view_workcosts_summary' => $this->renderPartial('//workcosts/summary',[
                'workcosts' => $this->workcostsService->getWorkcostsByTaskId($id)
            ]),
            'view_comments_list' => $this->renderPartial('//comments/list',[
                'commentForm'=> $commentForm,
                'comments' => $paginatedComments['comments'],
                'pagination' => $paginatedComments['pagination']
            ]),
            'view_tasks_observers' => $this->renderPartial('observers',[
                'users' => $paginatedObservers['users'],
                'pagination' => $paginatedObservers['pagination'],
                'currentUserIsObserver' => $this->taskObserversService->userObservesTask(Yii::$app->user->id, $id),
                'task_id' => $id
            ])
        ]);
    }

    public function actionCreate()
    {
        return $this->redirect(['edit']);
    }

    public function actionEdit($id = 0)
    {
        $task = new Task();
        if ($id != 0) {
            $task = $this->tasksService->getTaskById($id);
        }
        if ($task == null) {
            return $this->redirect(['edit']);
        }

        $taskForm = $this->tasksService->createFormForTask($task);

        if ($taskForm->load(Yii::$app->request->post())
            && $this->tasksService->saveTaskFromForm($taskForm)) {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'task' => $taskForm,
            'users' => $this->usersService->getUsers(),
            'statuses' => $this->statusesService->getStatuses()
        ]);
    }

    public function actionDelete($id)
    {
        $this->tasksService->deleteTask($id);
        return $this->redirect(['index']);
    }

    public function actionObserve($id)
    {
        $this->taskObserversService->observeTask($id);
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionStopobserve($id)
    {
        $this->taskObserversService->stopObservingTask($id);
        return $this->redirect(['view','id'=>$id]);
    }
}
