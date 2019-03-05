<?php

namespace backend\components;

use yii\web\Controller as BaseController;
use yii\helpers\Url;

/**
 * Extends class Controller
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Controller extends BaseController
{
    public $layout = '//main-2';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (\Yii::$app->user->isGuest &&
            \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
            return false;
        }

        return true;
    }

    /**
     * @param Model $model
     */
    protected function ajaxErrorSummary($model)
    {
        if ($model->hasErrors()) {
            return $this->renderPartial('//_error-summary', [
                'model' => $model
            ]);
        }
        return '';
    }
}
