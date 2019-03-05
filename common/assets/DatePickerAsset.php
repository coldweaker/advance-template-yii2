<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * DatePicker AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-datepicker/dist';
    public $css = [
        'css/bootstrap-datepicker.min.css'
    ];
    public $js = [
        'js/bootstrap-datepicker.min.js',
        'locales/bootstrap-datepicker.id.min.js'
    ];
    public $depends = [
        'common\assets\BaseAsset'
    ];
}
