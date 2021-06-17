<?php


namespace app\services;


use app\models\Status;
use yii\data\Pagination;

class StatusesService
{
    public function getStatusById($id)
    {
        return Status::findOne(['id' => $id]);
    }

    public function getStatuses() : array
    {
        return Status::find()->all();
    }

    public function getPaginatedStatuses() : array
    {
        $query = Status::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $statuses = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'statuses' => $statuses,
            'pagination' => $pagination,
        ];
    }

    public function saveStatus($status) : bool
    {
        $status->name = htmlspecialchars($status->name);
        return $status->save();
    }

    public function deleteStatus($id)
    {
        $status = Status::findOne(['id' => $id]);
        if ($status != null) {
            $status->delete();
        }
    }
}