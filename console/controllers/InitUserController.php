<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use common\models\activerecords\User;

/**
 * insert default user
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class InitUserController extends Controller
{
    public $username;
    public $email;
    public $password;

    public function options()
    {
        return ['username', 'password', 'email'];
    }

    public function optionAliases()
    {
        return [
            'u' => 'username',
            'p' => 'password',
            'e' => 'email'
        ];
    }

    public function actionIndex()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        if ($user->save()) {
            echo "insert user success\n";
        }
        return ExitCode::OK;
    }
}
