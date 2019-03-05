<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use common\components\helpers\UserHelper;
use common\components\helpers\ImageHelper;
use common\components\helpers\DateTimeHelper;

/* @var $this \common\components\View */
/* @var $model \common\models\activerecords\User */

$this->title = \Yii::t('app', 'User Profile');
$this->params['breadcrumbs'] = [
    Html::encode($user->username)
];
?>

<?php $this->beginBlock('content-header') ?>
<?= \Yii::t('app', 'User Profile') ?>
<?php $this->endBlock() ?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-success">
            <div class="box-body box-profile">
                <?= ImageHelper::render(null, null, [
                    'class' => 'profile-user-img img-responsive img-circle',
                    'alt' => 'User profile picture'
                ]) ?>
                <h3 class="profile-username text-center"><?= Html::encode($user->username) ?></h3>
                <p class="text-muted text-center">
                    <?= Html::encode(Yii::$app->user->rolenames) ?>
                    <br/>
                    <em><?= Html::encode($user->email) ?></em>
                    <br>
                    Status : <?= UserHelper::getBadgeStatus($user->status) ?>
                    <br>
                    Pembaharuan terakhir : <?= DateTimeHelper::shortDateTimeIna($user->updated_at, true) ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => \Yii::t('app', 'Setting'),
                        'content' => $this->render('change-password', [
                            'model' => $model
                        ])
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>
<style type="text/css">
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #00a65a;
    }
</style>