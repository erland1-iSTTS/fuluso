<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Signature;

class SignatureSearch extends Signature
{
    public function rules()
    {
        return [
            [['signature_id', 'is_active'], 'integer'],
            [['signature_name'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Signature::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'signature_name' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'signature_id' => $this->signature_id,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'signature_name', $this->signature_name]);

        return $dataProvider;
    }
}
