<?php

namespace app\models;

use Yii;

class Bank extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bank';
    }
	
    public function rules()
    {
        return [
            [['b_name', 'b_code'], 'required'],
            [['flag'], 'integer'],
            [['timestamp'], 'safe'],
            [['b_name', 'b_code'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'b_id' => 'B ID',
            'b_name' => 'Bank',
            'b_code' => 'Code',
            'flag' => 'Flag',
            'timestamp' => 'Timestamp',
        ];
    }
}
