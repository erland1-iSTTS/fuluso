<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Point2;

class Point2Search extends Point2
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ch', 'locode', 'name', 'namewodiacritics', 'subdiv', 'function', 'status', 'date', 'iata', 'coordinates', 'remarks'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Point2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'locode' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ch', $this->ch])
            ->andFilterWhere(['like', 'locode', $this->locode])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'namewodiacritics', $this->namewodiacritics])
            ->andFilterWhere(['like', 'subdiv', $this->subdiv])
            ->andFilterWhere(['like', 'function', $this->function])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'iata', $this->iata])
            ->andFilterWhere(['like', 'coordinates', $this->coordinates])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
