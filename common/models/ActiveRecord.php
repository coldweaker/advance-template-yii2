<?php

namespace common\models;

use yii\db\ActiveRecord as BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use asinfotrack\yii2\audittrail\behaviors\AuditTrailBehavior;

/**
 * Extends class ActiveRecord
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class ActiveRecord extends BaseActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    /**
     * @return array behaviors.
     */
    public function behaviors()
    {
        return [
            'at' => ['class' => TimestampBehavior::className()],
            'by' => ['class' => BlameableBehavior::className()],
            'audittrail' => ['class' => AuditTrailBehavior::className()],
        ];
    }

    /**
     * Lock table $tableName
     * @param string $tableName
     *
     * @return void
     */
    public function lockTable($tableName)
    {
        $db = $this->getDb();
        $db->createCommand('LOCK TABLES {{'. $tableName. '}} WRITE')->execute();
    }

    /**
     * Unlock table
     *
     * @return void
     */
    public function unLockTable()
    {
        $db = $this->getDb();
        $db->createCommand('UNLOCK TABLES')->execute();
    }
}
