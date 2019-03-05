<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\WysiwygEditorAsset;

/**
 * Widget for WYSIWYG Editor Bootstrap
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class WysiwygEditor extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        WysiwygEditorAsset::register($this->getView());
        $defaultClientOptions = ['toolbar' => [
            'image' => false,
            'color' => false,
            'link' => false,
            'blockquote' => false,
            'fa' => true
        ]];
        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);
        $this->registerPlugin('wysihtml5');
        return $this->renderInputHtml('textarea');
    }
}
