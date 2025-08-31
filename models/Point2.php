<?php

namespace app\models;

use Yii;

class Point2 extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'point2';
    }
	
    public function rules()
    {
        return [
            [['ch', 'locode', 'name', 'namewodiacritics', 'subdiv', 'function', 'status', 'date', 'iata', 'coordinates', 'remarks'], 'required'],
            [['ch', 'locode', 'name', 'namewodiacritics', 'subdiv', 'function', 'status', 'date', 'iata', 'coordinates', 'remarks'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ch' => 'Ch',
            'locode' => 'LOCODE',
            'name' => 'Name',
            'namewodiacritics' => 'NameWoDiacritics',
            'subdiv' => 'SubDiv',
            'function' => 'Function',
            'status' => 'Status',
            'date' => 'Date',
            'iata' => 'IATA',
            'coordinates' => 'Coordinates',
            'remarks' => 'Remarks',
        ];
    }
}
