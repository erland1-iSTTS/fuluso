<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bank;

class BankSearch extends Bank
{
    public function rules()
    {
        return [
            [['b_id', 'flag'], 'integer'],
            [['b_name', 'b_code', 'timestamp'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Bank::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'b_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'b_id' => $this->b_id,
            'timestamp' => $this->timestamp,
			'flag' => 1,
        ]);

        $query->andFilterWhere(['like', 'b_name', $this->b_name])
            ->andFilterWhere(['like', 'b_code', $this->b_code]);

        return $dataProvider;
    }
}
