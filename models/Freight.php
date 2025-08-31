<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "freight".
 *
 * @property int $freight_id
 * @property string $freight_name
 * @property int $is_active
 */
class Freight extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'freight';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['freight_id', 'freight_name', 'is_active'], 'required'],
            [['freight_id', 'is_active'], 'integer'],
            [['freight_name'], 'string', 'max' => 255],
            [['freight_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'freight_id' => 'Freight ID',
            'freight_name' => 'Freight Name',
            'is_active' => 'Is Active',
        ];
    }
}
