<?php

namespace app\models;

use Yii;

class Point extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'point';
    }
	
    public function rules()
    {
        return [
            [['point_name', 'point_notes', 'is_active'], 'required'],
            [['por', 'pol', 'pot', 'pod', 'fd', 'pots', 'podel', 'is_active'], 'integer'],
            [['point_notes'], 'string'],
            [['point_code'], 'string', 'max' => 8],
            [['point_name'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'point_code' => 'Point Code',
            'point_name' => 'Point Name',
            'por' => 'Por',
            'pol' => 'Pol',
            'pot' => 'Pot',
            'pod' => 'Pod',
            'fd' => 'Fd',
            'pots' => 'Pots',
            'podel' => 'Podel',
            'point_notes' => 'Point Notes',
            'is_active' => 'Is Active',
        ];
    }
}
