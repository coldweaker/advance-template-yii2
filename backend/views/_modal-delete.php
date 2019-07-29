<?php

/* @var $this \common\components\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;

?>
<?php Modal::begin([
    'header' => "<h4 class=\"modal-title\">{$title}</h4>",
    'id' => $modalID,
    'size' => isset($size) ? $size : '',
    'options' => isset($options) ? $options : [],
    'footer' => '<div class="col-sm-12 text-center">' . 
            Html::button(
            Yii::t('app', 'No'),
                ['class' => 'btn btn-danger',
                'id' => 'no-confirm',
                'data-dismiss' => 'modal']
            ) . "\n" . Html::button(
                Yii::t('app', 'Yes'),
                ['class' => 'btn btn-success', 'id' => 'yes-confirm']
            ). '</div>',
]); ?>

<div class="text-center">
    <i class="fa fa-warning fa-5x"></i>
    <br>
    <?= $content; ?>
</div>

<?php Modal::end(); ?>