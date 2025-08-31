<?php

namespace app\models;

use Yii;

class Country extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'country';
    }
	
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
