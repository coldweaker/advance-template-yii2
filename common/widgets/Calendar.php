<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use common\assets\DatePickerAsset;

/**
 * Widget for calendar dashboard
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Calendar extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        DatePickerAsset::register($this->getView());
        $defaultClientOptions = [
            'language' => 'id',
            'todayHighlight' => true
        ];
        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);
        $this->registerPlugin('datepicker');
        return Html::tag('div', '', $this->options);
    }
}
