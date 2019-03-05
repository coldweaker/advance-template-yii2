<?php

namespace common\models\activerecords;

use Yii;
use common\models\ActiveRecord;

/**
 * Notification is the activerecord behind the notification.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Notification extends ActiveRecord
{
    const STATUS_INIT = 0;
    const STATUS_READ = 1;

    /**
     * @return table name `notification`
     */
    public static function tableName()
    {
        return '{{notification}}';
    }

    /**
     * @return arrray rules model
     */
    public function rules()
    {
        return [
            [['from', 'from_name', 'to', 'to_name', 'title', 'content'], 'required'],
            ['status', 'default', 'value' => self::STATUS_INIT],
            [['title', 'content'], 'trim'],
        ];
    }

    /**
     * @return array labels
     */
    public function attributeLabels()
    {
        return [
            'to_name' => \Yii::t('app', 'To'),
            'from_name' => \Yii::t('app', 'From'),
            'created_at' => \Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return User by `from`
     */
    public function getUserFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

    /**
     * @return array status
     */
    public static function getListStatus()
    {
        $status = [
            self::STATUS_INIT => \Yii::t('app', 'Unread'),
            self::STATUS_READ => \Yii::t('app', 'Already Read')
        ];
        return $status;
    }

    /**
     * @param string $key status
     * @return string status
     */
    public static function getStatus($key)
    {
        $listStatus = self::getListStatus();
        return isset($listStatus[$key]) ? $listStatus[$key] : '';
    }

    /**
     * @param array attribute notif
     */
    public function saveModel(array $attributes)
    {
        $this->attributes = $attributes;
        $this->status = self::STATUS_INIT;
        return $this->save();
    }

    /**
     * Update status to 1
     */
    public function updateRead()
    {
        if ($this->status == self::STATUS_INIT) {
            $this->status = self::STATUS_READ;
            $this->save(false);
        }
    }
}
