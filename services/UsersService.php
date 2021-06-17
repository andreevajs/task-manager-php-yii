<?php


namespace app\services;


use app\models\User;
use app\models\UserListItem;
use Yii;
use yii\db\Exception;

class UsersService
{
    public function getUserById($id)
    {
        return User::findOne(['id'=>$id]);
    }

    public function getUsers() : array
    {
        $users = User::find()->all();
        $userListItems = [];
        foreach ($users as $user) {
            $userListItems[] = $this->mapUserToUserListItem($user);
        }
        return $userListItems;
    }


    public function registerUser($login, $email, $password) : bool
    {
        $user = new User();
        $user->login = $login;
        $user->email = $email;
        $user->password = $password;
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->creation_date = (new \DateTime())->format('Y-m-d H:i:s');
        return $this->saveUser($user);
    }

    public function loginUser($login, $password, $remember)
    {
        $user = User::findOne(['login'=>$login,'password'=>$password]);
        if ($user == null) {
            return false;
        }
        return Yii::$app->user->login($user, $remember ? 3600*24*30 : 0);
    }

    public function saveUser($user) : bool
    {
        return $user->save();
    }

    public function deleteUser($id)
    {
        $user = User::findOne(['id' => $id]);
        if ($user != null) {
            $user->delete();
        }
    }

    public function mapUserToUserListItem($user)
    {
        if ($user == null) {
            return null;
        }

        $item = new UserListItem();
        $item->id = $user->id;
        $item->login = $user->login;
        return $item;
    }
}