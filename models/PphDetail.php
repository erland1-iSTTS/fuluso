<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pph_detail".
 *
 * @property int $id
 * @property int $id_header
 * @property string $name
 * @property float $amount
 * @property string $validity
 * @property string $created_date
 */
class PphDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pph_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_header', 'name', 'amount', 'validity'], 'required'],
            [['id_header'], 'integer'],
            [['amount'], 'number'],
            [['validity', 'created_date'], 'safe'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_header' => 'Id Header',
            'name' => 'Name',
            'amount' => 'Amount',
            'validity' => 'Validity',
            'created_date' => 'Created Date',
        ];
    }
}
