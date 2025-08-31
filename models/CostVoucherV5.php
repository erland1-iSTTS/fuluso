<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cost_voucher_v5".
 *
 * @property int $cv_id
 * @property int $cv_code
 * @property string $cv_datecreated
 * @property string $cv_datetransaction
 * @property int $cv_user
 * @property int $cv_type 1: pokok, 2: variable
 * @property string $cv_currency
 * @property int $cv_source id cara pembayaran - old
 * @property int $cv_payment 1: Cash, 2: Transfer
 * @property int $id_portfolio_account payment_account
 * @property string|null $payment_date
 * @property int $status_payment 0: blm lunas, 1: sdh lunas
 * @property int $cv_pos
 * @property string $cv_detail
 * @property int $cv_qty
 * @property string $cv_packages
 * @property float $cv_amount
 * @property int|null $id_ppn
 * @property float $ppn
 * @property float $pph
 * @property string $cv_remarks
 * @property int $cv_month
 * @property int $cv_year
 * @property int $cv_suboffice
 * @property float $cv_subtotal
 */
class CostVoucherV5 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cost_voucher_v5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cv_code', 'cv_datecreated', 'cv_datetransaction', 'cv_user', 'cv_type', 'cv_currency', 'cv_source', 'cv_payment', 'id_portfolio_account', 'cv_pos', 'cv_detail', 'cv_qty', 'cv_packages', 'cv_amount', 'cv_remarks', 'cv_month', 'cv_year', 'cv_suboffice', 'cv_subtotal'], 'required'],
            [['cv_code', 'cv_user', 'cv_type', 'cv_source', 'cv_payment', 'id_portfolio_account', 'status_payment', 'cv_pos', 'cv_qty', 'id_ppn', 'cv_month', 'cv_year', 'cv_suboffice'], 'integer'],
            [['cv_datecreated', 'cv_datetransaction', 'payment_date'], 'safe'],
            [['cv_amount', 'ppn', 'pph', 'cv_subtotal'], 'number'],
            [['cv_remarks'], 'string'],
            [['cv_currency'], 'string', 'max' => 3],
            [['cv_detail', 'cv_packages'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cv_id' => 'Cv ID',
            'cv_code' => 'Cv Code',
            'cv_datecreated' => 'Cv Datecreated',
            'cv_datetransaction' => 'Cv Datetransaction',
            'cv_user' => 'Cv User',
            'cv_type' => 'Cv Type',
            'cv_currency' => 'Cv Currency',
            'cv_source' => 'Cv Source',
            'cv_payment' => 'Cv Payment',
            'id_portfolio_account' => 'Id Portfolio Account',
            'payment_date' => 'Payment Date',
            'status_payment' => 'Status Payment',
            'cv_pos' => 'Cv Pos',
            'cv_detail' => 'Cv Detail',
            'cv_qty' => 'Cv Qty',
            'cv_packages' => 'Cv Packages',
            'cv_amount' => 'Cv Amount',
            'id_ppn' => 'Id Ppn',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'cv_remarks' => 'Cv Remarks',
            'cv_month' => 'Cv Month',
            'cv_year' => 'Cv Year',
            'cv_suboffice' => 'Cv Suboffice',
            'cv_subtotal' => 'Cv Subtotal',
        ];
    }
}
