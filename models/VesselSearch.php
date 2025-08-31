<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vessel;

class VesselSearch extends Vessel
{
    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
            [['vessel_code', 'vessel_name', 'vessel_lloyd', 'vessel_buildyear', 'vessel_flag', 'vessel_description'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Vessel::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'vessel_code' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'vessel_code', $this->vessel_code])
            ->andFilterWhere(['like', 'vessel_name', $this->vessel_name])
            ->andFilterWhere(['like', 'vessel_lloyd', $this->vessel_lloyd])
            ->andFilterWhere(['like', 'vessel_buildyear', $this->vessel_buildyear])
            ->andFilterWhere(['like', 'vessel_flag', $this->vessel_flag])
            ->andFilterWhere(['like', 'vessel_description', $this->vessel_description]);

        return $dataProvider;
    }
}
