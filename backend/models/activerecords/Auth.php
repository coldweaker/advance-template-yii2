<?php

namespace backend\models\activerecords;

use Yii;
use common\models\ActiveRecord;
use backend\models\forms\AuthForm;

/**
 * Auth is the activerecord behind the auth item.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Auth extends ActiveRecord
{
    /**
     * @return table name `auth_item`
     */
    public static function tableName()
    {
        return '{{auth_item}}';
    }

    /**
     * @return array behaviors.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['by']);
        return $behaviors;
    }

    /**
     * @return array the scenarios.
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INSERT] = ['name', 'type', 'description', 'rule_name', 'data'];
        $scenarios[self::SCENARIO_UPDATE] = $scenarios[self::SCENARIO_INSERT];
        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['name', 'string', 'min' => 4, 'max' => 64],
            ['name', 'match', 'pattern' => '/^[a-z-]+$/'],
            ['rule_name', 'match', 'pattern' => '/^[a-zA-Z]+$/'],
            ['name', 'unique'],
            ['rule_name', 'exist', 'targetClass' => '\app\models\activerecords\Rule', 'targetAttribute' => 'name'],
            ['type', 'in', 'range' => AuthForm::getListType()],
            [['name', 'description', 'rule_name', 'data'], 'trim'],
            [['name', 'description', 'rule_name', 'data'], 'filter', 'filter' => 'strip_tags'],
            [['description', 'rule_name', 'data'], 'default'],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels()
    {
        $labels = AuthForm::attributeLabels();
        return $labels;
    }
}
