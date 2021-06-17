<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $login;
    public $email;
    public $password;
    public $passwordConfirm;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login','email','password','passwordConfirm'], 'required'],
            ['login', 'validateLogin'],
            ['email', 'validateEmail'],
            ['password', 'validatePasswords'],
        ];
    }

    public function validateLogin($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByUsername($this->login);

            if ($user != null) {
                $this->addError($attribute, 'Login already exists.');
            }
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email);

            if ($user != null) {
                $this->addError($attribute, 'Email already exists.');
            }
        }
    }

    public function validatePasswords($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password != $this->passwordConfirm) {
                $this->addError($attribute, 'Passwords do not match.');
            }
        }
    }
}
