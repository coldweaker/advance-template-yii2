<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\activerecords\User;

/**
 * ForgotPasswordForm is the model behind the forgot password form
 */
class ForgotPasswordForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $password_reset_token;

    const SCENARIO_SEND = 'send';
    const SCENARIO_INSERT = 'insert';

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEND] = ['email'];
        $scenarios[self::SCENARIO_INSERT] = ['password', 'password_repeat'];
        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required', 'on' => self::SCENARIO_SEND],
            ['email', 'email'],
            ['email', 'checkAndSendEmail', 'on' => self::SCENARIO_SEND],
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_INSERT],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'checkAndUpdateUser', 'on' => self::SCENARIO_INSERT],
            ['password_reset_token', 'safe', 'on' => self::SCENARIO_INSERT]
        ];
    }

    /**
     * Check exist email
     */
    public function checkAndSendEmail()
    {
        $user = User::find()->where(['email' => $this->email])->one();
        if ($user === null) {
            $this->addError('email', Yii::t('app', 'Email not found.'));
        } else {
            // send email
            if (!$user->sendForgotPassword()) {
                $this->addError('email', Yii::t('app', 'Send email failed.'));
            }
        }
    }

    /**
     * Check exist email
     */
    public function checkAndUpdateUser()
    {
        $user = User::find()->where(['password_reset_token' => $this->password_reset_token])->one();
        if ($user === null) {
            $this->addError('password', Yii::t('app', 'Invalid request.'));
        } else {
            if (!$user->resetPassword($this)) {
                $this->addError('password', Yii::t('app', 'Reset password failed.'));
            }
        }
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
        ];
    }
}
