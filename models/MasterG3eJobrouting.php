<?php

namespace app\models;

use Yii;

class MasterG3eJobrouting extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_g3e_jobrouting';
    }
	
    public function rules()
    {
        return [
            [['jr_job_id', 'jr_office', 'jr_account_repr', 'jr_type', 'jr_agent_list', 'jr_agentcity_list', 'jr_agentloc', 'jr_house_scac', 'jr_routing_no', 'jr_sc_no', 'jr_ref_number', 'jr_booking_number', 'jr_forwarding_agent', 'jr_country_origin', 'jr_crcode_list', 'jr_crname_list', 'jr_scac', 'jr_hbl', 'jr_hbl_update', 'jr_mbl'], 'required'],
            [['jr_job_id', 'jr_account_repr', 'jr_country_origin', 'jr_crcode_list', 'jr_crname_list', 'jr_hbl', 'jr_hbl_update'], 'integer'],
            [['jr_office', 'jr_type', 'jr_agent_list', 'jr_agentcity_list', 'jr_agentloc', 'jr_house_scac', 'jr_routing_no', 'jr_sc_no', 'jr_ref_number', 'jr_booking_number', 'jr_forwarding_agent', 'jr_scac', 'jr_mbl'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'jr_id' => 'Jr ID',
            'jr_job_id' => 'Jr Job ID',
            'jr_office' => 'Jr Office',
            'jr_account_repr' => 'Jr Account Repr',
            'jr_type' => 'Jr Type',
            'jr_agent_list' => 'Jr Agent List',
            'jr_agentcity_list' => 'Jr Agentcity List',
            'jr_agentloc' => 'Jr Agentloc',
            'jr_house_scac' => 'Jr House Scac',
            'jr_routing_no' => 'Jr Routing No',
            'jr_sc_no' => 'Jr Sc No',
            'jr_ref_number' => 'Jr Ref Number',
            'jr_booking_number' => 'Jr Booking Number',
            'jr_forwarding_agent' => 'Jr Forwarding Agent',
            'jr_country_origin' => 'Jr Country Origin',
            'jr_crcode_list' => 'Jr Crcode List',
            'jr_crname_list' => 'Jr Crname List',
            'jr_scac' => 'Jr Scac',
            'jr_hbl' => 'Jr Hbl',
            'jr_hbl_update' => 'Jr Hbl Update',
            'jr_mbl' => 'Jr Mbl',
        ];
    }
	
	public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'jr_country_origin']);
    }
}
