<?php

namespace app\models;

use Yii;

class MasterContainer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_g3e_container';
    }
	
    public function rules()
    {
        return [
            [['con_job_id', 'con_bl', 'con_count', 'con_code', 'con_text', 'con_name'], 'required', 'message' => '{attribute} harus diisi'],
            [['con_job_id', 'con_bl', 'con_count'], 'integer'],
            [['created_at'], 'safe'],
            [['con_code', 'con_name'], 'string', 'max' => 255],
            [['con_text'], 'string', 'min' => 7, 'max' => 7, 'tooShort' => 'Minimal 7 Digit', 'tooLong' => 'Maksimal 7 Digit'],
			[['con_text'], 'trim'],
            [['con_text'], 'unique', 'message' => '{attribute} sudah ada', 'filter' => ['!=', 'is_active', 0]],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'con_id' => 'Con ID',
            'con_job_id' => 'Con Job ID',
            'con_bl' => 'Con Bl',
            'con_count' => 'Con Count',
            'con_code' => 'Prefix',
            'con_text' => 'No. Container',
            'con_name' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
