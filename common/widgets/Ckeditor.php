<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\CkeditorAsset;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * Widget for CKEditor Bootstrap
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class CkEditor extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        CkeditorAsset::register($this->getView());
        $defaultClientOptions = [
            'fullPage' => true
        ];
        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);
        $this->registerPlugin('CKEDITOR');
        return $this->renderInputHtml('textarea');
    }

    /**
     * @override
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        BootstrapPluginAsset::register($view);

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
            $js = "$name.replace('$id', $options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }
}
