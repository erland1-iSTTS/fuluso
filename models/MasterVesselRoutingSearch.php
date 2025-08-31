<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterVesselRouting;

class MasterVesselRoutingSearch extends MasterVesselRouting
{
	public $start;
	public $end;
	
    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
            [['point_start', 'vessel_start', 'voyage_start', 'date_start', 'point_end', 'vessel_end', 'voyage_end', 'date_end', 'laden_on_board',
				'start', 'end'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = MasterVesselRouting::find();
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'id' => $this->id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'is_active' => 1,
        ]);
		
		$query->andFilterWhere(['OR',
			['like', 'point_start', $this->start],
			['like', 'vessel_start', $this->start],
			['like', 'voyage_start', $this->start],
			['like', 'date_start', $this->start]
		]);
		
		$query->andFilterWhere(['OR', 
			['like', 'point_end', $this->end],
			['like', 'vessel_end', $this->end],
			['like', 'voyage_end', $this->end],
			['like', 'date_end', $this->end]
		]);
		
        $query->andFilterWhere(['like', 'point_start', $this->point_start])
            ->andFilterWhere(['like', 'vessel_start', $this->vessel_start])
            ->andFilterWhere(['like', 'voyage_start', $this->voyage_start])
            ->andFilterWhere(['like', 'point_end', $this->point_end])
            ->andFilterWhere(['like', 'vessel_end', $this->vessel_end])
            ->andFilterWhere(['like', 'voyage_end', $this->voyage_end])
            ->andFilterWhere(['like', 'laden_on_board', $this->laden_on_board]);

        return $dataProvider;
    }
}
