<?php

namespace app\models;

use Yii;

class MasterNewJobinvoice extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobinvoice';
    }
	
    public function rules()
    {
        return [
            [['inv_job_id', 'inv_job_group', 'inv_type', 'inv_group', 'inv_count', 'inv_date', 'inv_due_date', 'inv_code', 'inv_currency', 'inv_customer', 'inv_customer2', 'inv_customer3', 'inv_to', 'inv_to2', 'inv_to3', 'inv_total', 'inv_total_ppn', 'inv_grandtotal'], 'required'],
            [['inv_job_id', 'inv_job_group', 'inv_type', 'inv_group', 'inv_count', 'inv_customer', 'inv_to', 'inv_total', 'inv_total_ppn', 'inv_grandtotal', 'inv_is_active'], 'integer'],
            [['inv_date', 'inv_due_date', 'inv_timestamp'], 'safe'],
            [['inv_code', 'inv_currency', 'inv_customer2', 'inv_customer3', 'inv_to2', 'inv_to3', 'inv_file', 'additional_notes'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'inv_id' => 'Inv ID',
            'inv_job_id' => 'Inv Job ID',
            'inv_job_group' => 'Inv Job Group',
            'inv_type' => 'Inv Type',
            'inv_group' => 'Inv Group',
            'inv_count' => 'Inv Count',
            'inv_date' => 'Inv Date',
            'inv_due_date' => 'Due Date',
            'inv_code' => 'Inv Code',
            'inv_currency' => 'Inv Currency',
            'inv_customer' => 'Inv Customer',
            'inv_customer2' => 'Inv Customer 2',
            'inv_customer3' => 'Inv Customer 3',
            'inv_to' => 'Inv To',
            'inv_to2' => 'Inv To 2',
            'inv_to3' => 'Inv To 3',
            'inv_total' => 'Inv Total',
            'inv_total_ppn' => 'Inv Total Ppn',
            'inv_grandtotal' => 'Inv Grandtotal',
            'inv_file' => 'Inv File',
            'additional_notes' => 'Additional Notes',
            'inv_timestamp' => 'Inv Timestamp',
            'inv_is_active' => 'Inv Is Active',
        ];
    }
	
	public function getMasterNewJob()
    {
        return $this->hasOne(MasterNewJob::className(), ['id' => 'inv_job_id']);
    }
	
	public function getPaymentinvoice()
    {
        return $this->hasMany(MasterNewJobvoucher::class, ['vch_invoice' => 'inv_id']);
    }
}
