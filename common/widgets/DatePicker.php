<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\DatePickerAsset;

/**
 * Widget for datepicker
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DatePicker extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        DatePickerAsset::register($this->getView());
        $defaultClientOptions = [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true,
            'language' => 'id'
        ];
        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);
        $this->registerPlugin('datepicker');
        return $this->renderInputHtml('text');
    }
}
