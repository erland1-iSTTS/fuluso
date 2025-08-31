<?php

namespace app\models;

use Yii;

class Vessel extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'vessel';
    }
	
    public function rules()
    {
        return [
            [['vessel_code', 'vessel_name'], 'required', 'message' => 'Data harus diisi'],
            [['is_active'], 'integer'],
            [['vessel_code', 'vessel_name', 'vessel_lloyd', 'vessel_buildyear', 'vessel_flag', 'vessel_description'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vessel_code' => 'Vessel Code',
            'vessel_name' => 'Vessel Name',
            'vessel_lloyd' => 'Vessel Lloyd',
            'vessel_buildyear' => 'Vessel Buildyear',
            'vessel_flag' => 'Vessel Flag',
            'vessel_description' => 'Vessel Description',
            'is_active' => 'Is Active',
        ];
    }
}
