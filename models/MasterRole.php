<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_role".
 *
 * @property int $id
 * @property string $role_name
 * @property int $flag
 */
class MasterRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['flag'], 'integer'],
            [['role_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'flag' => 'Flag',
        ];
    }
}
