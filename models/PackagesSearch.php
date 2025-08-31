<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Packages;

class PackagesSearch extends Packages
{
    public function rules()
    {
        return [
            [['packages_name', 'packages_plural'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Packages::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'packages_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere(['like', 'packages_name', $this->packages_name])
            ->andFilterWhere(['like', 'packages_plural', $this->packages_plural]);

        return $dataProvider;
    }
}
