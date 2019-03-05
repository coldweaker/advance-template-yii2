<?php

/* @var $this \app\components\View */

$this->title = \Yii::t('app', 'Dashboard');
?>

<?php $this->beginBlock('content-header') ?>
<?= \Yii::t('app', 'Dashboard') ?>
<?php $this->endBlock() ?>

<?php if (Yii::$app->user->can('admin')): ?>
<?= $this->render('_admin', [
]) ?>
<?php endif; ?>