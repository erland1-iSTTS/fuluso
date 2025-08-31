<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movement;

class MovementSearch extends Movement
{
    public function rules()
    {
        return [
            [['movement_id', 'is_active'], 'integer'],
            [['movement_name'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Movement::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'movement_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'movement_id' => $this->movement_id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'movement_name', $this->movement_name]);

        return $dataProvider;
    }
}
