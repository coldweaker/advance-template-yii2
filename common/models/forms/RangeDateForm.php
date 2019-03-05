<?php

namespace common\models\forms;

use Yii;
use common\models\Model;

/**
 * RangeDateForm is the model behind the range date search form.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class RangeDateForm extends Model
{
    public $range_date;
    public $start_date;
    public $end_date;

    public $department_id;
    public $department_sub_id;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->start_date = date('01-m-Y');
        $this->end_date = date('d-m-Y');
        $this->range_date = implode(' - ', [$this->start_date, $this->end_date]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['range_date', 'match', 'pattern' => '/^\d{2}-\d{2}-\d{4} - \d{2}-\d{2}-\d{4}$/'],
            [['start_date', 'end_date'], 'date', 'format' => 'dd-mm-yyyy'],
            [['department_id', 'department_sub_id'], 'safe'],
        ];
    }

    /**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
        return [
            'range_date' => Yii::t('app', 'Range Date'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'department_id' => Yii::t('app', 'Department'),
            'department_sub_id' => Yii::t('app', 'Sub Department'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->explodeDate();
            return true;
        }
        return false;
    }

    /**
     * Explode range date
     */
    public function explodeDate()
    {
        if (!empty($this->range_date)) {
            $arrDate = explode(' - ', $this->range_date);
            $this->start_date = $arrDate[0];
            $this->end_date = $arrDate[1];
        }
    }
}
