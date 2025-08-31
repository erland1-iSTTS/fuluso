<?php

namespace app\models;

use Yii;

class MasterNewJobinvoiceDetailSell extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobinvoice_detail_sell';
    }

    public function rules()
    {
        return [
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_pos', 'invd_detail', 'invd_basis1_total', 'invd_basis1_type', 'invd_basis2_total', 'invd_basis2_type', 'invd_rate', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch', 'invd_is_active', 'invd_ppn', 'invd_ccpp'], 'required'],
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_basis1_total', 'invd_basis2_total', 'invd_is_active', 'invd_ppn'], 'integer'],
            [['invd_rate'], 'number'],
            [['invd_pos', 'invd_detail', 'invd_basis1_type', 'invd_basis2_type', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch', 'invd_ccpp'], 'string', 'max' => 255],
        ];
    }

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
            'invd_ccpp' => 'Invd Ccpp',
        ];
    }
}
