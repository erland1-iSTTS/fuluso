<?php

namespace app\models;

use Yii;

class MasterVesselRoutingDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_vessel_routing_detail';
    }

    public function rules()
    {
        return [
            [['id_vessel_routing', 'vessel_code', 'voyage', 'point_etd', 'date_etd', 'point_eta', 'date_eta', 'laden_on_board'], 'required'],
            [['id_vessel_routing', 'laden_on_board'], 'integer'],
            [['date_etd', 'date_eta'], 'safe'],
            [['vessel_code', 'voyage', 'point_etd', 'point_eta', 'reference'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vessel_routing' => 'Id Vessel Routing',
            'vessel_code' => 'Vessel Code',
            'voyage' => 'Voyage',
            'point_etd' => 'Point Etd',
            'date_etd' => 'Date Etd',
            'point_eta' => 'Point Eta',
            'date_eta' => 'Date Eta',
            'laden_on_board' => 'Laden On Board',
            'reference' => 'Reference',
        ];
    }
}
