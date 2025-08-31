<?php

namespace app\models;

use Yii;

class MasterNewJobcost extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobcost';
    }
	
    public function rules()
    {
        return [
            [['vch_job_id', 'vch_job_group', 'vch_type', 'vch_group', 'vch_count', 'vch_date', 'vch_due_date', 'vch_code', 'vch_currency', 'vch_pay_for', 'vch_pay_to', 'vch_total', 'vch_total_ppn', 'vch_grandtotal', 'vch_carrier', 'vch_pengembalian'], 'required'],
            [['vch_job_id', 'vch_job_group', 'vch_type', 'vch_group', 'vch_count', 'vch_pay_for', 'vch_total', 'vch_total_ppn', 'vch_grandtotal', 'vch_carrier', 'vch_is_active'], 'integer'],
            [['vch_date', 'vch_due_date', 'vch_timestamp'], 'safe'],
            [['vch_code', 'vch_currency', 'vch_pay_to', 'vch_pengembalian', 'vch_file'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'vch_id' => 'Vch ID',
            'vch_job_id' => 'Vch Job ID',
            'vch_job_group' => 'Vch Job Group',
            'vch_type' => 'Vch Type',
            'vch_group' => 'Vch Group',
            'vch_count' => 'Vch Count',
            'vch_date' => 'Date',
            'vch_due_date' => 'Due Date',
            'vch_code' => 'Vch Code',
            'vch_currency' => 'Vch Currency',
            'vch_pay_for' => 'Vch Pay For',
            'vch_pay_to' => 'Vch Pay To',
            'vch_total' => 'Vch Total',
            'vch_total_ppn' => 'Vch Total Ppn',
            'vch_grandtotal' => 'Vch Grandtotal',
            'vch_carrier' => 'Vch Carrier',
            'vch_pengembalian' => 'Vch Pengembalian',
            'vch_file' => 'Vch File',
            'vch_timestamp' => 'Vch Timestamp',
            'vch_is_active' => 'Vch Is Active',
        ];
    }
	
	public function getDetails()
    {
        return $this->hasMany(MasterNewJobcostDetail::class, ['vchd_vch_id' => 'vch_id']);
    }
	
	public function getPaymentcost()
    {
        return $this->hasMany(MasterNewJobvoucher::class, ['vch_cost' => 'vch_id']);
    }
}
