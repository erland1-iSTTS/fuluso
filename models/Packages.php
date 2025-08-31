<?php

namespace app\models;

use Yii;

class Packages extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'packages';
    }
	
    public function rules()
    {
        return [
            [['packages_name', 'packages_plural'], 'required', 'message' => 'Data harus diisi'],
            [['packages_name', 'packages_plural'], 'string', 'max' => 255],
            [['packages_name'], 'unique'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'packages_name' => 'Packages Name Singular',
            'packages_plural' => 'Packages Name Plural',
        ];
    }
}
