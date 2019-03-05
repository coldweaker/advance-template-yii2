<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use common\models\AuthBase;
use yii\helpers\ArrayHelper;
use backend\components\Controller;
use yii\filters\AccessControl;
use backend\models\forms\AuthForm;
use backend\models\activerecords\Auth;
use backend\models\searchs\AuthSearch;
use yii\web\NotFoundHttpException;
use backend\models\forms\AssignmentForm;

/**
 * AuthController class
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuthController extends Controller
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
                        'roles' => ['auth-index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['auth-create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['auth-update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['auth-delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['assignment'],
                        'roles' => ['auth-assignment'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['find-child'],
                        'roles' => ['auth-find-child'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-child'],
                        'roles' => ['auth-add-child'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['remove-child'],
                        'roles' => ['auth-remove-child'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    /**
     * Display list auth
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Display form add new auth item.
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new AuthForm(['scenario' => AuthForm::SCENARIO_INSERT]);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->insert()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Display the form change auth item.
     *
     * @return string
     */
    public function actionUpdate($name)
    {
        $model = new AuthForm(['scenario' => AuthForm::SCENARIO_UPDATE]);
        $item = $this->loadModel($name);
        $model->assignment($item);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->update($item)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Delete auth item
     *
     * @param string $name auth item
     * @return string
     */
    public function actionDelete($name)
    {
        $model = new AuthForm();
        $item = $this->loadModel($name);
        $model->assignment($item);
        if ($model->delete($item)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Data successfully deleted.'));
        } else {
            Yii::$app->session->setFlash('error', $model->getError('name'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Display assigment between role and permission
     *
     * @return string
     */
    public function actionAssignment()
    {
        $model = new AssignmentForm(['scenario' => AssignmentForm::SCENARIO_INSERT]);

        return $this->render('assignment', ['model' => $model]);
    }

    /**
     * Retrieve auth item data based on its name.
     *
     * @return $model \backend\models\activerecords\Auth corresponding to the specified name
     * @throws \Exception if var $model is null
     */
    protected function loadModel($name)
    {
        $model = Auth::findOne($name);
        if ($model === null ) {
            throw new NotFoundHttpException(Yii::t('yii', 'Not Found'));
        }
        return $model;
    }

    /**
     * Ajax request get childs of item.
     *
     * @return json
     */
    public function actionFindChild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ['success' => false, 'content' => '', 'message' => ''];
        $model = new AssignmentForm(['scenario' => AssignmentForm::SCENARIO_FIND_CHILD]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $result['success'] = true;
            $result['content'] = AuthBase::getArrayChilds($model->parent);
        }
        return $result;
    }

    /**
     * Ajax request add child to item (parent).
     *
     * @return json
     */
    public function actionAddChild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ['success' => false, 'content' => '', 'message' => ''];
        $model = new AssignmentForm(['scenario' => AssignmentForm::SCENARIO_ADD]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $result['success'] = true;
            $result['content'] = AuthBase::addChilds($model->parent, $model->childs);
        }
        return $result;
    }

    /**
     * Ajax request remove child from item (parent).
     *
     * @return json
     */
    public function actionRemoveChild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ['success' => false, 'content' => '', 'message' => ''];
        $model = new AssignmentForm(['scenario' => AssignmentForm::SCENARIO_REMOVE]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $result['success'] = true;
            $result['content'] = AuthBase::removeChilds($model->parent, $model->has_childs);
        }
        return $result;
    }
}
