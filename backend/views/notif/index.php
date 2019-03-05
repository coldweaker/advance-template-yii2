<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use common\widgets\Alert;
use common\widgets\GridView;
use rmrevin\yii\fontawesome\FA;
use common\models\activerecords\Notification;

/* @var $this \app\components\View */

$this->title = \Yii::t('app', 'List Notif');
$this->params['breadcrumbs'] = [
    \Yii::t('app', 'List Notif')
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Notif'), 'url' => ['notif/index']],
];
?>

<?= $this->render('/_header', ['title' => 'Notif']) ?>

<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'List Notif') ?></h3>
    </div>
    <div class="box-header">
        <?= Alert::widget([]); ?>
    </div>
    <?php Pjax::begin(['id' => 'list-notif']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'from_name',
            'to_name',
            [
                'attribute' => 'status',
                'filter' => Notification::getListStatus(),
                'value' => function ($data) {
                    return Notification::getStatus($data['status']);
                },
            ],
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<!-- /.box -->
