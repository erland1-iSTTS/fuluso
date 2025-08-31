<?php

namespace app\models;

use Yii;

class MasterG3eHblCargodetail extends \yii\db\ActiveRecord
{
	public $detail;
	
    public static function tableName()
    {
        return 'master_g3e_hbl_cargodetail';
    }
	
    public function rules()
    {
        return [
            [['hblcrg_hbl_id', 'hblcrg_job_id', 'hblcrg_name', 'hblcrg_container_count', 'hblcrg_seal', 'hblcrg_pack_value', 'hblcrg_pack_type', 'hblcrg_gross_value', 'hblcrg_gross_type', 'hblcrg_nett_value', 'hblcrg_nett_type', 'hblcrg_msr_value', 'hblcrg_msr_type', 'hblcrg_combined', 'hblcrg_description', 'hblcrg_is_active'], 'required'],
            [['hblcrg_hbl_id', 'hblcrg_job_id', 'hblcrg_container_count', 'hblcrg_pack_value', 'hblcrg_combined', 'hblcrg_is_active'], 'integer'],
            [['hblcrg_description'], 'string'],
            [['hblcrg_name', 'hblcrg_seal', 'hblcrg_pack_type', 'hblcrg_gross_value', 'hblcrg_gross_type', 'hblcrg_nett_value', 'hblcrg_nett_type', 'hblcrg_msr_value', 'hblcrg_msr_type'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'hblcrg_id' => 'Hblcrg ID',
            'hblcrg_hbl_id' => 'Hblcrg Hbl ID',
            'hblcrg_job_id' => 'Hblcrg Job ID',
            'hblcrg_name' => 'Hblcrg Name',
            'hblcrg_container_count' => 'Hblcrg Container Count',
            'hblcrg_seal' => 'Hblcrg Seal',
            'hblcrg_pack_value' => 'Hblcrg Pack Value',
            'hblcrg_pack_type' => 'Hblcrg Pack Type',
            'hblcrg_gross_value' => 'Hblcrg Gross Value',
            'hblcrg_gross_type' => 'Hblcrg Gross Type',
            'hblcrg_nett_value' => 'Hblcrg Nett Value',
            'hblcrg_nett_type' => 'Hblcrg Nett Type',
            'hblcrg_msr_value' => 'Hblcrg Msr Value',
            'hblcrg_msr_type' => 'Hblcrg Msr Type',
            'hblcrg_combined' => 'Hblcrg Combined',
            'hblcrg_description' => 'Hblcrg Description',
            'hblcrg_is_active' => 'Hblcrg Is Active',
        ];
    }
}
