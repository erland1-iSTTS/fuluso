<?php

namespace app\models;

use Yii;

class MasterUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
	public $old_password;
	public $confirm_password;
	
    public static function tableName()
    {
        return 'master_user';
    }
    public function rules()
    {
        return [
            [['fullname', 'email', 'id_role', 'username', 'password'], 'required'],
            [['id_role', 'flag'], 'integer'],
            [['password'], 'string'],
            [['timestamp'], 'safe'],
            [['fullname', 'email', 'username'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'email' => 'Email',
            'id_role' => 'Role',
            'username' => 'Username',
            'password' => 'Password',
            'timestamp' => 'Timestamp',
            'flag' => 'Flag',
        ];
    }
	
	public function getRole()
    {
        return $this->hasOne(MasterRole::classname(), ['id' => 'id_role']);
    }
	
	public function getCompany()
    {
        return $this->hasOne(MasterCompany::classname(), ['id' => 'id_company']);
    }
	
	public function getId()
    {
        return $this->id;
    }
	
    public static function findIdentity($id)
    {
        return MasterUser::find()->where(['id' => $id])->one();
    }
	
	public static function findByUsername($username)
    {
        return MasterUser::find()->where(['username' => $username, 'flag' => 1])->one();
    }
	
	public static function findByEmail($email)
    {
        return MasterUser::find()->where(['email' => $email, 'flag' => 1])->one();
    }
	
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach(self::$users as $user){
            if($user['accessToken'] === $token){
                return new static($user);
            }
        }
        return null;
    }
	
    public function getAuthKey()
    {
        return $this->authKey;
    }
	
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
	public function validatePassword($password)
    {
        return (Yii::$app->getSecurity()->validatePassword($password,$this->password));
    }
	
    public function validateOldPassword($attribute, $params)
    {
		$user = MasterUser::find()->where(['id'=>$this->id])->one();
		
		if(Yii::$app->getSecurity()->validatePassword($this->old_password, $user->password) === false){
			$this->addError($attribute, 'Password salah');
		}
    }
}
