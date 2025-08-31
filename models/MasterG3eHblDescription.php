<?php

namespace app\models;

use Yii;

class MasterG3eHblDescription extends \yii\db\ActiveRecord
{
	public $date_of_issue;
	
    public static function tableName()
    {
        return 'master_g3e_hbl_description';
    }
	
    public function rules()
    {
        return [
            [['hbldes_hbl_id', 'hbldes_job_id', 'hbldes_mark', 'hbldes_desofgood', 'hbldes_desofgood_text', 'hbldes_weight', 'hbldes_declared_list', 'hbldes_declared_text1', 'hbldes_declared_text2', 'hbldes_freight', 'hbldes_payable', 'hbldes_payable_details', 'hbldes_original', 'hbldes_poi', 'hbldes_doi_day', 'hbldes_doi_month', 'hbldes_doi_year', 'hbldes_signature', 'hbldes_signature_text', 'hbldes_is_active'], 'required'],
            [['hbldes_hbl_id', 'hbldes_job_id', 'hbldes_is_active', 'hbldes_payable_status'], 'integer'],
            [['hbldes_mark', 'hbldes_desofgood', 'hbldes_desofgood_text', 'hbldes_weight', 'hbldes_declared_list', 'hbldes_declared_text1', 'hbldes_declared_text2', 'hbldes_freight', 'hbldes_payable', 'hbldes_payable_details', 'hbldes_original', 'hbldes_poi', 'hbldes_doi_day', 'hbldes_doi_month', 'hbldes_doi_year', 'hbldes_signature', 'hbldes_signature_text'], 'string'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'hbldes_id' => 'Hbldes ID',
            'hbldes_hbl_id' => 'Hbldes Hbl ID',
            'hbldes_job_id' => 'Hbldes Job ID',
            'hbldes_mark' => 'Hbldes Mark',
            'hbldes_desofgood' => 'Hbldes Desofgood',
            'hbldes_desofgood_text' => 'Hbldes Desofgood Text',
            'hbldes_weight' => 'Hbldes Weight',
            'hbldes_declared_list' => 'Hbldes Declared List',
            'hbldes_declared_text1' => 'Hbldes Declared Text 1',
            'hbldes_declared_text2' => 'Hbldes Declared Text 2',
            'hbldes_freight' => 'Hbldes Freight',
            'hbldes_payable' => 'Hbldes Payable',
            'hbldes_payable_status' => 'Hbldes Payable Status',
            'hbldes_payable_details' => 'Hbldes Payable Details',
            'hbldes_original' => 'Hbldes Original',
            'hbldes_poi' => 'Hbldes Poi',
            'hbldes_doi_day' => 'Hbldes Doi Day',
            'hbldes_doi_month' => 'Hbldes Doi Month',
            'hbldes_doi_year' => 'Hbldes Doi Year',
            'hbldes_signature' => 'Hbldes Signature',
            'hbldes_signature_text' => 'Hbldes Signature Text',
            'hbldes_is_active' => 'Hbldes Is Active',
        ];
    }
	
	public function getOffice()
    {
        return $this->hasOne(Office::className(), ['office_code' => 'hbldes_poi']);
    }
	
	public function getFreight()
    {
        return $this->hasOne(Freight::className(), ['freight_id' => 'hbldes_freight']);
    }
}
