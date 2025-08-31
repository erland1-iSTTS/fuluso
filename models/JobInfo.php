<?php

namespace app\models;

use Yii;

class JobInfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'job_info';
    }
	
    public function rules()
    {
        return [
            [['id_job', 'step', 'status'], 'required'],
			[['id_job', 'step', 'status', 'is_active'], 'integer'],
			[['updated_at', 'created_at'], 'safe'],
			[['doc_1', 'doc_2'], 'string', 'max' => 255],
			[['doc_1', 'doc_2'], 'file', /*'skipOnEmpty' => false,*/ 'maxSize' => '5242880', 'tooBig' => 'Maximal File Size is 5 Mb'/*, 'uploadRequired' => 'Please Upload a File'*/],
		];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job' => 'Id Job',
            'step' => 'Step',
            'status' => 'Status',
            'doc_1' => 'Doc  1',
            'doc_2' => 'Doc  2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
        ];
    }
}
