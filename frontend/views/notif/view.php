<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\components\helpers\DateTimeHelper;

/* @var $this \common\components\View */
/* @var $model \common\models\activerecords\Notification */

$this->title = \Yii::t('app', 'View Notif');
$this->params['breadcrumbs'] = [
    [
        'label' => \Yii::t('app', 'List Notif'),
        'url' => ['notif/index'],
    ],
    $model->id,
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Notif'), 'url' => ['notif/index']],
];
?>
<?= $this->render('/_header', ['title' => 'Notif']) ?>

<section class="invoice">
  <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-envelope"></i> <?= Html::encode($model->title) ?>
                <small class="pull-right">
                    <?= $model->getAttributeLabel('created_at') ?>: 
                    <?= DateTimeHelper::shortDateTimeIna($model->created_at, true) ?>
                </small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
        <?= $model->getAttributeLabel('from_name') ?>
            <address>
                <strong><?= Html::encode($model->from_name) ?></strong><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <?= $model->getAttributeLabel('to_name') ?>
            <address>
                <strong><?= Html::encode($model->to_name) ?></strong><br>
            </address>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive">
            <p><?= HtmlPurifier::process($model->content) ?></p>
        </div>
    </div>
</section>