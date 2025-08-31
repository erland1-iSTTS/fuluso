<?php

namespace app\models;

use Yii;

class Signature extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'signature';
    }
	
    public function rules()
    {
        return [
            [['signature_name'], 'required', 'message' => 'Data harus diisi'],
            [['signature_name'], 'string'],
            [['is_active'], 'integer'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'signature_id' => 'Signature ID',
            'signature_name' => 'Signature Name',
            'is_active' => 'Is Active',
        ];
    }
}
