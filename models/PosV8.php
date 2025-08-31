<?php

namespace app\models;

use Yii;

class PosV8 extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pos_v8';
    }
	
    public function rules()
    {
        return [
			[['pos_name', 'pos_type', 'pos_jenis'], 'required', 'message' => 'Data harus diisi'],
            [['pos_fee_idr', 'pos_fee_usd', 'pos_jenis', 'pos_type', 'is_active' , 'id_detail_ppn' , 'id_detail_pph'], 'integer'],
            [['pos_validity_begin', 'pos_validity_end' , 'id_detail_ppn' , 'id_detail_pph'], 'safe'],
            [['pos_for', 'pos_code', 'pos_name'], 'string', 'max' => 255],
        ];
    }
	
    public function attributeLabels()
    {
        return [
			'pos_id' => 'Pos ID',
            'pos_for' => 'Pos For',
            'pos_code' => 'Pos Code',
            'pos_name' => 'Pos Name',
            'pos_type' => 'Type',
            'pos_fee_idr' => 'Fee IDR',
            'pos_fee_usd' => 'Fee USD',
            'pos_jenis' => 'Jenis',
            'pos_validity_begin' => 'Validity Begin',
            'pos_validity_end' => 'Validity End',
            'id_detail_ppn' => 'PPN',
            'id_detail_pph' => 'PPH',
            'is_active' => 'Is Active',
        ];
    }
}
