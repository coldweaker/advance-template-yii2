<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * TimePicker AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class TimePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/timepicker';
    public $css = [
        'bootstrap-timepicker.min.css'
    ];
    public $js = [
        'bootstrap-timepicker.min.js'
    ];
    public $depends = [
        'common\assets\BaseAsset'
    ];
}
