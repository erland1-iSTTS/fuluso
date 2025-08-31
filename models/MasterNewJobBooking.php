<?php

namespace app\models;

use Yii;

class MasterNewJobBooking extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_new_job_booking';
    }
	
    public function rules()
    {
        return [
            [['id_job', 'to1', 'to2', 'to3', 'scac_code', 'booking_no', 'service_contract', 'date_booking', 'carrier', 'ref_number', 'shipper1', 'shipper2', 'shipper3', 'consignee1', 'consignee2', 'consignee3', 'notify1', 'notify2', 'notify3', 'contact1', 'contact2', 'contact3', 'port_of_receipt', 'port_of_loading', 'port_of_discharge', 'final_destination', 'hblrouting_movement', 'batch', 'detail_container', 'detail_info', 'detail_total', 'freight_term', 'user', 'status'], 'required'],
            [['id_job', 'to1', 'shipper1', 'consignee1', 'notify1', 'contact1', 'batch', 'status'], 'integer'],
            [['to3', 'shipper3', 'consignee3', 'notify3', 'contact3', 'detail_container', 'detail_info', 'detail_total'], 'string'],
            [['date_booking', 'timestamp'], 'safe'],
            [['to2', 'scac_code', 'booking_no', 'service_contract', 'carrier', 'ref_number', 'shipper2', 'consignee2', 'notify2', 'contact2', 'port_of_receipt', 'port_of_loading', 'port_of_discharge', 'final_destination', 'hblrouting_movement', 'freight_term', 'user'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job' => 'Id Job',
            'to1' => 'To 1',
            'to2' => 'To 2',
            'to3' => 'To 3',
            'scac_code' => 'Scac Code',
            'booking_no' => 'Booking No',
            'service_contract' => 'Service Contract',
            'date_booking' => 'Date Booking',
            'carrier' => 'Carrier',
            'ref_number' => 'Ref Number',
            'shipper1' => 'Shipper 1',
            'shipper2' => 'Shipper 2',
            'shipper3' => 'Shipper 3',
            'consignee1' => 'Consignee 1',
            'consignee2' => 'Consignee 2',
            'consignee3' => 'Consignee 3',
            'notify1' => 'Notify 1',
            'notify2' => 'Notify 2',
            'notify3' => 'Notify 3',
            'contact1' => 'Contact 1',
            'contact2' => 'Contact 2',
            'contact3' => 'Contact 3',
            'port_of_receipt' => 'Port Of Receipt',
            'port_of_loading' => 'Port Of Loading',
            'port_of_discharge' => 'Port Of Discharge',
            'final_destination' => 'Final Destination',
            'hblrouting_movement' => 'Hblrouting Movement',
            'batch' => 'Batch',
            'detail_container' => 'Detail Container',
            'detail_info' => 'Detail Info',
            'detail_total' => 'Detail Total',
            'freight_term' => 'Freight Term',
            'user' => 'User',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
	
	public function getPor()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'port_of_receipt']);
    }
	
	public function getPol()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'port_of_loading']);
    }
	
	public function getPod()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'port_of_discharge']);
    }
	
	public function getFod()
    {
        return $this->hasOne(Point::className(), ['point_code' => 'final_destination']);
    }
}
