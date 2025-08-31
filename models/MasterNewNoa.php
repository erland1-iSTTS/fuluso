<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_new_noa".
 *
 * @property int $id
 * @property int $id_job
 * @property string $manifest_cutoff_date
 * @property int $manifest_cutoff_hour
 * @property string $manifest_cutoff_minute
 * @property int $shipper1
 * @property int $shipper2
 * @property string $shipper3
 * @property int $consignee1
 * @property int $consignee2
 * @property string $consignee3
 * @property int $notify1
 * @property int $notify2
 * @property string $notify3
 * @property int $to_customer1
 * @property int $to_customer2
 * @property string $to_customer3
 * @property string $ref_number
 * @property string $hbl_hawb
 * @property string $mbl_mawb
 * @property int $origin_bill
 * @property int $batch
 * @property string $term
 * @property int $cargo_destination1
 * @property int $cargo_destination2
 * @property string $cargo_destination3
 * @property string $cy_cfs
 * @property string $user
 * @property int $status
 * @property string $timestamp
 */
class MasterNewNoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_new_noa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_job', 'manifest_cutoff_date', 'manifest_cutoff_hour', 'manifest_cutoff_minute', 'shipper1', 'shipper2', 'shipper3', 'consignee1', 'consignee2', 'consignee3', 'notify1', 'notify2', 'notify3', 'to_customer1', 'to_customer2', 'to_customer3', 'ref_number', 'hbl_hawb', 'mbl_mawb', 'origin_bill', 'batch', 'term', 'cargo_destination1', 'cargo_destination2', 'cargo_destination3', 'cy_cfs', 'user', 'status'], 'required'],
            [['id_job', 'manifest_cutoff_hour', 'shipper1', 'shipper2', 'consignee1', 'consignee2', 'notify1', 'notify2', 'to_customer1', 'to_customer2', 'origin_bill', 'batch', 'cargo_destination1', 'cargo_destination2', 'status'], 'integer'],
            [['manifest_cutoff_date', 'timestamp'], 'safe'],
            [['manifest_cutoff_minute', 'shipper3', 'consignee3', 'notify3', 'to_customer3', 'cargo_destination3'], 'string'],
            [['ref_number', 'hbl_hawb', 'mbl_mawb', 'term', 'cy_cfs', 'user'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job' => 'Id Job',
            'manifest_cutoff_date' => 'Manifest Cutoff Date',
            'manifest_cutoff_hour' => 'Manifest Cutoff Hour',
            'manifest_cutoff_minute' => 'Manifest Cutoff Minute',
            'shipper1' => 'Shipper 1',
            'shipper2' => 'Shipper 2',
            'shipper3' => 'Shipper 3',
            'consignee1' => 'Consignee 1',
            'consignee2' => 'Consignee 2',
            'consignee3' => 'Consignee 3',
            'notify1' => 'Notify 1',
            'notify2' => 'Notify 2',
            'notify3' => 'Notify 3',
            'to_customer1' => 'To Customer 1',
            'to_customer2' => 'To Customer 2',
            'to_customer3' => 'To Customer 3',
            'ref_number' => 'Ref Number',
            'hbl_hawb' => 'Hbl Hawb',
            'mbl_mawb' => 'Mbl Mawb',
            'origin_bill' => 'Origin Bill',
            'batch' => 'Batch',
            'term' => 'Term',
            'cargo_destination1' => 'Cargo Destination 1',
            'cargo_destination2' => 'Cargo Destination 2',
            'cargo_destination3' => 'Cargo Destination 3',
            'cy_cfs' => 'Cy Cfs',
            'user' => 'User',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
	
	public function getJob()
	{
		return $this->hasOne(MasterNewJob::className(), ['id' => 'id_job']);
	}
}
