<?php


namespace app\services;


use app\models\Comment;
use app\models\CommentModel;
use Yii;
use yii\data\Pagination;

class CommentsService
{
    private $tasksService;
    private $usersService;

    public function __construct($tasksService, $usersService)
    {
        $this->tasksService = $tasksService;
        $this->usersService = $usersService;
    }

    public function getCommentsByTaskId($task_id) : array
    {
        $query = Comment::find()
            -> where(['task_id'=>$task_id]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $comments = Comment::find()
            ->where(['task_id'=>$task_id])
            ->orderBy(['creation_date'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $commentModels = [];
        foreach ($comments as $comment){
            $commentModels[] = $this->mapCommentToCommentModel($comment);
        }
        return [
            'comments' => $commentModels,
            'pagination' => $pagination
        ];
    }

    public function addComment($text, $task_id) : bool
    {
        if ($text == null || $text == ''
            || $this->tasksService->getTaskById($task_id) == null){
            return false;
        }

        $comment = new Comment();
        $comment->user_id = Yii::$app->user->id;
        $comment->task_id = $task_id;
        $comment->text = $text;
        $comment->creation_date = (new \DateTime('NOW'))->format('Y-m-d H:i:s');

        return $comment->save();
    }

    public function deleteComment($id) : bool
    {
        $comment = Comment::findOne(['id'=>$id]);
        if ($comment == null || $comment->user_id != Yii::$app->user->id) {
            return false;
        }
        return $comment->delete();
    }

    private function mapCommentToCommentModel($comment) : CommentModel
    {
        $commentModel = new CommentModel();
        $commentModel->id = $comment->id;
        $commentModel->task_id = $comment->task_id;
        $commentModel->creation_date = $comment->creation_date;
        $commentModel->text = $comment->text;
        $commentModel->user_login = $this->usersService
            ->getUserById($comment->user_id)
            ->login;
        $commentModel->editable = $comment->user_id == Yii::$app->user->id;

        return $commentModel;
    }
}