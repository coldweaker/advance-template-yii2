<?php

namespace backend\models\forms;

use Yii;
use yii\rbac\Role;
use common\models\Model;
use common\models\AuthBase;
use yii\rbac\Permission;
use backend\models\activerecords\Auth;
use common\components\validators\OneWhiteSpaceFilter;

/**
 * AuthForm is the model behind the auth form.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuthForm extends Model
{
    public $name;
    public $type;
    public $description;
    public $rule_name;
    public $data;

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
            ['rule_name', 'match', 'pattern' => '/^[a-zA-z]+$/'],
            ['type', 'in', 'range' => self::getListType()],
            [['name', 'description', 'rule_name', 'data'], 'trim'],
            [['description'], OneWhiteSpaceFilter::className()],
            [['name', 'description', 'rule_name', 'data'], 'filter', 'filter' => 'strip_tags'],
            [['description', 'rule_name', 'data'], 'default'],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Auth Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data')
        ];
    }

    /**
     * @return array type auth.
     */
    public static function getListType()
    {
        return [
            AuthBase::TYPE_ROLE,
            AuthBase::TYPE_PERMISSION
        ];
    }

    /**
     * @return array type auth with name.
     */
    public static function getListTypeName()
    {
        return [
            AuthBase::TYPE_ROLE => Yii::t('app', 'Role'),
            AuthBase::TYPE_PERMISSION => Yii::t('app', 'Permission')
        ];
    }

    /**
     * @return array rule name.
     */
    public static function getListRuleName()
    {
        $arrRules = [];
        $rules = Yii::$app->authManager->getRules();
        if (!empty($rules)) {
           foreach ($rules as $key => $rule) {
               $arrRules[$rule->name] = $rule->name;
           }
        }
        return $arrRules;
    }

    /**
     * @return bool indicates auth item data successfully saved.
     */
    public function insert()
    {
        $authModel = new Auth(['scenario' => Auth::SCENARIO_INSERT]);
        $authModel->attributes = $this->attributes;
        if ($authModel->validate()) {
            $auth = Yii::$app->authManager;
            $createItem = AuthBase::createItemByModel($auth, $this->type, $this);
            try {
                $success = $auth->add($createItem);
            } catch (\Exception $e) {
                $success = false;
                Yii::error($e->getMessage(), __METHOD__);
            }
            if ($success) {
                return true;
            } else {
                $this->addError('name', Yii::t('app', 'An error occurred, please contact the administrator.'));
                return false;
            }
        } else {
            $this->addErrors($authModel->getErrors());
            return false;
        }
    }

    /**
     * Assign attribute value from object Item (Role or Permission).
     *
     * @param $item \app\models\activerecords\Auth
     * @return $model \app\models\forms\AuthForm
     */
    public function assignment(Auth $item)
    {
        $this->attributes = $item->attributes;
        return $this;
    }

    /**
     * @param $authModel \app\models\activerecords\Auth
     * @return bool indicates auth item data successfully updated.
     */
    public function update($authModel)
    {
        $authModel->scenario = Auth::SCENARIO_UPDATE;
        $oldName = $authModel->name;
        $authModel->attributes = $this->attributes;
        if ($authModel->validate()) {
            $auth = Yii::$app->authManager;
            $itemNew = AuthBase::createItemByModel($auth, $authModel->type, $this);
            try {
                $success = $auth->update($oldName, $itemNew);
            } catch (\Exception $e) {
                $success = false;
                Yii::error($e->getMessage(), __METHOD__);
            }
            if ($success) {
                return true;
            } else {
                $this->addError('name', Yii::t('app', 'An error occurred, please contact the administrator.'));
                return false;
            }
        } else {
            $this->addErrors($authModel->getErrors());
            return false;
        }
    }

    /**
     * @param $authModel \app\models\activerecords\Auth
     * @return bool indicates auth item data successfully deleted.
     */
    public function delete($authModel)
    {
        $auth = Yii::$app->authManager;
        $item = AuthBase::createItemByModel($auth, $authModel->type, $this);
        try {
            $success = $auth->remove($item);
        } catch (\Exception $e) {
            $success = false;
            Yii::error($e->getMessage(), __METHOD__);
        }
        if ($success) {
            return true;
        } else {
            $this->addError('name', Yii::t('app', 'An error occurred, please contact the administrator.'));
            return false;
        }
    }
}
