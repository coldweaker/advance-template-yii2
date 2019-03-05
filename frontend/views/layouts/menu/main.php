<?php

$menu = [
    [
        'label' => Yii::t('app', 'Dashboard'),
        'url' => ['/dashboard'],
        'visible' => false,
        'permission' => ['dashboard-index'],
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