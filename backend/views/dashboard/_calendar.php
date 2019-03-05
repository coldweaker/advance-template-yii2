<?php
use yii\helpers\Html;
use common\widgets\Calendar;
?>
<div class="box box-solid bg-green-gradient">
    <div class="box-header">
        <i class="fa fa-calendar"></i>
        <h3 class="box-title"><?= \Yii::t('app', 'Calendar'); ?></h3>
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <?= Calendar::widget([
            'options' => ['style' => '100%']
        ]); ?>
    </div>
</div>