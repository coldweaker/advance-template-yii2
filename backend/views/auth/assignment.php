<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use backend\models\forms\AssignmentForm;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;

/* @var $this \app\components\View */
/* @var $model \app\models\forms\AssignmentForm */

$this->title = \Yii::t('app', 'Assignment Auth');
$this->params['breadcrumbs'] = [
    [
        'label' => \Yii::t('app', 'List Auth'),
        'url' => ['auth/index'],
    ],
    \Yii::t('app', 'Assignment')
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Auth'), 'url' => ['auth/index']],
    ['label' => \Yii::t('app', 'Create Auth'), 'url' => ['auth/create']],
    ['label' => \Yii::t('app', 'Assignment'), 'url' => ['auth/assignment']],
];
?>

<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'Assignment Auth Form') ?></h3>
    </div>
    <!-- /.box-header -->
    <?= $this->render('/_header', ['title' => 'Auth']) ?>

    <!-- form start -->
    <?php $form = ActiveForm::begin([
        'id' => 'auth-assignment-form',
        'enableClientValidation' => true,
        'fieldConfig' => [
        ],
    ]) ?>
    <div class="box-body">

        <?= $form->field($model, 'parent')->widget('\common\widgets\Select2', [])->dropDownList(
            AssignmentForm::getItems(), ['prompt' => \Yii::t('app', 'Select...')]
        ); ?>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'has_childs')->listBox([], ['multiple' => true, 'size' => 20]) ?>
            </div>
            <div class="col-sm-1">
                <br><br>
                <?= Html::button(FA::i('arrow-left'), ['class' => 'btn btn-success', 'id' => 'btn-add-child']) ?>
                <br><br>
                <?= Html::button(FA::i('arrow-right'), ['class' => 'btn btn-danger', 'id' => 'btn-remove-child']) ?>
            </div>
            <div class="col-sm-5">
                <?= $form->field($model, 'childs')->listBox([], ['multiple' => true, 'size' => 20])->label('') ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2">
                <ul id="message-child" style="display: none;"></ul>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <?php ActiveForm::end() ?>
</div>
<!-- /.box -->
<?php
$urlFindChildren = Url::to(['auth/find-child']);
$urlAddChildren = Url::to(['auth/add-child']);
$urlRemoveChildren = Url::to(['auth/remove-child']);
$script = <<< JS
$(function() {
    function setOptions(content, element) {
        $.each(content, function(index, value) {
            var option = $("<option></option>")
                .attr("value", index)
                .text(value);
            $(element).append(option);
        });
    }

    function removeOptions(content, element) {
        $.each(content, function(index, value) {
            $(element + " option[value='"+ index +"']").remove();
        });
    }

    function setUpdateOptions(content, element, elementRemove) {
        setOptions(content, element);
        removeOptions(content, elementRemove)
    }

    function setMessages(content, element, classAttr) {
        $.each(content, function(index, value) {
            var li = $("<li class='" + classAttr + "'></li>").text(value);
            $(element).append(li);
            $(element).show();
        });
    }

    jQuery("#assignmentform-parent").change(function(e){
        if ($(this).val() !== "") {
            var parent = $(this).val();
            $.ajax({
                url: "$urlFindChildren",
                dataType: "json",
                method: "post",
                data: $("#auth-assignment-form").serialize(),
                success: function(response) {
                    if (response.success) {
                        $("#assignmentform-has_childs").empty();
                        $("#assignmentform-childs").empty();
                        setOptions(response.content.hasChilds, "#assignmentform-has_childs");
                        setOptions(response.content.childs, "#assignmentform-childs");
                    }
                },
                error: function() {
                    console.log("Terjadi kesalahan.");
                }
            });
        } else {
            // clear
            $("#assignmentform-has_childs").empty();
            $("#assignmentform-childs").empty();
        }
    });

    jQuery('#btn-add-child').click(function(e){
        $("#message-child").empty().hide();
        $.ajax({
            url: "$urlAddChildren",
            dataType: "json",
            method: "post",
            data: $("#auth-assignment-form").serialize(),
            success: function(response) {
                if (response.success) {
                    setUpdateOptions(response.content.saved, "#assignmentform-has_childs", "#assignmentform-childs");
                    setMessages(response.content.message.failed, "#message-child", "text-red");
                    setMessages(response.content.message.saved, "#message-child", "text-green");
                }
            },
            error: function() {
                console.log("Terjadi kesalahan.");
            }
        });
    });

    jQuery('#btn-remove-child').click(function(e){
        $("#message-child").empty().hide();
        $.ajax({
            url: "$urlRemoveChildren",
            dataType: "json",
            method: "post",
            data: $("#auth-assignment-form").serialize(),
            success: function(response) {
                if (response.success) {
                    setUpdateOptions(response.content.removed, "#assignmentform-childs", "#assignmentform-has_childs");
                    setMessages(response.content.message.failed, "#message-child", "text-red");
                    setMessages(response.content.message.removed, "#message-child", "text-green");
                }
            },
            error: function() {
                console.log("Terjadi kesalahan.");
            }
        });
    });
});
JS;
$this->registerJs($script, \common\components\View::POS_READY);
