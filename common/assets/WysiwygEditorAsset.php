<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * WysiwygEditor AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class WysiwygEditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/bootstrap-wysihtml5';
    public $css = [
        'bootstrap3-wysihtml5.min.css'
    ];
    public $js = [
        'bootstrap3-wysihtml5.all.min.js'
    ];
    public $depends = [
        'common\assets\BaseAsset',
    ];
}