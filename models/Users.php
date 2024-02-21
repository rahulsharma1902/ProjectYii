<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $role
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => ['admin', 'user', 'manager']],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
    public function setPassword($password)
{
    $this->password = Yii::$app->security->generatePasswordHash($password);
}

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
  
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

   /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
      
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param string $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns the ID of the user.
     * @return string|int the ID of the user
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the key used to authenticate the user identity.
     * This is the key used in session to store the user identity. The returned key should be unique
     * for each user, and should be persistent so that it can be used to retrieve the user identity
     * even after the session is regenerated, e.g. following successful login.
     * @return string the key used to check session.
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

}