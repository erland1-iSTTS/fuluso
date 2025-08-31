<?php

namespace app\models;

use Yii;

class MasterPortfolioAccount extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_portfolio_account';
    }

    public function rules()
    {
        return [
            [['name', 'accountno', 'accountname'], 'required', 'message' => 'Data harus diisi'],
            [['bankaddress'], 'string'],
            [['flag'], 'integer'],
            [['code', 'name', 'accountno', 'accountname', 'bankname', 'bankswift', 'remarks', 'status'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'accountno' => 'No. Account',
            'code' => 'Bank Code',
            'accountname' => 'Name Account',
            'bankname' => 'Bank Name',
            'bankaddress' => 'Bank Address',
            'bankswift' => 'Bank Swift',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'flag' => 'Flag',
        ];
    }
}
