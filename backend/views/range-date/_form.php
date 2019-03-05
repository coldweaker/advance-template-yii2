<?php

use yii\helpers\Html;
use common\widgets\DateRangePicker;

/** @var $mode \common\models\forms\RangeDateForm */
?>
<div class="form-group">
    <div class="col-sm-5">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <?= DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'range_date',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => \Yii::t('app', 'Select range date')
                ],
                'clientOptions' => [
                ],
            ]) ?>
        </div>
        <?= Html::error($model, 'range_date'); ?>
    </div>
    <div class="col-sm-2">
        <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-primary']); ?>
    </div>
</div>