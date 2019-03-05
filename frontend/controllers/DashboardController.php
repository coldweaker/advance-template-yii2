<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\components\Controller;

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
