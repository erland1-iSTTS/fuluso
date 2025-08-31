<?php

namespace app\models;

use Yii;

class MasterPph extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_pph';
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Data harus diisi'],
            [['amount', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'amount' => 'Amount (%)',
            'is_active' => 'Is Active',
        ];
    }

    public function getPphDetails()
    {
        return $this->hasMany(PphDetail::className(), ['id_header' => 'id']);
    }
}
