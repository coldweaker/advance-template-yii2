<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;

/* @var $this \common\components\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = \Yii::t('app', 'Sign In');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Frontend</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= \Yii::t('app', 'Sign in to start your session') ?></p>
        <?= Alert::widget([]); ?>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]) ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')
                    ->inline()
                    ->widget('\common\widgets\ICheck', ['type' => 'square-green', 'cssClass' => 'sc-green'])
                    ->checkbox(
                        [
                            'class' => 'sc-green',
                            'template' => "<div class=\"checkbox icheck\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
                        ]
                    ) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(\Yii::t('app', 'Sign in'), ['class' => 'btn btn-success btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end() ?>

        <?php //Html::a(\Yii::t('app', 'I forgot my password'), Url::to(['/site/forgot-password'])) ?>
        <br>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
