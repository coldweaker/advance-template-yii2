<?php

$menu = [
    [
        'label' => Yii::t('app', 'Dashboard'),
        'icon' => 'dashboard',
        'url' => ['/dashboard'],
        'visible' => false,
        'permission' => ['dashboard-index'],
    ],
    [
        'label' => Yii::t('app', 'Admin'),
        'icon' => 'gears',
        'url' => '#',
        'items' => [
            [
                'label' => Yii::t('app', 'User'),
                'icon' => 'users',
                'url' => ['/user'],
                'visible' => false,
                'permission' => 'user-index',
            ],
            [
                'label' => Yii::t('app', 'Authorize'),
                'icon' => 'key',
                'url' => ['/auth'],
                'visible' => false,
                'permission' => 'auth-index',
            ],
            [
                'label' => Yii::t('app', 'Document'),
                'icon' => 'print',
                'url' => ['/document'],
                'visible' => false,
                'permission' => 'document-index',
            ],
        ],
        'visible' => false,
        'permission' => ['admin-show'],
    ],
    [
        'label' => Yii::t('app', 'Log'),
        'icon' => 'history',
        'url' => ['/audit-trail'],
        'visible' => false,
        'permission' => ['audit-trail-index'],
    ],
];

function visibility($menu)
{
    $result = [];
    foreach ($menu as $key => $item) {
        if (isset($item['items'])) {
            $items = $item['items'];
            $r = visibility($items);
            $item['items'] = $r;
        }
        if (isset($item['permission'])) {
            if (is_array($item['permission'])) {
                foreach ($item['permission'] as $permission) {
                    if (\Yii::$app->user->can($permission)) {
                        $item['visible'] = true;
                        break;
                    }
                }
            } else {
                if (\Yii::$app->user->can($item['permission'])) {
                    $item['visible'] = true;
                }
            }
        }
        $result[] = $item;
    }
    return $result;
}
$menu = visibility($menu);
return $menu;