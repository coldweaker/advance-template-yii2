<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use backend\models\forms\AuthForm;

/* @var $this \common\components\View */
/* @var $model \backend\models\forms\AuthForm */

?>

<?= $this->render('/_header', ['title' => 'Auth']) ?>

<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'auth-form',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'wrapper' => 'col-sm-8',
        ],
    ],
]) ?>
<div class="box-body">
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type')->dropDownList(
        AuthForm::getListTypeName(),
        ['prompt' => \Yii::t('app', 'Select...')]
    ) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'rule_name')->dropDownList(
        AuthForm::getListRuleName(),
        ['prompt' => \Yii::t('app', 'Select...')]
    ) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 5]) ?>
</div>
<!-- /.box-body -->
<div class="box-footer">
    <?= Html::resetButton(\Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary pull-right']) ?>
</div>
<!-- /.box-footer -->
<?php ActiveForm::end() ?>