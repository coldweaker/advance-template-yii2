<?php

namespace backend\models\forms;

use Yii;
use common\models\Model;
use common\models\AuthBase;
use yii\helpers\ArrayHelper;

/**
 * AssignmentForm is the model behind the assignment form.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AssignmentForm extends Model
{
    public $parent;
    public $has_childs;
    public $childs;

    const SCENARIO_FIND_CHILD = 'find-child';
    const SCENARIO_ADD = 'add-child';
    const SCENARIO_REMOVE = 'remove-child';

    /**
     * @return array the scenarios.
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['parent', 'childs'];
        $scenarios[self::SCENARIO_REMOVE] = ['parent', 'has_childs'];
        $scenarios[self::SCENARIO_FIND_CHILD] = ['parent'];
        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['parent', 'required', 'on' => self::SCENARIO_FIND_CHILD],
            [['parent', 'childs'], 'required', 'on' => self::SCENARIO_ADD],
            [['parent', 'has_childs'], 'required', 'on' => self::SCENARIO_REMOVE],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('app', 'Parent'),
            'has_childs' => Yii::t('app', 'Childs'),
        ];
    }

    /**
     * @return array roles and permission
     */
    public static function getItems()
    {
        return AuthBase::getItems();
    }
}
