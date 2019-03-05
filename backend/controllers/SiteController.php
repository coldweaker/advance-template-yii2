<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\forms\LoginForm;
use common\models\activerecords\User;
use yii\web\NotFoundHttpException;
use common\models\forms\ForgotPasswordForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'forgot-password', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard']);
        }

        $this->layout = 'login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(['/dashboard']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    /**
     * Display form forgot password
     * @return string
     */
    public function actionForgotPassword()
    {
        $this->layout = 'login';
        $model = new ForgotPasswordForm(['scenario' => ForgotPasswordForm::SCENARIO_SEND]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Check your email to reset your password.')
            );
            $model->email = null;
        }
        return $this->render('forgot-password', ['model' => $model]);
    }

    /**
     * Display page reset password user
     * @return string
     */
    public function actionResetPassword($id)
    {
        $this->layout = 'login';
        $user = User::find()->where(['password_reset_token' => $id])->one();
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        $model = new ForgotPasswordForm(['scenario' => ForgotPasswordForm::SCENARIO_INSERT]);
        $model->password_reset_token = $id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Success reset your password.')
            );
            return $this->redirect(['login']);
        }
        return $this->render('reset-password', ['model' => $model]);
    }
}
