<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\filters\AccessControl;

/**
 * DashboardController class
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['dashboard-index'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Display dashboard
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '//main';
        return $this->render('index', [
        ]);
    }
}
