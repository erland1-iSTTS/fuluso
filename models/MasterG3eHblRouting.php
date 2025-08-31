<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_g3e_hbl_routing".
 *
 * @property int $hblrouting_id
 * @property int $hblrouting_hbl_id
 * @property int $hblrouting_job_id
 * @property string $hblrouting_receipt
 * @property string $hblrouting_cargo_day
 * @property string $hblrouting_cargo_month
 * @property string $hblrouting_cargo_year
 * @property string $hblrouting_delivery
 * @property string $hblrouting_arrival_day
 * @property string $hblrouting_arrival_month
 * @property string $hblrouting_arrival_year
 * @property int $hblrouting_movement
 * @property string $place_of_receipt
 * @property string $port_of_loading
 * @property string $port_of_delivery
 * @property string $port_of_discharge
 * @property int $hblrouting_is_active
 */
class MasterG3eHblRouting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_g3e_hbl_routing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hblrouting_hbl_id', 'hblrouting_job_id', 'hblrouting_receipt', 'hblrouting_cargo_day', 'hblrouting_cargo_month', 'hblrouting_cargo_year', 'hblrouting_delivery', 'hblrouting_arrival_day', 'hblrouting_arrival_month', 'hblrouting_arrival_year', 'hblrouting_movement', 'place_of_receipt', 'port_of_loading', 'port_of_delivery', 'port_of_discharge', 'hblrouting_is_active'], 'required'],
            [['hblrouting_hbl_id', 'hblrouting_job_id', 'hblrouting_movement', 'hblrouting_is_active'], 'integer'],
            [['hblrouting_receipt', 'hblrouting_cargo_day', 'hblrouting_cargo_month', 'hblrouting_cargo_year', 'hblrouting_delivery', 'hblrouting_arrival_day', 'hblrouting_arrival_month', 'hblrouting_arrival_year', 'place_of_receipt', 'port_of_loading', 'port_of_delivery', 'port_of_discharge'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hblrouting_id' => 'Hblrouting ID',
            'hblrouting_hbl_id' => 'Hblrouting Hbl ID',
            'hblrouting_job_id' => 'Hblrouting Job ID',
            'hblrouting_receipt' => 'Hblrouting Receipt',
            'hblrouting_cargo_day' => 'Hblrouting Cargo Day',
            'hblrouting_cargo_month' => 'Hblrouting Cargo Month',
            'hblrouting_cargo_year' => 'Hblrouting Cargo Year',
            'hblrouting_delivery' => 'Hblrouting Delivery',
            'hblrouting_arrival_day' => 'Hblrouting Arrival Day',
            'hblrouting_arrival_month' => 'Hblrouting Arrival Month',
            'hblrouting_arrival_year' => 'Hblrouting Arrival Year',
            'hblrouting_movement' => 'Hblrouting Movement',
            'place_of_receipt' => 'Place Of Receipt',
            'port_of_loading' => 'Port Of Loading',
            'port_of_delivery' => 'Port Of Delivery',
            'port_of_discharge' => 'Port Of Discharge',
            'hblrouting_is_active' => 'Hblrouting Is Active',
        ];
    }
}
