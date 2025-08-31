<?php

namespace app\models;

use Yii;

class Config extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'config';
    }
	
    public function rules()
    {
        return [
            [['value', 'flag'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'flag' => 'Flag',
        ];
    }
}
