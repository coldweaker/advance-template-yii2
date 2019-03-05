<?php

namespace backend\models\forms;

use Yii;
use common\models\Model;
use common\models\AuthBase;
use yii\helpers\ArrayHelper;
use backend\models\forms\RoleForm;
use common\models\activerecords\User;

/**
 * UserForm is the model behind the user form.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class UserForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $roles;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $roles = [];
        if ($this->scenario === self::SCENARIO_INSERT) {
            $dataRole = $this->getRoles();
            foreach ($dataRole as $key => $role) {
                $modelRole = new RoleForm();
                $modelRole->name = $role->name;
                $roles[$role->name] = $modelRole;
            }
        }
        $this->roles = $roles;
    }

    /**
     * @return all available roles
     */
    public function getRoles()
    {
        $auth = Yii::$app->authManager;
        $authRoles = $auth->getRoles();
        unset($authRoles['admin'], $authRoles['super-admin']);
        return $authRoles;
    }

    /**
     * @return array the scenarios.
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INSERT] = ['username', 'password', 'password_repeat', 'email', 'roles'];
        $scenarios[self::SCENARIO_UPDATE] = ['username', 'email', 'roles'];
        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'email'], 'required', 'on' => self::SCENARIO_INSERT],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_UPDATE],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'match', 'pattern' => '/^[a-z\d_]+$/'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'string', 'min' => 4, 'max' => 20],
            ['email', 'email'],
            ['email', 'string', 'min' => 4, 'max' => 50],
            ['roles', 'validateRole'],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * Validate role attribute, role must be an array and item of array is an instance of Object RoleForm
     * At least one role must be selected.
     */
    public function validateRole($attribute, $params, $validator) {
        if (is_array($this->$attribute)) {
            $countSelected = 0;
            $allowedRoles = ArrayHelper::map($this->getRoles(), 'name', 'name');
            foreach ($this->$attribute as $key => $value) {
                if (!in_array($value->name, $allowedRoles)) {
                    $this->addError($attribute, Yii::t('app', 'Not Allowed assign role.'));
                    return;
                } elseif (!$value instanceof RoleForm) {
                    $this->addError($attribute, Yii::t('app', 'Invalid class type attribute.'));
                    return;
                } elseif (!$value->validate()) {
                    $this->addError($attribute, Yii::t('app', 'Validation failed.'));
                    return;
                } else {
                    if ($value->selected == 1) {
                        $countSelected++;
                    }
                }
            }
            if ($countSelected == 0) {
                $this->addError($attribute, Yii::t('app', 'Role required.'));
            }
        } else {
            $this->addError($attribute, Yii::t('app', 'Invalid attribute value.'));
        }
    }

    /**
     * @return bool indicates user data successfully saved.
     */
    public function insert()
    {
        $user = new User(['scenario' => User::SCENARIO_INSERT]);
        $user->attributes = $this->attributes;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                foreach ($this->roles as $key => $role) {
                    if ($role->selected == 1) {
                        $itemRole = $auth->getRole($role->name);
                        $auth->assign($itemRole, $user->getId());
                    }
                }
                $trans->commit();
                return true;
            }
        } catch(\Exception $e) {
            $trans->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
        } catch(\Throwable $e) {
            $trans->rollBack();
        }
        $this->addErrors($user->getErrors());
        return false;
    }

    /**
     * Assign attribute value from model User.
     *
     * @param $user \app\models\activerecords\User
     * @return $model \app\models\forms\UserForm
     */
    public function assignment(User $user)
    {
        $this->attributes = $user->attributes;
        $this->roles = $this->setRoles($user);
        return $this;
    }

    /**
     * Set value for attribute roles
     *
     * @param $user \app\models\activerecords\User
     * @return array object RoleForm
     */
    public function setRoles($user)
    {
        $auth = Yii::$app->authManager;
        $assignedRoles = $auth->getRolesByUser($user->getId());
        $roles = [];
        foreach ($this->getRoles() as $key => $role) {
            $modelRole = new RoleForm();
            $modelRole->name = $role->name;
            if (isset($assignedRoles[$role->name])) {
                $modelRole->selected = 1;
            }
            $roles[$role->name] = $modelRole;
        }
        return $roles;
    }

    /**
     * @param $user \app\models\activerecords\User;
     * @return bool indicates user data successfully updated.
     */
    public function update(User $user)
    {
        $user->scenario = User::SCENARIO_UPDATE;
        $user->attributes = $this->attributes;
        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($user->save()) {
                // remove assignement
                AuthBase::removeAssignmentByUser($user->id);
                // re insert
                $auth = Yii::$app->authManager;
                foreach ($this->roles as $key => $role) {
                    if ($role->selected == 1) {
                        $itemRole = $auth->getRole($role->name);
                        $auth->assign($itemRole, $user->getId());
                    }
                }
                $trans->commit();
                return true;
            }
        } catch(\Exception $e) {
            $trans->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
        } catch(\Throwable $e) {
            $trans->rollBack();
        }
        $this->addErrors($user->getErrors());
        return false;
    }
}
