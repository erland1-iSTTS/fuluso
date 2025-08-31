<?php

namespace app\models;

use Yii;

class MasterNewCostmisc extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_costmisc';
    }
	
    public function rules()
    {
        return [
            [['office_id', 'vch_count', 'vch_date', 'vch_currency', 'vch_pay_to', 'vch_total', 'vch_total_ppn', 'vch_grandtotal'], 'required'],
            [['vch_count', 'vch_pay_for', 'vch_total', 'vch_total_ppn', 'vch_grandtotal', 'vch_is_active'], 'integer'],
            [['vch_date', 'vch_due_date', 'vch_timestamp'], 'safe'],
            [['office_id'], 'string', 'max' => 3],
            [['vch_currency', 'vch_pay_to', 'vch_file'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'vch_id' => 'ID',
            'office_id' => 'Office',
            'vch_count' => 'Count',
            'vch_date' => 'Date',
            'vch_due_date' => 'Due Date',
            'vch_currency' => 'Currency',
            'vch_pay_for' => 'Pay For',
            'vch_pay_to' => 'Pay To',
            'vch_total' => 'Total',
            'vch_total_ppn' => 'Total Ppn',
            'vch_grandtotal' => 'Grandtotal',
            'vch_file' => 'Vch File',
            'vch_timestamp' => 'Vch Timestamp',
            'vch_is_active' => 'Vch Is Active',
        ];
    }
}
