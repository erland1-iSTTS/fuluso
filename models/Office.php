<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "office".
 *
 * @property string $office_code
 * @property string $office_name
 * @property int $is_active
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['office_code', 'office_name', 'is_active'], 'required'],
            [['is_active'], 'integer'],
            [['office_code'], 'string', 'max' => 3],
            [['office_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'office_code' => 'Office Code',
            'office_name' => 'Office Name',
            'is_active' => 'Is Active',
        ];
    }
}
