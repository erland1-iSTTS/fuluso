<?php

namespace app\models;

use Yii;

class MasterVesselRouting extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_vessel_routing';
    }
	
    public function rules()
    {
        return [
            [['point_start', 'vessel_start', 'voyage_start', 'date_start', 'point_end', 'vessel_end', 'voyage_end', 'date_end', 'laden_on_board'], 'required', 'message' => 'Data harus diisi'],
            [['date_start', 'date_end'], 'safe'],
            [['is_active'], 'integer'],
            [['point_start', 'vessel_start', 'voyage_start', 'point_end', 'vessel_end', 'voyage_end', 'laden_on_board'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'point_start' => 'Point Start',
            'vessel_start' => 'Vessel Start',
            'voyage_start' => 'Voyage Start',
            'date_start' => 'Date Start',
            'point_end' => 'Point End',
            'vessel_end' => 'Vessel End',
            'voyage_end' => 'Voyage End',
            'date_end' => 'Date End',
            'laden_on_board' => 'Laden On Board',
            'is_active' => 'Is Active',
        ];
    }
	
	public function getPointstart()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'point_start']);
    }
	
	public function getPointend()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'point_end']);
    }
	
	public function getVesselstart()
    {
        return $this->hasOne(Vessel::className(), ['vessel_code' => 'vessel_start']);
    }
	
	public function getVesselend()
    {
        return $this->hasOne(Vessel::className(), ['vessel_code' => 'vessel_end']);
    }
}
