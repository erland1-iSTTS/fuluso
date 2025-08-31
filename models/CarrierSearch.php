<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Carrier;

class CarrierSearch extends Carrier
{
    public function rules()
    {
        return [
            [['carrier_id', 'is_active'], 'integer'],
            [['carrier_code', 'name1', 'detail1', 'name2', 'detail2', 'name3', 'detail3', 'name4', 'detail4', 'name5', 'detail5', 'name6', 'detail6', 'name7', 'detail7', 'name8', 'detail8', 'name9', 'detail9', 'name10', 'detail10', 'scac'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Carrier::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'carrier_id' => $this->carrier_id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'carrier_code', $this->carrier_code])
            ->andFilterWhere(['like', 'name1', $this->name1])
            ->andFilterWhere(['like', 'detail1', $this->detail1])
            ->andFilterWhere(['like', 'name2', $this->name2])
            ->andFilterWhere(['like', 'detail2', $this->detail2])
            ->andFilterWhere(['like', 'name3', $this->name3])
            ->andFilterWhere(['like', 'detail3', $this->detail3])
            ->andFilterWhere(['like', 'name4', $this->name4])
            ->andFilterWhere(['like', 'detail4', $this->detail4])
            ->andFilterWhere(['like', 'name5', $this->name5])
            ->andFilterWhere(['like', 'detail5', $this->detail5])
            ->andFilterWhere(['like', 'name6', $this->name6])
            ->andFilterWhere(['like', 'detail6', $this->detail6])
            ->andFilterWhere(['like', 'name7', $this->name7])
            ->andFilterWhere(['like', 'detail7', $this->detail7])
            ->andFilterWhere(['like', 'name8', $this->name8])
            ->andFilterWhere(['like', 'detail8', $this->detail8])
            ->andFilterWhere(['like', 'name9', $this->name9])
            ->andFilterWhere(['like', 'detail9', $this->detail9])
            ->andFilterWhere(['like', 'name10', $this->name10])
            ->andFilterWhere(['like', 'detail10', $this->detail10])
            ->andFilterWhere(['like', 'scac', $this->scac]);

        return $dataProvider;
    }
}
