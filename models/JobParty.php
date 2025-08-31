<?php

namespace app\models;

use Yii;

class JobParty extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'job_party';
    }
	
    public function rules()
    {
        return [
            [['id_job', 'customer', 'customer_alias', 'customer_address', 'customer_count', 'shipper', 'shipper_alias', 'shipper_address', 'shipper_count', 'consignee', 'consignee_alias', 'consignee_address', 'consignee_count', 'notify', 'notify_alias', 'notify_address', 'notify_count', 'alsonotify', 'alsonotify_alias', 'alsonotify_address', 'alsonotify_count', 'agent', 'agent_alias', 'agent_address', 'agent_count', 'billingparty_1', 'billingparty_alias_1', 'billingparty_address_1', 'billingparty_count_1', 'billingparty_2', 'billingparty_alias_2', 'billingparty_address_2', 'billingparty_count_2', 'billingparty_3', 'billingparty_alias_3', 'billingparty_address_3', 'billingparty_count_3', 'billingparty_erc', 'billingparty_alias_erc', 'billingparty_address_erc', 'billingparty_count_erc'], 'required'],
            [['id_job', 'customer', 'customer_alias', 'customer_count', 'shipper', 'shipper_alias', 'shipper_count', 'consignee', 'consignee_alias', 'consignee_count', 'notify', 'notify_alias', 'notify_count', 'alsonotify', 'alsonotify_alias', 'alsonotify_count', 'agent', 'agent_alias', 'agent_count', 'billingparty_1', 'billingparty_alias_1', 'billingparty_count_1', 'billingparty_2', 'billingparty_alias_2', 'billingparty_count_2', 'billingparty_3', 'billingparty_alias_3', 'billingparty_count_3', 'billingparty_erc', 'billingparty_alias_erc', 'billingparty_count_erc', 'is_active'], 'integer'],
            [['customer_address', 'shipper_address', 'consignee_address', 'notify_address', 'alsonotify_address', 'agent_address', 'billingparty_address_1', 'billingparty_address_2', 'billingparty_address_3', 'billingparty_address_erc'], 'string'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job' => 'Id Job',
            'customer' => 'Customer',
            'customer_alias' => 'Customer Alias',
            'customer_address' => 'Customer Address',
            'customer_count' => 'Customer Count',
            'shipper' => 'Shipper',
            'shipper_alias' => 'Shipper Alias',
            'shipper_address' => 'Shipper Address',
            'shipper_count' => 'Shipper Count',
            'consignee' => 'Consignee',
            'consignee_alias' => 'Consignee Alias',
            'consignee_address' => 'Consignee Address',
            'consignee_count' => 'Consignee Count',
            'notify' => 'Notify',
            'notify_alias' => 'Notify Alias',
            'notify_address' => 'Notify Address',
            'notify_count' => 'Notify Count',
            'alsonotify' => 'Alsonotify',
            'alsonotify_alias' => 'Alsonotify Alias',
            'alsonotify_address' => 'Alsonotify Address',
            'alsonotify_count' => 'Alsonotify Count',
            'agent' => 'Agent',
            'agent_alias' => 'Agent Alias',
            'agent_address' => 'Agent Address',
            'agent_count' => 'Agent Count',
            'billingparty_1' => 'Billingparty  1',
            'billingparty_alias_1' => 'Billingparty Alias  1',
            'billingparty_address_1' => 'Billingparty Address  1',
            'billingparty_count_1' => 'Billingparty Count  1',
            'billingparty_2' => 'Billingparty  2',
            'billingparty_alias_2' => 'Billingparty Alias  2',
            'billingparty_address_2' => 'Billingparty Address  2',
            'billingparty_count_2' => 'Billingparty Count  2',
            'billingparty_3' => 'Billingparty  3',
            'billingparty_alias_3' => 'Billingparty Alias  3',
            'billingparty_address_3' => 'Billingparty Address  3',
            'billingparty_count_3' => 'Billingparty Count  3',
            'billingparty_erc' => 'Billingparty ERC',
            'billingparty_alias_erc' => 'Billingparty Alias ERC',
            'billingparty_address_erc' => 'Billingparty Address ERC',
            'billingparty_count_erc' => 'Billingparty Count ERC',
            'is_active' => 'Is Active',
        ];
    }
}
