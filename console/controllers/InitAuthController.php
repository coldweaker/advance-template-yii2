<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * insert basic permission and role
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class InitAuthController extends Controller
{
    private $auth;

    public function init()
    {
        $this->auth = Yii::$app->authManager;
    }

    public function actionIndex()
    {
        // default role is `admin`
        $role = $this->auth->createRole('admin');
        $role->description = 'Admin role';
        $this->auth->add($role);

        // set auth permission
        $authParent = $this->authPermission();
        $this->auth->addChild($role, $authParent);

        // set user permission
        $userParent = $this->userPermission();
        $this->auth->addChild($role, $userParent);

        // set document permission
        $documentParent = $this->documentPermission();
        $this->auth->addChild($role, $documentParent);

        // set dashboard permission
        $dashboardParent = $this->dashboardPermission();
        $this->auth->addChild($role, $dashboardParent);

        // set notif permission
        $notifParent = $this->notifPermission();
        $this->auth->addChild($role, $notifParent);

        // set audit trail permission
        $auditParent = $this->auditPermission();
        $this->auth->addChild($role, $auditParent);

        $menu = $this->auth->createPermission('admin-show');
        $menu->description = 'Admin show menu';
        $this->auth->add($menu);
        $this->auth->addChild($role, $menu);

        // assign role `admin` to user with id `1`
        $this->auth->assign($role, 1);
    }

    protected function addPermission(array $childs, array $arrParent)
    {
        $parent = $this->auth->createPermission($arrParent['name']);
        $parent->description = $arrParent['description'];
        $this->auth->add($parent);
        foreach ($childs as $key => $description) {
            $child = $this->auth->createPermission($key);
            $child->description = $description;
            $this->auth->add($child);
            $this->auth->addChild($parent, $child);
            echo "success add {$key}\n";
        }
        return $parent;
    }

    protected function authPermission()
    {
        $permissions = [
            'auth-add-child' => 'Auth add child permission',
            'auth-assignment' => 'Auth assignment permission',
            'auth-create' => 'Auth create permission',
            'auth-delete' => 'Auth delete permission',
            'auth-find-child' => 'Auth find child permission',
            'auth-index' => 'Auth index permission',
            'auth-remove-child' => 'Auth remove child permission',
            'auth-update' => 'Auth update permission'
        ];
        $arrParent = ['name' => 'auth-task', 'description' => 'Auth task'];
        return $this->addPermission($permissions, $arrParent);
    }

    protected function userPermission()
    {
        $permissions = [
            'user-create' => 'User create permission',
            'user-index' => 'User index permission',
            'user-profile' => 'User profile permission',
            'user-update' => 'User update permission'
        ];
        $arrParent = ['name' => 'user-task', 'description' => 'User task'];
        return $this->addPermission($permissions, $arrParent);
    }

    protected function documentPermission()
    {
        $permissions = [
            'document-create' => 'Document create permission',
            'document-index' => 'Document index permission',
            'document-update' => 'Document update permission'
        ];
        $arrParent = ['name' => 'document-task', 'description' => 'Document task'];
        return $this->addPermission($permissions, $arrParent);
    }

    protected function dashboardPermission()
    {
        $permissions = [
            'dashboard-index' => 'Dashboard index permission'
        ];
        $arrParent = ['name' => 'dashboard-task', 'description' => 'Dashboard task'];
        return $this->addPermission($permissions, $arrParent);
    }

    protected function notifPermission()
    {
        $permissions = [
            'notif-index' => 'Notif index permission',
            'notif-view' => 'Notif view permission'
        ];
        $arrParent = ['name' => 'notif-task', 'description' => 'Notif task'];
        return $this->addPermission($permissions, $arrParent);
    }

    protected function auditPermission()
    {
        $permissions = [
            'audit-trail-index' => 'Audit trail entry index permission'
        ];
        $arrParent = ['name' => 'audit-trail-task', 'description' => 'Audit trail task'];
        return $this->addPermission($permissions, $arrParent);
    }
}
