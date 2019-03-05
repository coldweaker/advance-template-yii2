<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Notif;
use yii\helpers\Inflector;
use common\components\helpers\ImageHelper;

/* @var $this \yii\web\View */
/* @var $content string */

$username = Yii::$app->user->username;
$roles = Yii::$app->user->rolenames;
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">' . Yii::$app->params['abbr-app'] . '</span><span class="logo-lg">' . Yii::$app->name . '</span>',
        Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <?php if(!Yii::$app->user->isGuest): ?>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <?= Notif::widget(['directoryAsset' => $directoryAsset]); ?>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= ImageHelper::source(null, '/uploads/employee/') ?>"
                            class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Html::encode($username); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= ImageHelper::source(null, '/uploads/employee/') ?>"
                                class="img-circle" alt="User Image"/>

                            <p>
                                <?= Html::encode($username); ?>
                                <small><?= Html::encode($roles) ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to(['/user/profile']); ?>" class="btn btn-default btn-flat"><?= \Yii::t('app', 'Profile') ?></a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    \Yii::t('app', 'Sign out'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <?php endif ?>
</header>
