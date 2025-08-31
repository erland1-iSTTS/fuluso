<?php

namespace app\models;

use Yii;

class MasterNewJobcostDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_jobcost_detail';
    }

    public function rules()
    {
        return [
            [['vchd_vch_id', 'vchd_job_id', 'vchd_job_group', 'vchd_type', 'vchd_count', 'vchd_pos', 'vchd_detail', 'vchd_basis1_total', 'vchd_basis1_type', 'vchd_basis2_total', 'vchd_basis2_type', 'vchd_rate', 'vchd_rate_type', 'vchd_amount', 'vchd_sector', 'vchd_exch', 'vchd_id_ppn', 'vchd_ppn', 'vchd_is_active'], 'required'],
            [['vchd_vch_id', 'vchd_job_id', 'vchd_job_group', 'vchd_type', 'vchd_count', 'vchd_pos', 'vchd_id_ppn', 'vchd_ppn', 'vchd_is_active', 'vchd_id_pph'], 'integer'],
            [['vchd_basis1_total', 'vchd_basis2_total', 'vchd_pph'], 'number'],
            [['vchd_detail', 'vchd_basis1_type', 'vchd_basis2_type', 'vchd_rate', 'vchd_rate_type', 'vchd_amount', 'vchd_sector', 'vchd_exch'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'vchd_id' => 'Vchd ID',
            'vchd_vch_id' => 'Vchd Vch ID',
            'vchd_job_id' => 'Vchd Job ID',
            'vchd_job_group' => 'Vchd Job Group',
            'vchd_type' => 'Vchd Type',
            'vchd_count' => 'Vchd Count',
            'vchd_pos' => 'Vchd Pos',
            'vchd_detail' => 'Vchd Detail',
            'vchd_basis1_total' => 'Vchd Basis 1 Total',
            'vchd_basis1_type' => 'Vchd Basis 1 Type',
            'vchd_basis2_total' => 'Vchd Basis 2 Total',
            'vchd_basis2_type' => 'Vchd Basis 2 Type',
            'vchd_rate' => 'Vchd Rate',
            'vchd_rate_type' => 'Vchd Rate Type',
            'vchd_amount' => 'Vchd Amount',
            'vchd_sector' => 'Vchd Sector',
            'vchd_exch' => 'Vchd Exch',
            'vchd_id_ppn' => 'Vchd Id Ppn',
            'vchd_ppn' => 'Vchd Ppn',
            'vchd_pph' => 'Vchd Pph',
            'vchd_id_pph' => 'Vchd Id Pph',
            'vchd_is_active' => 'Vchd Is Active',
        ];
    }
	
	
	public function getPos()
    {
        return $this->hasOne(PosV8::className(), ['pos_id' => 'vchd_pos']);
    }
}
