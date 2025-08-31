<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Config;

class ConfigSearch extends Config
{
    public function rules()
    {
        return [
            [['id', 'value', 'flag'], 'integer'],
            [['name'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Config::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
            'flag' => 1,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
