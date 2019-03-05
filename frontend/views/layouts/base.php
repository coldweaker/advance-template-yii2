<?php
use frontend\assets\AppAsset;
use common\assets\BaseAsset;
use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $content string */

AppAsset::register($this);
BaseAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <?= $this->registerLinkTag([
        'rel' => 'stylesheet',
        'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
    ]) ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-green layout-top-nav">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
