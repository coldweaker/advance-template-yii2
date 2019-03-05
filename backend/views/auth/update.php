<?php

use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $model \app\models\forms\AuthForm */
/* @var $id integer id auth */

$this->title = \Yii::t('app', 'Update Auth');
$this->params['breadcrumbs'] = [
    [
        'label' => \Yii::t('app', 'List Auth'),
        'url' => ['auth/index'],
    ],
    \Yii::t('app', 'Update') . ' ' . Html::encode($model->name)
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List Auth'), 'url' => ['auth/index']],
    ['label' => \Yii::t('app', 'Create Auth'), 'url' => ['auth/create']],
    ['label' => \Yii::t('app', 'Update Auth'), 'url' => ['auth/update', 'name' => $model->name]],
    ['label' => \Yii::t('app', 'Assignment'), 'url' => ['auth/assignment']],
];
?>
<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'Update Auth Form') ?></h3>
    </div>
    <!-- /.box-header -->
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
<!-- /.box -->