<?php

/* @var $this \app\components\View */
/* @var $title string */
/* @var $size string */
/* @var $modalID string */

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
            'class' => 'btn btn-danger',
            'data-dismiss' => 'modal',
        ]
    ),
]); ?>

<?php Modal::end(); ?>
