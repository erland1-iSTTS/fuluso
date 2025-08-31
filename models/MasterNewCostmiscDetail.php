<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_new_costmisc_detail".
 *
 * @property int $vchd_id
 * @property int $vchd_vch_id
 * @property int $vchd_type
 * @property int $vchd_count
 * @property int $vchd_pos
 * @property string $vchd_detail
 * @property float $vchd_qty
 * @property string $vchd_unit_type
 * @property string $vchd_rate
 * @property string $vchd_amount
 * @property int $vchd_id_ppn
 * @property int $vchd_ppn
 * @property int $vchd_is_active
 */
class MasterNewCostmiscDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_new_costmisc_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vchd_vch_id', 'vchd_type', 'vchd_count', 'vchd_pos', 'vchd_detail', 'vchd_qty', 'vchd_unit_type', 'vchd_rate', 'vchd_amount', 'vchd_id_ppn', 'vchd_ppn', 'vchd_is_active'], 'required'],
            [['vchd_vch_id', 'vchd_type', 'vchd_count', 'vchd_pos', 'vchd_id_ppn', 'vchd_ppn', 'vchd_is_active' , 'vchd_id_pph'], 'integer'],
            [['vchd_qty' , 'vchd_pph'], 'number'],
            [['vchd_detail', 'vchd_unit_type', 'vchd_rate', 'vchd_amount'], 'string', 'max' => 255],
            [['vchd_pph' , 'vchd_id_pph'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vchd_id' => 'Vchd ID',
            'vchd_vch_id' => 'Vchd Vch ID',
            'vchd_type' => 'Vchd Type',
            'vchd_count' => 'Vchd Count',
            'vchd_pos' => 'Vchd Pos',
            'vchd_detail' => 'Vchd Detail',
            'vchd_qty' => 'Vchd Qty',
            'vchd_unit_type' => 'Vchd Unit Type',
            'vchd_rate' => 'Vchd Rate',
            'vchd_amount' => 'Vchd Amount',
            'vchd_id_ppn' => 'Vchd Id Ppn',
            'vchd_ppn' => 'Vchd Ppn',
            'vchd_id_pph' => 'Vchd Id Pph',
            'vchd_pph' => 'Vchd Pph',
            'vchd_is_active' => 'Vchd Is Active',
        ];
    }
}
