<?php

namespace app\models;

use Yii;

class MasterNewJobvoucher extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobvoucher';
    }
	
    public function rules()
    {
        return [
            [['vch_job_id', 'vch_job_group', 'vch_bank', 'vch_cost', 'vch_invoice', 'vch_type', 'vch_count', 'vch_count_multiple', 'vch_code', 'bbk_type', 'bkk_type', 'bbk_from', 'vch_date', 'vch_currency', 'vch_hmc', 'vch_value_curr', 'vch_pos', 'vch_details', 'vch_quantity', 'vch_unit', 'vch_amount', 'vch_total', 'vch_keterangan', 'vch_customer', 'vch_counter_inv', 'vch_pembayar_customer', 'vch_pembayar_keterangan', 'vch_pembayaran_type', 'vch_pembayaran_info', 'vch_date_pph', 'vch_nomor_pph', 'vch_amount_pph', 'vch_amount_currency', 'vch_faktur', 'vch_ck_pph', 'vch_label', 'nonbkk', 'vch_is_active', 'vch_edit', 'vch_del'], 'required'],
            [['vch_job_id', 'vch_job_group', 'vch_bank', 'vch_cost', 'vch_invoice', 'vch_type', 'vch_count', 'vch_count_alias', 'bbk_type', 'bkk_type', 'bbk_from', 'vch_hmc', 'vch_value_curr', 'vch_pos', 'vch_quantity', 'vch_customer', 'vch_counter_inv', 'vch_amount_currency', 'vch_ck_pph', 'vch_label', 'nonbkk', 'vch_is_active', 'vch_edit', 'vch_del'], 'integer'],
            [['vch_date', 'vch_faktur_tgl', 'timestamp'], 'safe'],
            [['vch_keterangan'], 'string'],
            [['vch_count_multiple', 'vch_code', 'vch_currency', 'vch_details', 'vch_unit', 'vch_amount', 'vch_total', 'vch_pembayar_customer', 'vch_pembayar_keterangan', 'vch_pembayaran_type', 'vch_pembayaran_info', 'vch_date_pph', 'vch_nomor_pph', 'vch_amount_pph', 'vch_faktur', 'vch_file'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'vch_id' => 'Vch ID',
            'vch_job_id' => 'Vch Job ID',
            'vch_job_group' => 'Vch Job Group',
            'vch_bank' => 'Vch Bank',
            'vch_cost' => 'Vch Cost',
            'vch_invoice' => 'Vch Invoice',
            'vch_type' => 'Vch Type',
            'vch_count' => 'Vch Count',
            'vch_count_alias' => 'Vch Count Alias',
            'vch_count_multiple' => 'Vch Count Multiple',
            'vch_code' => 'Vch Code',
            'bbk_type' => 'Bbk Type',
            'bkk_type' => 'Bkk Type',
            'bbk_from' => 'Bbk From',
            'vch_date' => 'Vch Date',
            'vch_currency' => 'Vch Currency',
            'vch_hmc' => 'Vch Hmc',
            'vch_value_curr' => 'Vch Value Curr',
            'vch_pos' => 'Vch Pos',
            'vch_details' => 'Vch Details',
            'vch_quantity' => 'Vch Quantity',
            'vch_unit' => 'Vch Unit',
            'vch_amount' => 'Vch Amount',
            'vch_total' => 'Vch Total',
            'vch_keterangan' => 'Vch Keterangan',
            'vch_customer' => 'Vch Customer',
            'vch_counter_inv' => 'Vch Counter Inv',
            'vch_pembayar_customer' => 'Vch Pembayar Customer',
            'vch_pembayar_keterangan' => 'Vch Pembayar Keterangan',
            'vch_pembayaran_type' => 'Vch Pembayaran Type',
            'vch_pembayaran_info' => 'Vch Pembayaran Info',
            'vch_date_pph' => 'Vch Date Pph',
            'vch_nomor_pph' => 'Vch Nomor Pph',
            'vch_amount_pph' => 'Vch Amount Pph',
            'vch_amount_currency' => 'Vch Amount Currency',
            'vch_faktur' => 'Vch Faktur',
            'vch_faktur_tgl' => 'Vch Faktur Tgl',
            'vch_ck_pph' => 'Vch Ck Pph',
            'vch_label' => 'Vch Label',
            'nonbkk' => 'Nonbkk',
            'vch_is_active' => 'Vch Is Active',
            'vch_edit' => 'Vch Edit',
            'vch_del' => 'Vch Del',
            'vch_file' => 'Vch File',
            'timestamp' => 'Timestamp',
        ];
    }
	
	public function getBank(){
        return $this->hasOne(MasterPortfolioAccount::classname(), ['id' => 'vch_bank']);
    }
	
	public function getJobinvoice(){
        return $this->hasOne(MasterNewJobinvoice::classname(), ['inv_id' => 'vch_invoice']);
    }
	
	public function getJobcost(){
        return $this->hasOne(MasterNewJobcost::classname(), ['vch_id' => 'vch_cost']);
    }
	
	public function getJob(){
        return $this->hasOne(MasterNewJob::classname(), ['id' => 'vch_job_id']);
    }
}
