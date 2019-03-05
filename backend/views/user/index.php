<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\widgets\Alert;
use common\widgets\GridView;
use rmrevin\yii\fontawesome\FA;

/* @var $this \common\components\View */
/* @var $dataProvider SqlDataProvider */
/* @var $modelSearch \backend\models\search\UserSearch */

$this->title = \Yii::t('app', 'List User');
$this->params['breadcrumbs'] = [
    \Yii::t('app', 'List User')
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List User'), 'url' => ['user/index']],
    ['label' => \Yii::t('app', 'Create User'), 'url' => ['user/create']]
];
?>

<?= $this->render('/_header', ['title' => 'User']) ?>

<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'List User') ?></h3>
    </div>
    <div class="box-header">
    </div>
    <?php Pjax::begin(['id' => 'list-user']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email:email',
            'role',
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        return Html::a(FA::i('trash'), $url, [
                            'class' => 'popup-modal',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-id' => $model['id'],
                            'data-value' => $model['username'],
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        return Url::to(['user/update', 'id' => $model['id']]);
                    }
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<!-- /.box -->
