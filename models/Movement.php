<?php

namespace app\models;

use Yii;

class Movement extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'movement';
    }
	
    public function rules()
    {
        return [
            [['movement_name'], 'required', 'message' => 'Data harus diisi'],
            [['movement_id', 'is_active'], 'integer'],
            [['movement_name'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'movement_id' => 'Movement ID',
            'movement_name' => 'Movement Name',
            'is_active' => 'Is Active',
        ];
    }
}
