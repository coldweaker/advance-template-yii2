<?php

use backend\models\forms\AuthForm;
use common\widgets\GridView;
use common\widgets\Alert;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;

/* @var $this \app\components\View */

$this->title = \Yii::t('app', 'List Auth');
$this->params['breadcrumbs'] = [
    \Yii::t('app', 'List Auth')
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Auth'), 'url' => ['auth/index']],
    ['label' => \Yii::t('app', 'Create Auth'), 'url' => ['auth/create']],
    ['label' => \Yii::t('app', 'Assignment'), 'url' => ['auth/assignment']],
];
?>

<?= $this->render('/_header', ['title' => 'Auth']) ?>

<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'List Auth') ?></h3>
    </div>
    <div class="box-header">
        <?= Alert::widget([]); ?>
    </div>
    <?php Pjax::begin(['id' => 'list-auth']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'type',
                'filter' => AuthForm::getListTypeName(),
                'value' => function($data) {
                    $types = AuthForm::getListTypeName();
                    return $types[$data['type']];
                }
            ],
            'description',
            [
                'class' => 'common\widgets\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        return Html::a(FA::i('trash'), $url, [
                            'class' => 'popup-modal',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-id' => $model['name'],
                            'data-value' => $model['name'],
                            'data-method' => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        return Url::to(['auth/update', 'name' => $model['name']]);
                    }
                    if ($action === 'delete') {
                        return Url::to(['auth/delete', 'name' => $model['name']]);
                    }
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<!-- /.box -->
