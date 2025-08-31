<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_g3e_hbl_cusdata".
 *
 * @property int $hblcusdata_id
 * @property int $hblcusdata_hbl_id
 * @property int $hblcusdata_job_id
 * @property int $hblcusdata_shipper
 * @property int $hblcusdata_shipper2
 * @property string $hblcusdata_shipper_info
 * @property int $hblcusdata_consignee
 * @property int $hblcusdata_consignee2
 * @property string $hblcusdata_consignee_info
 * @property int $hblcusdata_notify
 * @property int $hblcusdata_notify2
 * @property string $hblcusdata_notify_info
 * @property int $hblcusdata_alsonotify
 * @property int $hblcusdata_alsonotify2
 * @property string $hblcusdata_alsonotify_info
 * @property int $hblcusdata_is_active
 */
class MasterG3eHblCusdata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_g3e_hbl_cusdata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hblcusdata_hbl_id', 'hblcusdata_job_id', 'hblcusdata_shipper', 'hblcusdata_shipper2', 'hblcusdata_shipper_info', 'hblcusdata_consignee', 'hblcusdata_consignee2', 'hblcusdata_consignee_info', 'hblcusdata_notify', 'hblcusdata_notify2', 'hblcusdata_notify_info', 'hblcusdata_alsonotify', 'hblcusdata_alsonotify2', 'hblcusdata_alsonotify_info', 'hblcusdata_is_active'], 'required'],
            [['hblcusdata_hbl_id', 'hblcusdata_job_id', 'hblcusdata_shipper', 'hblcusdata_shipper2', 'hblcusdata_consignee', 'hblcusdata_consignee2', 'hblcusdata_notify', 'hblcusdata_notify2', 'hblcusdata_alsonotify', 'hblcusdata_alsonotify2', 'hblcusdata_is_active'], 'integer'],
            [['hblcusdata_shipper_info', 'hblcusdata_consignee_info', 'hblcusdata_notify_info', 'hblcusdata_alsonotify_info'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hblcusdata_id' => 'Hblcusdata ID',
            'hblcusdata_hbl_id' => 'Hblcusdata Hbl ID',
            'hblcusdata_job_id' => 'Hblcusdata Job ID',
            'hblcusdata_shipper' => 'Hblcusdata Shipper',
            'hblcusdata_shipper2' => 'Hblcusdata Shipper 2',
            'hblcusdata_shipper_info' => 'Hblcusdata Shipper Info',
            'hblcusdata_consignee' => 'Hblcusdata Consignee',
            'hblcusdata_consignee2' => 'Hblcusdata Consignee 2',
            'hblcusdata_consignee_info' => 'Hblcusdata Consignee Info',
            'hblcusdata_notify' => 'Hblcusdata Notify',
            'hblcusdata_notify2' => 'Hblcusdata Notify 2',
            'hblcusdata_notify_info' => 'Hblcusdata Notify Info',
            'hblcusdata_alsonotify' => 'Hblcusdata Alsonotify',
            'hblcusdata_alsonotify2' => 'Hblcusdata Alsonotify 2',
            'hblcusdata_alsonotify_info' => 'Hblcusdata Alsonotify Info',
            'hblcusdata_is_active' => 'Hblcusdata Is Active',
        ];
    }
}
