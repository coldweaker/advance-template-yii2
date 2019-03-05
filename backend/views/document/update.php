<?php

use yii\helpers\Html;

/* @var $id integer id document */
/* @var $this \common\components\View */
/* @var $model \backend\models\forms\DocumentForm */

$this->title = \Yii::t('app', 'Update Document');
$this->params['breadcrumbs'] = [
    [
        'label' => \Yii::t('app', 'List Document'),
        'url' => ['document/index'],
    ],
    Html::encode($model->name)
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Document'), 'url' => ['document/index']],
    ['label' => \Yii::t('app', 'Create Document'), 'url' => ['document/create']],
    ['label' => \Yii::t('app', 'Update Document'), 'url' => ['document/update', 'id' => $id]]
];
?>
<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'Update Document Form') ?></h3>
    </div>
    <!-- /.box-header -->
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
<!-- /.box -->