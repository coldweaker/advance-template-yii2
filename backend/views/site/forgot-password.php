<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;

/* @var $this \common\components\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \common\models\forms\ForgotPasswordForm */

$this->title = \Yii::t('app', 'Forgot Password');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Basic</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= \Yii::t('app', 'Forgot Password') ?></p>
        <?= Alert::widget([]); ?>
        <?php $form = ActiveForm::begin([
              'id' => 'forgot-password-form',
              'enableClientValidation' => false
        ]) ?>

        <?= $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton(\Yii::t('app', 'Send'), [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'name' => 'forgot-password-button']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>

        <?= Html::a(\Yii::t('app', 'Sign In'), Url::to(['/site/login'])) ?>
        <br>
    </div>
</div>
