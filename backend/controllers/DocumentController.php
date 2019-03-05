<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\forms\DocumentForm;
use backend\models\activerecords\Document;
use backend\models\searchs\DocumentSearch;

/**
 * DocumentController class
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DocumentController extends Controller
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
                        'roles' => ['document-index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['document-create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['document-update'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Display list document
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Display form create document
     * @return string
     */
    public function actionCreate()
    {
        $model = new DocumentForm();
        $document = new Document();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($document->saveModel($model)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Display form update document
     * @return string
     */
    public function actionUpdate($id)
    {
        $document = $this->loadModel($id);
        $model = new DocumentForm();
        $model->attributes = $document->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($document->updateModel($model)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['id' => $id, 'model' => $model]);
    }

    /**
     * Load model
     *
     * @param string ID
     */
    protected function loadModel($id)
    {
        $model = Document::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
