<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\TimePickerAsset;

/**
 * Widget for timepicker
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class TimePicker extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        TimePickerAsset::register($this->getView());
        $defaultClientOptions = [
            'showInputs' => false,
            'showMeridian' => false,
            'minuteStep' => 1
        ];
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, $defaultClientOptions);
        $this->registerPlugin('timepicker');
        return $this->renderInputHtml('text');
    }
}
