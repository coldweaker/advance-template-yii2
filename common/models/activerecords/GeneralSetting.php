<?php

namespace common\models\activerecords;

use Yii;
use yii\helpers\Json;
use common\models\ActiveRecord;

/**
 * GeneralSetting is the activerecord behind the setting.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class GeneralSetting extends ActiveRecord
{
    /**
     * @return table name `setting`
     */
    public static function tableName()
    {
        return '{{setting}}';
    }

    /**
     * @return arrray rules model
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'safe'],
        ];
    }

    /**
     * @return array labels
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Setting Name'),
            'value' => \Yii::t('app', 'Setting Value'),
        ];
    }

    /**
     * @param string $name
     */
    public static function getValueJson($name)
    {
        return self::find()
            ->select(['value'])
            ->where(['name' => $name])
            ->scalar();
    }
}
