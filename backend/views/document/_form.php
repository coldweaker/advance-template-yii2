<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\forms\DocumentForm;

/* @var $this \common\components\View */
/* @var $model \backend\models\forms\DocumentForm */

?>

<?= $this->render('/_header', ['title' => 'Document']) ?>

<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'document-form',
    'layout' => 'horizontal',
    'enableClientValidation' => false,
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-6',
        ],
    ],
]) ?>
<div class="box-body">
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'content', [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'wrapper' => 'col-sm-10',
            ]
        ])
        ->widget('\common\widgets\WysiwygEditor', [])
        ->textarea() ?>
</div>

<!-- /.box-body -->
<div class="box-footer">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary pull-right']) ?>
</div>
<!-- /.box-footer -->
<?php ActiveForm::end() ?>