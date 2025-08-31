<?php

namespace app\models;

use Yii;

class AccountRepr extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'account_repr';
    }
	
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Data harus diisi'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Accout Repr Name',
            'timestamp' => 'Timestamp',
        ];
    }
}
