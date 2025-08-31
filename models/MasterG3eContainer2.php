<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_g3e_container2".
 *
 * @property int $con_id
 * @property int $con_job_id
 * @property int $con_bl
 * @property int $con_count
 * @property string $con_code
 * @property string $con_text
 * @property string $con_name
 * @property string $created_at
 * @property int $is_active
 */
class MasterG3eContainer2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_g3e_container2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['con_job_id', 'con_bl', 'con_count', 'con_code', 'con_text', 'con_name'], 'required'],
            [['con_job_id', 'con_bl', 'con_count', 'is_active'], 'integer'],
            [['created_at'], 'safe'],
            [['con_code', 'con_text', 'con_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'con_id' => 'Con ID',
            'con_job_id' => 'Con Job ID',
            'con_bl' => 'Con Bl',
            'con_count' => 'Con Count',
            'con_code' => 'Con Code',
            'con_text' => 'Con Text',
            'con_name' => 'Con Name',
            'created_at' => 'Created At',
            'is_active' => 'Is Active',
        ];
    }
}
