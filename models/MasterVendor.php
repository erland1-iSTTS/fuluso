<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_vendor".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string|null $alamat
 * @property int $flag
 */
class MasterVendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['flag'], 'integer'],
            [['kode', 'nama', 'alamat'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'flag' => 'Flag',
        ];
    }
}
