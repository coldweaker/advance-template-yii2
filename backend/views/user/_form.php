<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\forms\UserForm;

/* @var $this \common\components\View */
/* @var $model \backend\models\forms\UserForm */

?>

<?= $this->render('/_header', ['title' => 'User']) ?>

<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'user-form',
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
    <?= $form->field($model, 'username') ?>

    <?php if(in_array($model->scenario, [UserForm::SCENARIO_INSERT])): ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?php endif; ?>

    <?= $form->field($model, 'email') ?>

    <?= $this->render('_roles', ['form' => $form, 'model' => $model]) ?>
</div>


<!-- /.box-body -->
<div class="box-footer">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary pull-right']) ?>
</div>
<!-- /.box-footer -->
<?php ActiveForm::end() ?>