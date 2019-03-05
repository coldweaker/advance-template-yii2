<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * DateRangePicker AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DateRangePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-daterangepicker';
    public $css = [
        'daterangepicker.css'
    ];
    public $js = [
        'daterangepicker.js'
    ];
    public $depends = [
        'common\assets\BaseAsset'
    ];
}
