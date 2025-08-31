<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ap_voucher".
 *
 * @property int $id
 * @property int $id_job
 * @property string $voucher_year
 * @property string $voucher_month
 * @property string $voucher_day
 * @property int $voucher_number
 * @property string $voucher_name
 * @property string $no_mbl
 * @property string $type
 * @property int $id_pay_for customer
 * @property int $id_pay_to customer  / payee
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $due_date
 * @property string|null $payment_date
 * @property int|null $dpp
 * @property int|null $id_ppn
 * @property int|null $ppn
 * @property int|null $pph
 * @property int|null $amount_idr
 * @property int|null $amount_usd
 * @property string|null $currency USD / IDR
 * @property int $id_portfolio_account
 * @property string|null $file
 * @property int $status_bayar
 * @property string $created_at
 * @property int $is_active
 */
class ApVoucher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ap_voucher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_job', 'voucher_year', 'voucher_month', 'voucher_day', 'voucher_number', 'voucher_name', 'no_mbl', 'type', 'id_pay_for', 'id_pay_to', 'invoice_no', 'invoice_date', 'due_date', 'id_portfolio_account'], 'required'],
            [['id_job', 'voucher_number', 'id_pay_for', 'id_pay_to', 'dpp', 'id_ppn', 'ppn', 'pph', 'amount_idr', 'amount_usd', 'id_portfolio_account', 'status_bayar', 'is_active'], 'integer'],
            [['invoice_date', 'due_date', 'payment_date', 'created_at'], 'safe'],
            [['voucher_year', 'voucher_month', 'voucher_day', 'voucher_name', 'no_mbl', 'type', 'invoice_no', 'currency', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job' => 'Id Job',
            'voucher_year' => 'Voucher Year',
            'voucher_month' => 'Voucher Month',
            'voucher_day' => 'Voucher Day',
            'voucher_number' => 'Voucher Number',
            'voucher_name' => 'Voucher Name',
            'no_mbl' => 'No Mbl',
            'type' => 'Type',
            'id_pay_for' => 'Id Pay For',
            'id_pay_to' => 'Id Pay To',
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'due_date' => 'Due Date',
            'payment_date' => 'Payment Date',
            'dpp' => 'Dpp',
            'id_ppn' => 'Id Ppn',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'amount_idr' => 'Amount Idr',
            'amount_usd' => 'Amount Usd',
            'currency' => 'Currency',
            'id_portfolio_account' => 'Id Portfolio Account',
            'file' => 'File',
            'status_bayar' => 'Status Bayar',
            'created_at' => 'Created At',
            'is_active' => 'Is Active',
        ];
    }
}
