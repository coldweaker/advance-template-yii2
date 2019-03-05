<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\DateRangePickerAsset;

/**
 * Widget for daterangepicker
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DateRangePicker extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        DateRangePickerAsset::register($this->getView());
        $defaultClientOptions = [
            'locale' => [
                'format' => 'DD-MM-YYYY',
            ]
        ];
        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);
        $view = $this->getView();
        $js = "moment.locale('id');";
        $view->registerJs($js);
        $this->registerPlugin('daterangepicker');
        return $this->renderInputHtml('text');
    }
}
