<?php
use yii\helpers\Html;

/* @var $model ActiveRecord class */
$options = isset($options) ? $options : [];
?>
<?php if(isset($model) && $model->hasErrors()): ?>
<div class="box-body">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <?= Html::errorSummary($model, $options) ?>
    </div>
</div>
<?php endif; ?>