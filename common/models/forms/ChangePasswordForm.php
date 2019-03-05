<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\activerecords\User;

/**
 * ChangePasswordForm is the model behind the change password form.
 */
class ChangePasswordForm extends Model
{
    public $password_old;
    public $password_new;
    public $password_new_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password_old', 'password_new', 'password_new_repeat'], 'required'],
            ['password_new_repeat', 'compare', 'compareAttribute' => 'password_new'],
            ['password_new', 'string', 'min' => 4, 'max' => 20],
            ['password_old', 'checkOldPassword']
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'password_old' => Yii::t('app', 'Password Old'),
            'password_new' => Yii::t('app', 'Password New'),
            'password_new_repeat' => Yii::t('app', 'Password New Repeat'),
        ];
    }

    /**
     * Check old password is valid
     */
    public function checkOldPassword()
    {
        if (!$this->hasErrors()) {
            $user = User::findByUsername(Yii::$app->user->username);
            if (!$user || !$user->validatePassword($this->password_old)) {
                $this->addError('password_old', 'Incorrect old password.');
            }
        }
    }
}
