<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Notif;
use yii\helpers\Inflector;
use common\components\helpers\ImageHelper;

/* @var $this \yii\web\View */
/* @var $content string */

$username = !Yii::$app->user->isGuest ? Yii::$app->user->username : null;
$roles = !Yii::$app->user->isGuest ? Yii::$app->user->rolenames : null;
?>

<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'navbar-brand']) ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <?php if(!Yii::$app->user->isGuest): ?>
            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'nav navbar-nav'],
                    'items' => require __DIR__ . '/menu/main.php',
                    'defaultIconHtml' => ''
                ]
            ) ?>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
            </form>
        <?php endif; ?>
        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <?php if(!Yii::$app->user->isGuest): ?>
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
                <?php else: ?>
                    <li><?= Html::a(Yii::t('app', 'Sign In'), 'login') ?></li>
                <?php endif; ?>
            </ul>
        </div>

        </div>
    </nav>
</header>
