<?php /* @var $title string */ ?>
<?php /* @var $this \app\components\View */ ?>

<?php $this->beginBlock('content-header') ?>
<?= \Yii::t('app', 'Management') ?><small><?= \Yii::t('app', $title) ?></small>
<?php $this->endBlock() ?>