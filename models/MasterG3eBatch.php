<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_g3e_batch".
 *
 * @property int $batchform_id
 * @property int $batchform_job
 * @property int $batchform_hbl
 * @property int $batchform_1
 * @property int $batchform_2
 * @property int $batchform_3
 * @property int $batchform_is_active
 */
class MasterG3eBatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_g3e_batch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batchform_job', 'batchform_hbl', 'batchform_1', 'batchform_2', 'batchform_3', 'batchform_is_active'], 'required'],
            [['batchform_job', 'batchform_hbl', 'batchform_1', 'batchform_2', 'batchform_3', 'batchform_is_active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'batchform_id' => 'Batchform ID',
            'batchform_job' => 'Batchform Job',
            'batchform_hbl' => 'Batchform Hbl',
            'batchform_1' => 'Batchform  1',
            'batchform_2' => 'Batchform  2',
            'batchform_3' => 'Batchform  3',
            'batchform_is_active' => 'Batchform Is Active',
        ];
    }
}
