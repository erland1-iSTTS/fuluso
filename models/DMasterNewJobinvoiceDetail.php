<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "d_master_new_jobinvoice_detail".
 *
 * @property int $invd_id
 * @property int $invd_inv_id
 * @property int $invd_job_id
 * @property int $invd_job_group
 * @property int $invd_type
 * @property int $invd_count
 * @property string $invd_pos
 * @property string $invd_detail
 * @property float $invd_basis1_total
 * @property string $invd_basis1_type
 * @property float $invd_basis2_total
 * @property string $invd_basis2_type
 * @property string $invd_rate
 * @property string $invd_rate_type
 * @property string $invd_amount
 * @property string $invd_sector
 * @property string $invd_exch
 * @property int $invd_is_active
 * @property int $invd_ppn
 */
class DMasterNewJobinvoiceDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'd_master_new_jobinvoice_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_pos', 'invd_detail', 'invd_basis1_total', 'invd_basis1_type', 'invd_basis2_total', 'invd_basis2_type', 'invd_rate', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch', 'invd_is_active', 'invd_ppn'], 'required'],
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_is_active', 'invd_ppn'], 'integer'],
            [['invd_basis1_total', 'invd_basis2_total'], 'number'],
            [['invd_pos', 'invd_detail', 'invd_basis1_type', 'invd_basis2_type', 'invd_rate', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invd_id' => 'Invd ID',
            'invd_inv_id' => 'Invd Inv ID',
            'invd_job_id' => 'Invd Job ID',
            'invd_job_group' => 'Invd Job Group',
            'invd_type' => 'Invd Type',
            'invd_count' => 'Invd Count',
            'invd_pos' => 'Invd Pos',
            'invd_detail' => 'Invd Detail',
            'invd_basis1_total' => 'Invd Basis 1 Total',
            'invd_basis1_type' => 'Invd Basis 1 Type',
            'invd_basis2_total' => 'Invd Basis 2 Total',
            'invd_basis2_type' => 'Invd Basis 2 Type',
            'invd_rate' => 'Invd Rate',
            'invd_rate_type' => 'Invd Rate Type',
            'invd_amount' => 'Invd Amount',
            'invd_sector' => 'Invd Sector',
            'invd_exch' => 'Invd Exch',
            'invd_is_active' => 'Invd Is Active',
            'invd_ppn' => 'Invd Ppn',
        ];
    }
}
