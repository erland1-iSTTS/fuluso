<?php

namespace app\models;

use Yii;

class MasterNewJob extends \yii\db\ActiveRecord
{
	public $user;
	public $office;
	public $job_number_generate;
	
    public static function tableName()
    {
        return 'master_new_job';
    }
	
    public function rules()
    {
        return [
            [['job', 'job_type', 'job_location', 'job_year', 'job_month', 'job_number', 'job_name', 'customer_name', 'job_customer', 'job_from', 'job_to', 'job_ship', 'job_hb', 'job_mb', 'g3_type', 'g3_total', 'g3_packages', 'status'], 'required'],
            [['job_number', 'g3_total', 'multiple', 'status'], 'integer'],
            [['timestamp'], 'safe'],
            [['job', 'job_type', 'job_location', 'job_year', 'job_month', 'job_name', 'customer_name', 'job_customer', 'job_from', 'job_to', 'job_ship', 'job_hb', 'job_mb', 'g3_type', 'g3_packages'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job' => 'Job',
            'job_type' => 'Job Type',
            'job_location' => 'Job Location',
            'job_year' => 'Job Year',
            'job_month' => 'Job Month',
            'job_number' => 'Job Number',
            'job_name' => 'Job Name',
            'customer_name' => 'Customer Name',
            'job_customer' => 'Job Customer',
            'job_from' => 'Job From',
            'job_to' => 'Job To',
            'job_ship' => 'Job Ship',
            'job_hb' => 'Job Hb',
            'job_mb' => 'Job Mb',
            'g3_type' => 'G 3 Type',
            'g3_total' => 'G 3 Total',
            'g3_packages' => 'G 3 Packages',
            'multiple' => 'Multiple',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
	
	public function getMasterNewNoas()
    {
        return $this->hasMany(MasterNewNoa::className(), ['id_job' => 'id']);
    }
}
