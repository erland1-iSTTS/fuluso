<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ar_receipt".
 *
 * @property int $id
 * @property int $ar_count
 * @property int $id_job
 * @property int $id_invoice
 * @property int $id_customer
 * @property string $invoice_date
 * @property int $dpp
 * @property int $ppn
 * @property int $pph
 * @property int $total_invoice
 * @property string $payment_date
 * @property int $payment_type 1: partial, 2: full
 * @property int $total_payment
 * @property string|null $currency
 * @property int $id_portfolio_account
 * @property int $id_ppn
 * @property string $created_at
 * @property int $is_active
 */
class ArReceipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ar_receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ar_count', 'id_job', 'id_invoice', 'id_customer', 'invoice_date', 'dpp', 'ppn', 'pph', 'total_invoice', 'payment_date', 'payment_type', 'total_payment', 'id_portfolio_account', 'id_ppn'], 'required'],
            [['ar_count', 'id_job', 'id_invoice', 'id_customer', 'dpp', 'ppn', 'pph', 'total_invoice', 'payment_type', 'total_payment', 'id_portfolio_account', 'id_ppn', 'is_active'], 'integer'],
            [['invoice_date', 'payment_date', 'created_at'], 'safe'],
            [['currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ar_count' => 'Ar Count',
            'id_job' => 'Id Job',
            'id_invoice' => 'Id Invoice',
            'id_customer' => 'Id Customer',
            'invoice_date' => 'Invoice Date',
            'dpp' => 'Dpp',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'total_invoice' => 'Total Invoice',
            'payment_date' => 'Payment Date',
            'payment_type' => 'Payment Type',
            'total_payment' => 'Total Payment',
            'currency' => 'Currency',
            'id_portfolio_account' => 'Id Portfolio Account',
            'id_ppn' => 'Id Ppn',
            'created_at' => 'Created At',
            'is_active' => 'Is Active',
        ];
    }
}
