<?php

namespace app\models;

use Yii;

class MasterG3eVesselbatch extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_g3e_vesselbatch';
    }
	
    public function rules()
    {
        return [
            [['vessel_job_id', 'vessel_batch_id', 'vessel_place_receipt', 'vessel_place_delivery', 'vessel_day', 'vessel_month', 'vessel_year', 'vessel_movement', 'vessel_freight_term'], 'required'],
            [['vessel_job_id', 'vessel_batch_id'], 'integer'],
            [['vessel_place_receipt', 'vessel_place_delivery', 'vessel_day', 'vessel_month', 'vessel_year', 'vessel_movement', 'vessel_freight_term'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'vessel_id' => 'Vessel ID',
            'vessel_job_id' => 'Vessel Job ID',
            'vessel_batch_id' => 'Vessel Batch ID',
            'vessel_place_receipt' => 'Vessel Place Receipt',
            'vessel_place_delivery' => 'Vessel Place Delivery',
            'vessel_day' => 'Vessel Day',
            'vessel_month' => 'Vessel Month',
            'vessel_year' => 'Vessel Year',
            'vessel_movement' => 'Vessel Movement',
            'vessel_freight_term' => 'Vessel Freight Term',
        ];
    }
	
	public function getPor()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'vessel_place_receipt']);
    }
	
	public function getFod()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'vessel_place_delivery']);
    }
	
	public function getMovement()
    {
        return $this->hasOne(Movement::className(), ['movement_id' => 'vessel_movement']);
    }
}
