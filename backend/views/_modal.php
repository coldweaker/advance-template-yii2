<?php

/* @var $this \app\components\View */
/* @var $title string */
/* @var $modalID string */
/* @var $btnSaveID string */
/* @var $size string */

use yii\helpers\Html;
use yii\bootstrap\Modal;

?>
<?php Modal::begin([
    'header' => "<h4 class=\"modal-title\">{$title}</h4>",
    'id' => $modalID,
    'size' => isset($size) ? $size : '',
    'footer' => Html::button(
        \Yii::t('app', 'Cancel'),
        [
            'class' => 'btn btn-danger pull-left',
            'data-dismiss' => 'modal',
        ]
    ) . "\n" . Html::button(
        \Yii::t('app', 'Save'),
        [
            'class' => 'btn btn-primary',
            'id' => $btnSaveID,
        ]
    ),
]); ?>

<?php Modal::end(); ?>
