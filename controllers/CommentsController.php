<?php


namespace app\controllers;


class CommentsController extends BaseController
{
    public function actionDelete($id,$task)
    {
        $this->commentsService->deleteComment($id);
        return $this->redirect(['tasks/view','id'=>$task]);
    }
}