<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\Html;
use common\models\activerecords\User;

/**
 * Class helper for user
 */
class UserHelper
{
    /**
     * @param array $roles
     * @return array data user with id and username
     */
    public static function findAllByRoles(array $roles)
    {
        $allUserIds = [];
        foreach ($roles as $key => $role) {
            $userIds = Yii::$app->authManager->getUserIdsByRole($role);
            $allUserIds = array_merge($allUserIds, $userIds);
        }
        return self::getNameByIds($allUserIds);
    }

    /**
     * @param array user id
     */
    public static function getNameByIds($allUserIds)
    {
        $users = [];
        foreach ($allUserIds as $key => $userId) {
            $name = self::getNameById($userId);
            if ($name !== null) {
                $user = ['name' => $name];
            } else {
                continue;
            }
            $user['id'] = $userId;
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param array user id
     */
    public static function getNameById($userId)
    {
        $name = null;
        $mUser = User::find()->where(['id' => $userId])->one();
        if ($mUser !== null) {
            $name = $mUser->username;
        }
        return $name;
    }

    /**
     * @return string `role user`
     */
    public static function getRolenames($id = null)
    {
    	if (!empty($id)) {
	        $roles = Yii::$app->authManager->getRolesByUser($id);
	        $names = [];
	        foreach ($roles as $key => $role) {
	            $names[] = $role->name;
	        }
	        return implode(", ", $names);
    	}
    	return '';
    }

    /**
     * @return string badge
     */
    public static function getBadgeStatus($status)
    {
        $content = ['color' => 'info', 'text' => 'Tidak ada'];
        if ($status == 1) {
            $content['color'] = 'green';
            $content['text'] = 'Aktif';
        }
        $badge = Html::tag('span', $content['text'], ['class' => "badge bg-{$content['color']}"]);
        return $badge;
    }
}
