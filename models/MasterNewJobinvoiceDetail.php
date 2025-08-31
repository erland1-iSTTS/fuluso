<?php

namespace app\models;

use Yii;

class MasterNewJobinvoiceDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobinvoice_detail';
    }

    public function rules()
    {
        return [
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_pos', 'invd_detail', 'invd_basis1_total', 'invd_basis1_type', 'invd_basis2_total', 'invd_basis2_type', 'invd_rate', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch', 'invd_id_ppn', 'invd_ppn', 'invd_is_active'], 'required'],
            [['invd_inv_id', 'invd_job_id', 'invd_job_group', 'invd_type', 'invd_count', 'invd_pos', 'invd_id_ppn', 'invd_ppn', 'invd_is_active', 'invd_id_pph'], 'integer'],
            [['invd_basis1_total', 'invd_basis2_total'], 'number'],
            [['invd_detail', 'invd_basis1_type', 'invd_basis2_type', 'invd_rate', 'invd_rate_type', 'invd_amount', 'invd_sector', 'invd_exch'], 'string', 'max' => 255],
            [['invd_pph'], 'safe']
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
            'invd_id_ppn' => 'Invd Id Ppn',
            'invd_id_pph' => 'Invd Id Pph',
            'invd_ppn' => 'Invd Ppn',
            'invd_pph' => 'Invd Pph',
            'invd_is_active' => 'Invd Is Active',
        ];
    }
	
	public function getPos()
    {
        return $this->hasOne(PosV8::className(), ['pos_id' => 'invd_pos']);
    }
}
