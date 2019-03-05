<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\components\Controller;
use backend\models\forms\UserForm;
use common\models\activerecords\User;
use backend\models\searchs\UserSearch;
use yii\web\NotFoundHttpException;
use common\models\forms\ChangePasswordForm;

/**
 * UserController class
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class UserController extends Controller
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
                        'roles' => ['user-index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['user-create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['user-update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['profile'],
                        'roles' => ['user-profile'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Display list user
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Display form add new user.
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new UserForm(['scenario' => UserForm::SCENARIO_INSERT]);
        if (
            $model->load(Yii::$app->request->post()) &&
            UserForm::loadMultiple($model->roles, Yii::$app->request->post()) &&
            $model->validate() &&
            $model->insert()
        ) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Display the form change user.
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        $model = new UserForm(['scenario' => UserForm::SCENARIO_UPDATE]);
        $user = $this->loadModel($id);
        $model->assignment($user);
        if (
            $model->load(Yii::$app->request->post()) &&
            UserForm::loadMultiple($model->roles, Yii::$app->request->post()) &&
            $model->validate() &&
            $model->update($user)
        ) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model, 'id' => $id]);
    }

    /**
     * Display user profile
     */
    public function actionProfile()
    {
        $user = $this->loadModel(Yii::$app->user->id);
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($model->password_new);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your password has been updated.'));
                return $this->redirect(['profile']);
            }
        }
        return $this->render('profile', [
            'user' => $user,
            'model' => $model
        ]);
    }

    /**
     * Retrieve user data based on its id.
     *
     * @return $user \app\models\activerecords\User
     */
    protected function loadModel($id)
    {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Not Found'));
        }
        return $user;
    }
}
