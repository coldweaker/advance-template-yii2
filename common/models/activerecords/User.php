<?php

namespace common\models\activerecords;

use Yii;
use common\models\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User is the activerecord behind the user.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @return table name `user`
     */
    public static function tableName()
    {
        return '{{user}}';
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
        $scenarios[self::SCENARIO_INSERT] = ['username', 'email'];
        $scenarios[self::SCENARIO_UPDATE] = ['username', 'email'];
        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required', 'on' => self::SCENARIO_INSERT],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['username', 'password_reset_token', 'email'], 'unique'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            ['username', 'match', 'pattern' => '/^[a-z\d_]+$/'],
            ['auth_key', 'string', 'max' => 32],
            ['email', 'email'],
            ['status', 'in', 'range' => self::getListStatus()],
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @return array status user.
     */
    public static function getListStatus()
    {
        return [
            self::STATUS_NOT_ACTIVE,
            self::STATUS_ACTIVE
        ];
    }

/**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->status = self::STATUS_ACTIVE;
            }
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function saveModel()
    {
        $this->attributes = $userForm->attributes;
        $this->password_hash = Yii::$app->security->generatePasswordHash($userForm->password);
        if ($this->save()) {
            $auth = Yii::$app->authManager;
            foreach ($userForm->roles as $key => $role) {
                if ($role->selected == 1) {
                    $itemRole = $auth->getRole($role->name);
                    $auth->assign($itemRole, $this->getId());
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function sendForgotPassword()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->save()) {
                $message = Yii::$app->mailer->compose('forgot-password', ['model' => $this])
                         ->setFrom(Yii::$app->params['adminEmail'])
                         ->setTo($this->email)
                         ->setSubject(Yii::t('app', 'Reset Password'))
                         ->send();
                if ($message === true) {
                    $transaction->commit();
                    return true;
                }
            }
        } catch(\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
        } catch(\Throwable $e) {
            $transaction->rollBack();
        }
        return false;
    }

    /**
     * @param $forgotForm ForgotPasswordForm
     * @return bool
     */
    public function resetPassword($forgotForm)
    {
        $this->password_reset_token = null;
        $this->password_hash = Yii::$app->security->generatePasswordHash($forgotForm->password);
        return $this->save();
    }
}
