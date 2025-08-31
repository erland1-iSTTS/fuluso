<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterPph;

class MasterPphSearch extends MasterPph
{
    public function rules()
    {
        return [
            [['id', 'amount', 'is_active'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MasterPph::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
