<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\Html;

/**
 * Class helper for image
 */
class ImageHelper
{
    /**
     * @return string asset url adminlte
     */
    public static function getDistAdminlte()
    {
        return Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    }

    /**
     * @param string $fileName ex: `image.jpg`
     * @param string $parthPath ex: `/uploads/employee/`
     * @return string image url
     */
    public static function source($fileName, $partPath, $gender = '1')
    {
        $defaultImage = self::getDistAdminlte() . '/img/avatar5.png';
        if ($gender == '2') { // female
            $defaultImage = self::getDistAdminlte() . '/img/avatar3.png';
        }
        if (empty($fileName)) {
            return $defaultImage;
        }
        $filePath = Yii::getAlias('@webroot') . $partPath . $fileName;
        if (file_exists($filePath)) {
            return Yii::getAlias('@web') . $partPath . $fileName;
        }
        return $defaultImage;
    }

    /**
     * @return html image
     */
    public static function render($fileName, $partPath, $options)
    {
        return Html::img(self::source($fileName, $partPath), $options);
    }
}
