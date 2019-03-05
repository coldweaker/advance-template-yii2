<?php

namespace frontend\components;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Extended yii\web\User
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class User extends \yii\web\User
{
    /**
     * @return string `username`
     */
    public function getUsername()
    {
        return $this->identity->username;
    }

    /**
     * @return string `role user`
     */
    public function getRolenames()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->getId());
        $names = [];
        foreach ($roles as $key => $role) {
            $names[] = $role->name;
        }
        return implode(", ", $names);
    }
}
