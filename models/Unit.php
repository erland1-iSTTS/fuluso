<?php

namespace app\models;

use Yii;

class Unit extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'unit';
    }
	
    public function rules()
    {
        return [
            [['unit_name', 'unit_type'], 'required', 'message' => 'Data harus diisi'],
            [['unit_id', 'unit_type', 'is_active'], 'integer'],
            [['unit_name'], 'string', 'max' => 255],
            [['unit_id'], 'unique'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'unit_name' => 'W/M Name',
            'unit_type' => 'W/M Type',
            'is_active' => 'Is Active',
        ];
    }
}
