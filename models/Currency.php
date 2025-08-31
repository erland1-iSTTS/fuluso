<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property string $currency_id
 * @property string $currency_name
 * @property int $is_active
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency_id', 'currency_name', 'is_active'], 'required'],
            [['is_active'], 'integer'],
            [['currency_id'], 'string', 'max' => 3],
            [['currency_name'], 'string', 'max' => 100],
            [['currency_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currency_id' => 'Currency ID',
            'currency_name' => 'Currency Name',
            'is_active' => 'Is Active',
        ];
    }
}
