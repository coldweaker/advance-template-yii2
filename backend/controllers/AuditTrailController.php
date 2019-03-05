<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\filters\AccessControl;
use backend\models\searchs\AuditTrailSearch;

/**
 * AuditTrailController class
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuditTrailController extends Controller
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
                        'roles' => ['audit-trail-index']
                    ],
                ],
            ],
        ];
    }

    /**
     * Display list audit trail entry
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '//main';
        $searchModel = new AuditTrailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
