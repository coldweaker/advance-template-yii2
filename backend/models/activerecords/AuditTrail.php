<?php

namespace backend\models\activerecords;

use Yii;
use common\models\ActiveRecord;

/**
 * AuditTrail is the activerecord behind the audit trail entry.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuditTrail extends ActiveRecord
{
    /**
     * @return table name `audit_trail_entry`
     */
    public static function tableName()
    {
        return '{{audit_trail_entry}}';
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'model_type' => Yii::t('app', 'Model'),
            'happened_at' => Yii::t('app', 'Date'),
            'foreign_pk' => Yii::t('app', 'Model ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return array type
     */
    public function getListType()
    {
        return [
            'insert' => 'Insert',
            'update' => 'Update',
            'delete' => 'Delete'
        ];
    }
}
