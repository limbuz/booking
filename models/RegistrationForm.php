<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $confirm;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirm', 'email'], 'required'],
            [['password'], 'string', 'min' => 8],
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'confirm' => 'Повторите пароль',
            'email' => 'E-mail',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->confirm) {
                $this->addError($attribute, 'Passwords doesn\'t match.');
            }
            if (!$this->isStrongPassword($this->password)) {
                $this->addError($attribute, 'Password is too weak. (Password must contains at least one digit and one uppercase letter)');
            }
        }
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $_user = User::findByUsername($this->username);
            if ($_user !== null) {
                $this->addError($attribute, 'This username is already taken.');
            }
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $_user = User::findOne(['email' => $this->email]);
            if ($_user !== null) {
                $this->addError($attribute, 'This e-mail is already taken.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws Exception
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();

            $user->username = $this->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->email = $this->email;

            if ($user->save()) {
                return Yii::$app->user->login($user);
            }
        }

        return false;
    }

    private function isStrongPassword($password)
    {
        if (preg_match('/[\d]/', $password) === 0) {
            return false;
        }
        if (preg_match('/[A-Z]/', $password) === 0) {
            return false;
        }

        return true;
    }
}