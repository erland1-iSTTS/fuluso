<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Source;

class SourceSearch extends Source
{
    public function rules()
    {
        return [
            [['source_id', 'is_active'], 'integer'],
            [['source_code', 'source_detail'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Source::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'source_code' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'source_id' => $this->source_id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'source_code', $this->source_code])
            ->andFilterWhere(['like', 'source_detail', $this->source_detail]);

        return $dataProvider;
    }
}
