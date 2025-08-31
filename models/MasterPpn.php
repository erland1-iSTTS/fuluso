<?php

namespace app\models;

use Yii;

class MasterPpn extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_ppn';
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Data harus diisi'],
            [['amount'], 'number'],
            [['validity_begin', 'validity_end', 'created_date'], 'safe'],
            [['defaults', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'amount' => 'Amount (%)',
            'validity_begin' => 'Validity Begin',
            'validity_end' => 'Validity End',
            'is_active' => 'Is Active',
            'defaults' => 'Default',
            'created_date' => 'Created Date',
        ];
    }

    public function getPpnDetails()
    {
        return $this->hasMany(PpnDetail::class, ['id_header' => 'id']);
    }
}
