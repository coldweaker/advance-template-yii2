<?php

use yii\helpers\Html;
use common\components\helpers\ImageHelper;

/* @var $this \yii\web\View */
/* @var $content string */

$username = Yii::$app->user->username;
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <?php if(!Yii::$app->user->isGuest): ?>
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= ImageHelper::source(null, '/uploads/employee/') ?>"
                    class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Html::encode($username) ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="<?= \Yii::t('app', 'Search')?>..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => require __DIR__ . '/menu/main.php',
            ]
        ) ?>
        <?php endif; ?>
    </section>

</aside>
