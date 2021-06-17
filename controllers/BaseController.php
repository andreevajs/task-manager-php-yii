<?php


namespace app\controllers;


use app\services\CommentsService;
use app\services\StatusesService;
use app\services\TaskOberversService;
use app\services\TasksService;
use app\services\UsersService;
use app\services\WorkcostsService;
use yii\web\Controller;

class BaseController extends Controller
{
    protected $tasksService;
    protected $usersService;
    protected $statusesService;
    protected $commentsService;
    protected $workcostsService;
    protected $taskObserversService;

    function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->usersService = new UsersService();
        $this->statusesService = new StatusesService();
        $this->tasksService = new TasksService(
            $this->usersService,
            $this->statusesService);
        $this->commentsService = new CommentsService(
            $this->tasksService,
            $this->usersService
        );
        $this->workcostsService = new WorkcostsService(
            $this->tasksService,
            $this->usersService
        );
        $this->taskObserversService = new TaskOberversService(
            $this->tasksService,
            $this->usersService
        );
    }
}