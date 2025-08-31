<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $customer_id
 * @property string $customer_nickname
 * @property string $customer_companyname
 * @property string $customer_address
 * @property string $customer_email_1
 * @property string $customer_email_2
 * @property string $customer_email_3
 * @property string $customer_email_4
 * @property string $customer_telephone
 * @property string $customer_contact_person
 * @property string $customer_npwp
 * @property string|null $customer_npwp_file
 * @property int $is_active 0:deleted;1:aktif;2:waiting approval
 * @property int $customer_type 1: Local 2:Overseas
 * @property int $status 0:non agent; 1:agent
 * @property int $is_vendor 0: not vendor, 1: vendor
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_nickname', 'customer_companyname', 'customer_address', 'customer_email_1', 'customer_email_2', 'customer_email_3', 'customer_email_4', 'customer_telephone', 'customer_contact_person', 'customer_npwp', 'is_active', 'customer_type', 'status', 'is_vendor'], 'required'],
            [['customer_address'], 'string'],
            [['is_active', 'customer_type', 'status', 'is_vendor'], 'integer'],
            [['customer_nickname', 'customer_companyname', 'customer_email_1', 'customer_email_2', 'customer_email_3', 'customer_email_4', 'customer_telephone', 'customer_contact_person', 'customer_npwp_file'], 'string', 'max' => 255],
            [['customer_npwp'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'customer_nickname' => 'Customer Nickname',
            'customer_companyname' => 'Customer Companyname',
            'customer_address' => 'Customer Address',
            'customer_email_1' => 'Customer Email  1',
            'customer_email_2' => 'Customer Email  2',
            'customer_email_3' => 'Customer Email  3',
            'customer_email_4' => 'Customer Email  4',
            'customer_telephone' => 'Customer Telephone',
            'customer_contact_person' => 'Customer Contact Person',
            'customer_npwp' => 'Customer Npwp',
            'customer_npwp_file' => 'Customer Npwp File',
            'is_active' => 'Is Active',
            'customer_type' => 'Customer Type',
            'status' => 'Status',
            'is_vendor' => 'Is Vendor',
        ];
    }
}
