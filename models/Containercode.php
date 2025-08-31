<?php

namespace app\models;

use Yii;

class Containercode extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'containercode';
    }
	
    public function rules()
    {
        return [
            [['containercode_name'], 'required', 'message' => 'Data harus diisi'],
            [['is_active'], 'integer'],
            [['containercode_name', 'containercode_description'], 'string', 'max' => 255],
            [['containercode_name'], 'unique'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'containercode_name' => 'Container Code',
            'containercode_description' => 'Container Description',
            'is_active' => 'Is Active',
        ];
    }
}
