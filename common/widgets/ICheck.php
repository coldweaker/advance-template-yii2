<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\bootstrap\InputWidget;
use common\assets\ICheckAsset;

/**
 * Widget for iCheck checkbox and radio
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class ICheck extends InputWidget
{
    public $cssClass = 'minimal';

    public $type = 'minimal-blue';

    /**
     * @inheritdoc
     */
    public function run()
    {
        Html::addCssClass($this->options, $this->cssClass);
        ICheckAsset::register($this->getView());
        $this->getView()->registerJs("
            jQuery('input[type=\"checkbox\"].{$this->cssClass}, input[type=\"radio\"].{$this->cssClass}').iCheck({
              checkboxClass: 'icheckbox_{$this->type}',
              radioClass   : 'iradio_{$this->type}'
            })"
        );
    }
}
