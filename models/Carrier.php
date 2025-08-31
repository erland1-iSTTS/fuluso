<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrier".
 *
 * @property int $carrier_id
 * @property string $carrier_code
 * @property string $name1
 * @property string $detail1
 * @property string $name2
 * @property string $detail2
 * @property string $name3
 * @property string $detail3
 * @property string $name4
 * @property string $detail4
 * @property string $name5
 * @property string $detail5
 * @property string $name6
 * @property string $detail6
 * @property string $name7
 * @property string $detail7
 * @property string $name8
 * @property string $detail8
 * @property string $name9
 * @property string $detail9
 * @property string $name10
 * @property string $detail10
 * @property string $scac
 * @property int $is_vendor 0: not vendor, 1: is vendor
 * @property int $is_active
 */
class Carrier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['carrier_code', 'name1', 'detail1', 'name2', 'detail2', 'name3', 'detail3', 'name4', 'detail4', 'name5', 'detail5', 'name6', 'detail6', 'name7', 'detail7', 'name8', 'detail8', 'name9', 'detail9', 'name10', 'detail10', 'scac', 'is_vendor', 'is_active'], 'required'],
            [['carrier_id', 'is_vendor', 'is_active'], 'integer'],
            [['detail1', 'detail2', 'detail3', 'detail4', 'detail5', 'detail6', 'detail7', 'detail8', 'detail9', 'detail10'], 'string'],
            [['carrier_code', 'name1', 'name2', 'name3', 'name4', 'name5', 'name6', 'name7', 'name8', 'name9', 'name10', 'scac'], 'string', 'max' => 255],
            [['carrier_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'carrier_id' => 'Carrier ID',
            'carrier_code' => 'Carrier Code',
            'name1' => 'Name 1',
            'detail1' => 'Detail 1',
            'name2' => 'Name 2',
            'detail2' => 'Detail 2',
            'name3' => 'Name 3',
            'detail3' => 'Detail 3',
            'name4' => 'Name 4',
            'detail4' => 'Detail 4',
            'name5' => 'Name 5',
            'detail5' => 'Detail 5',
            'name6' => 'Name 6',
            'detail6' => 'Detail 6',
            'name7' => 'Name 7',
            'detail7' => 'Detail 7',
            'name8' => 'Name 8',
            'detail8' => 'Detail 8',
            'name9' => 'Name 9',
            'detail9' => 'Detail 9',
            'name10' => 'Name 10',
            'detail10' => 'Detail 10',
            'scac' => 'Scac',
            'is_vendor' => 'Is Vendor',
            'is_active' => 'Is Active',
        ];
    }
}
