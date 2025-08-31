<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_menu".
 *
 * @property int $id
 * @property string $nama_modul
 * @property string $nama_menu
 * @property int $flag
 */
class MasterMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_modul', 'nama_menu'], 'required'],
            [['flag'], 'integer'],
            [['nama_modul', 'nama_menu'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_modul' => 'Nama Modul',
            'nama_menu' => 'Nama Menu',
            'flag' => 'Flag',
        ];
    }
}
