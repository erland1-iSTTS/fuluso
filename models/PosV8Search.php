<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PosV8;

class PosV8Search extends PosV8
{
    public function rules()
    {
        return [
            [['pos_id', 'pos_fee_idr', 'pos_fee_usd', 'pos_jenis', 'is_active'], 'integer'],
            [['pos_for', 'pos_code', 'pos_name', 'pos_type', 'pos_validity_begin', 'pos_validity_end'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PosV8::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'pos_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pos_id' => $this->pos_id,
            'pos_type' => $this->pos_type,
            'pos_jenis' => $this->pos_jenis,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'pos_for', $this->pos_for])
            ->andFilterWhere(['like', 'pos_code', $this->pos_code])
            ->andFilterWhere(['like', 'pos_name', $this->pos_name])
            ->andFilterWhere(['like', 'pos_fee_idr', $this->pos_fee_idr])
            ->andFilterWhere(['like', 'pos_fee_usd', $this->pos_fee_usd])
            ->andFilterWhere(['like', 'pos_validity_begin', $this->pos_validity_begin])
            ->andFilterWhere(['like', 'pos_validity_end', $this->pos_validity_end]);

        return $dataProvider;
    }
}
