<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;

/* @var $this \common\components\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \common\models\forms\ChangePasswordForm */
?>
<?php $form = ActiveForm::begin([
      'id' => 'change-password-form',
      'layout' => 'horizontal',
      'enableClientValidation' => false
]) ?>
<div class="box-header">
    <?= Alert::widget([]); ?>
</div>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'password_old')
                     ->passwordInput(['autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password_new')
                     ->passwordInput(['autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password_new_repeat')
                     ->passwordInput(['autocomplete' => 'off']) ?>
        </div>
        <div class="col-md-9">
            <?= Html::submitButton(\Yii::t('app', 'Change Password'), [
                'class' => 'btn btn-success btn-flat pull-right',
                'name' => 'change-password-button']
            ) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>