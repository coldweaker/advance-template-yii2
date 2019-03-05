<?php

namespace common\components\helpers;

use yii\helpers\Json;
use yii\helpers\ArrayHelper as BaseArrayHelper;

/**
 * Extends class ArrayHelper
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class ArrayHelper extends BaseArrayHelper
{
    /**
     * @param array $original
     *
     * @return array with new key name item
     */
    public static function transformSelect2(array $original, $keys = ['id' => 'id', 'text' => 'name'])
    {
        $result = array_map(function($item) use ($keys){
            return [
                'id' => $item[$keys['id']],
                'text' => $item[$keys['text']]
            ];
        }, $original);
        return $result;
    }

    /**
     * @param string $str
     * @param string $separator
     */
    public static function getLastString($str, $separator = ',')
    {
        $arr = explode($separator, $str);
        return !empty($arr) ? end($arr) : '';
    }

    /**
     * @param string json data
     * @param string $attribute
     *
     * @return string value of array
     */
    public static function getDecodedValue($json, $attribute = 'id')
    {
        $arr = Json::decode($json);
        return self::getValue($arr, $attribute);
    }
}
