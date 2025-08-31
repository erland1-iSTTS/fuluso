<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "d_master_new_jobinvoice".
 *
 * @property int $inv_id
 * @property int $inv_job_id
 * @property int $inv_job_group
 * @property int $inv_type
 * @property int $inv_group
 * @property int $inv_count
 * @property string $inv_date
 * @property string $inv_code
 * @property string $inv_currency
 * @property int $inv_ppn
 * @property string $inv_total
 * @property int $inv_customer
 * @property string $inv_customer2
 * @property string $inv_customer3
 * @property int $inv_to
 * @property string $inv_to2
 * @property string $inv_to3
 * @property string $additional_notes
 * @property string $no_bl_sementara
 * @property int $inv_revision
 * @property int $ppn_change
 * @property string $timestamp
 * @property int $inv_is_active
 */
class DMasterNewJobinvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'd_master_new_jobinvoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inv_job_id', 'inv_job_group', 'inv_type', 'inv_group', 'inv_count', 'inv_date', 'inv_code', 'inv_currency', 'inv_ppn', 'inv_total', 'inv_customer', 'inv_customer2', 'inv_customer3', 'inv_to', 'inv_to2', 'inv_to3', 'additional_notes', 'no_bl_sementara', 'inv_revision', 'ppn_change', 'inv_is_active'], 'required'],
            [['inv_job_id', 'inv_job_group', 'inv_type', 'inv_group', 'inv_count', 'inv_ppn', 'inv_customer', 'inv_to', 'inv_revision', 'ppn_change', 'inv_is_active'], 'integer'],
            [['inv_date', 'timestamp'], 'safe'],
            [['inv_code', 'inv_currency', 'inv_total', 'inv_customer2', 'inv_customer3', 'inv_to2', 'inv_to3', 'additional_notes', 'no_bl_sementara'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            'inv_code' => 'Inv Code',
            'inv_currency' => 'Inv Currency',
            'inv_ppn' => 'Inv Ppn',
            'inv_total' => 'Inv Total',
            'inv_customer' => 'Inv Customer',
            'inv_customer2' => 'Inv Customer 2',
            'inv_customer3' => 'Inv Customer 3',
            'inv_to' => 'Inv To',
            'inv_to2' => 'Inv To 2',
            'inv_to3' => 'Inv To 3',
            'additional_notes' => 'Additional Notes',
            'no_bl_sementara' => 'No Bl Sementara',
            'inv_revision' => 'Inv Revision',
            'ppn_change' => 'Ppn Change',
            'timestamp' => 'Timestamp',
            'inv_is_active' => 'Inv Is Active',
        ];
    }
}
