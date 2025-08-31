<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_action".
 *
 * @property int $id
 * @property string $nama_action
 * @property int $flag
 */
class MasterAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_action'], 'required'],
            [['flag'], 'integer'],
            [['nama_action'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_action' => 'Nama Action',
            'flag' => 'Flag',
        ];
    }
}
