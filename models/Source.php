<?php

namespace app\models;

use Yii;

class Source extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'source';
    }
	
    public function rules()
    {
        return [
            [['source_code', 'source_detail'], 'required', 'message' => 'Data harus diisi'],
            [['is_active'], 'integer'],
            [['source_code', 'source_detail'], 'string', 'max' => 100],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'source_id' => 'Source ID',
            'source_code' => 'Source Code',
            'source_detail' => 'Source Detail',
            'is_active' => 'Is Active',
        ];
    }
}
