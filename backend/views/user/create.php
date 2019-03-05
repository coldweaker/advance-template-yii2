<?php

/* @var $this \app\components\View */
/* @var $model \app\models\forms\UserForm */

$this->title = \Yii::t('app', 'Create User');
$this->params['breadcrumbs'] = [
    [
        'label' => \Yii::t('app', 'List User'),
        'url' => ['user/index'],
    ],
    \Yii::t('app', 'Create')
];
$this->params['side-right'] = [
    ['label' => \Yii::t('app', 'List User'), 'url' => ['user/index']],
    ['label' => \Yii::t('app', 'Create User'), 'url' => ['user/create']]
];
?>

<!-- Horizontal Form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('app', 'Create User Form') ?></h3>
    </div>
    <!-- /.box-header -->
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
<!-- /.box -->