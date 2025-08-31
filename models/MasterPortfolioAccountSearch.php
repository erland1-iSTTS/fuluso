<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterPortfolioAccount;

class MasterPortfolioAccountSearch extends MasterPortfolioAccount
{
    public function rules()
    {
        return [
            [['id', 'flag'], 'integer'],
            [['name', 'code', 'accountno', 'accountname', 'bankname', 'bankaddress', 'bankswift', 'remarks', 'status'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MasterPortfolioAccount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'id' => $this->id,
            'flag' => 1,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'accountno', $this->accountno])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'accountname', $this->accountname])
            ->andFilterWhere(['like', 'bankname', $this->bankname])
            ->andFilterWhere(['like', 'bankaddress', $this->bankaddress])
            ->andFilterWhere(['like', 'bankswift', $this->bankswift])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
