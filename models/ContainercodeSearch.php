<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Containercode;

class ContainercodeSearch extends Containercode
{
    public function rules()
    {
        return [
            [['containercode_name', 'containercode_description'], 'safe'],
            [['is_active'], 'integer'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Containercode::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'containercode_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'containercode_name', $this->containercode_name])
            ->andFilterWhere(['like', 'containercode_description', $this->containercode_description]);

        return $dataProvider;
    }
}
