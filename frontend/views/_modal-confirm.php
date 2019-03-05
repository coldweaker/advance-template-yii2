<?php

/* @var $this \app\components\View */

use yii\bootstrap\Modal;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'header' => '<h2 class="modal-title"></h2>',
    'id' => 'modal-confirm',
    'footer' => Html::button(
        \Yii::t('app', 'No Confirm'),
        ['class' => 'btn btn-danger pull-left', 'id' => 'no-confirm', 'data-dismiss' => 'modal']
    ) . "\n" . Html::button(
        \Yii::t('app', 'Yes'),
        ['class' => 'btn btn-success', 'id' => 'yes-confirm']
    ),
]); ?>

<?= \Yii::t('app', 'Are you sure to continue?') ?>

<?php Modal::end(); ?>