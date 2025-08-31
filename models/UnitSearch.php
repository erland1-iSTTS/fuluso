<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unit;

class UnitSearch extends Unit
{
    public function rules()
    {
        return [
            [['unit_id', 'is_active'], 'integer'],
            [['unit_name', 'unit_type'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Unit::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'unit_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'unit_id' => $this->unit_id,
            'unit_type' => $this->unit_type,
            'is_active' => 1,
        ]);
		
        $query->andFilterWhere(['like', 'unit_name', $this->unit_name]);

        return $dataProvider;
    }
}
