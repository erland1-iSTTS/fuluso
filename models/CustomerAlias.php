<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_alias".
 *
 * @property int $customer_alias_id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_alias
 * @property int $is_active
 */
class CustomerAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'customer_alias', 'is_active'], 'required'],
            [['customer_id', 'is_active'], 'integer'],
            [['customer_alias'], 'string'],
            [['customer_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_alias_id' => 'Customer Alias ID',
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'customer_alias' => 'Customer Alias',
            'is_active' => 'Is Active',
        ];
    }
}
