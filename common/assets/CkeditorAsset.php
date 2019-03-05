<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * Ckeditor AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class CkeditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/ckeditor';
    public $css = [
    ];
    public $js = [
        'ckeditor.js'
    ];
    public $depends = [
        'common\assets\BaseAsset',
    ];
}