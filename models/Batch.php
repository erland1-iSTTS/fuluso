<?php

namespace app\models;

use Yii;

class Batch extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'batch';
    }
	
    public function rules()
    {
        return [
            [['batch_id', 'pol_id', 'pol_dod', 'pc_vessel', 'pc_voyage', 'pcv_doa', 'pcv_dod', 'lfp_id', 'lfp_doa', 'lfp_dod', 'lfp_vessel', 'lfp_voyage', 'pod_id', 'pod_doa', 'is_active'], 'required'],
            [['batch_id', 'is_active'], 'integer'],
            [['pol_dod', 'pcv_doa', 'pcv_dod', 'lfp_doa', 'lfp_dod', 'pod_doa'], 'safe'],
            [['pol_id', 'pc_vessel', 'pc_voyage', 'lfp_id', 'lfp_vessel', 'lfp_voyage', 'pod_id'], 'string', 'max' => 255],
            [['batch_id'], 'unique'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'batch_id' => 'ID',
            'pol_id' => 'Pol ID',
            'pol_dod' => 'Pol Dod',
            'pc_vessel' => 'Vessel',
            'pc_voyage' => 'Voyage',
            'pcv_doa' => 'Pcv Doa',
            'pcv_dod' => 'Pcv Dod',
            'lfp_id' => 'Lfp ID',
            'lfp_doa' => 'Lfp Doa',
            'lfp_dod' => 'Lfp Dod',
            'lfp_vessel' => 'Lfp Vessel',
            'lfp_voyage' => 'Lfp Voyage',
            'pod_id' => 'Pod ID',
            'pod_doa' => 'Pod Doa',
            'is_active' => 'Is Active',
        ];
    }
}
