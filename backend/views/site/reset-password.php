<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;

/* @var $this \common\components\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \common\models\forms\ForgotPasswordForm */

$this->title = \Yii::t('app', 'Reset Password');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Basic</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= \Yii::t('app', 'Reset Password') ?></p>
        <?php $form = ActiveForm::begin([
              'id' => 'reset-password-form',
              'enableClientValidation' => false
        ]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions1)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($model, 'password_repeat', $fieldOptions1)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton(\Yii::t('app', 'Reset'), [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'name' => 'reset-password-button']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>

        <?= Html::a(\Yii::t('app', 'Sign In'), Url::to(['/site/login'])) ?>
        <br>
    </div>
</div>
