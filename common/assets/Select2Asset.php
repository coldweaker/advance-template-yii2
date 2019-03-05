<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * Select2 AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/select2/dist';
    public $css = [
        'css/select2.min.css'
    ];
    public $js = [
        'js/select2.full.min.js'
    ];
    public $depends = [
        'common\assets\BaseAsset',
    ];
}
