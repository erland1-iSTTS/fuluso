<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "container".
 *
 * @property string $container_name
 * @property string $container_description
 * @property int $is_active
 */
class Container extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'container';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['container_name', 'is_active'], 'required'],
            [['is_active'], 'integer'],
            [['container_name', 'container_description'], 'string', 'max' => 255],
            [['container_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'container_name' => 'Container Name',
            'container_description' => 'Container Description',
            'is_active' => 'Is Active',
        ];
    }
}
