<?php

namespace app\models;

use Yii;

class MasterHakAkses extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_hak_akses';
    }

    public function rules()
    {
        return [
            [['id_role', 'id_menu', 'id_action'], 'required'],
            [['id_role', 'id_menu', 'id_action', 'flag'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_role' => 'Id Role',
            'id_menu' => 'Id Menu',
            'id_action' => 'Id Action',
            'flag' => 'Flag',
        ];
    }
}
