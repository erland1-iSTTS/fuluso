<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterPpn;

class MasterPpnSearch extends MasterPpn
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'defaults'], 'integer'],
            [['name', 'validity_begin', 'validity_end', 'created_date'], 'safe'],
            [['amount'], 'number'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = MasterPpn::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'validity_begin' => $this->validity_begin,
            'validity_end' => $this->validity_end,
            'created_date' => $this->created_date,
            'defaults' => $this->defaults,
			'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
