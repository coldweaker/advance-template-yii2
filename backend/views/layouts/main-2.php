<?php

/* @var $this \common\components\View */
/* @var $content string */

?>
<?php $this->beginContent('@backend/views/layouts/main.php') ?>
<div class="row">
    <div class="col-md-10">
        <?= $content ?>
    </div>
    <?php if(isset($this->params['side-right'])): ?>
    <div class="col-md-2">
        <!-- Widget: user widget style 1 -->
        <div class="box box-primary">
            <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
                <?php foreach($this->params['side-right'] as $link): ?>
                    <?php if (isset($link['visible']) && !$link['visible']): ?>
                    <?php continue; ?>
                    <?php endif; ?>
                <li><?= \yii\helpers\Html::a($link['label'], \yii\helpers\Url::to($link['url'])) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            </div>
            <!-- /.widget-user -->
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $this->endContent() ?>