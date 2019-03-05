<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use frontend\components\Controller;
use common\models\activerecords\User;
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
                        'actions' => ['profile'],
                        'roles' => ['user-profile'],
                    ],
                ],
            ],
        ];
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
