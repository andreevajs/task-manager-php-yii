<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\RegisterFrom;
use Yii;
use app\models\Post;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UsersController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registerForm = new RegisterForm();
        if ($registerForm->load(\Yii::$app->request->post())
            && $registerForm->validate()
            && $this->usersService->registerUser($registerForm->login, $registerForm->email, $registerForm->password)) {

            $loginForm = new LoginForm();
            $loginForm->login = $registerForm->login;

            return $this->render('login', [
                'model' => $loginForm,
            ]);
        }

        $registerForm->password = '';
        return $this->render('register', [
            'model' => $registerForm,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new LoginForm();
        if ($loginForm->load(\Yii::$app->request->post())
            && $loginForm->validate()
            && $this->usersService->loginUser($loginForm->login, $loginForm->password, $loginForm->rememberMe)) {
            return $this->goBack();
        }

        $loginForm->password = '';
        return $this->render('login', [
            'model' => $loginForm,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
