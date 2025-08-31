<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

class CustomerSearch extends Customer
{
    public function rules()
    {
        return [
            [['customer_id', 'is_active', 'customer_type', 'status'], 'integer'],
            [['customer_nickname', 'customer_companyname', 'customer_address', 'customer_email_1', 'customer_email_2', 'customer_email_3', 'customer_email_4', 'customer_telephone', 'customer_contact_person', 'customer_npwp', 'customer_npwp_file'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Customer::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'customer_nickname' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'customer_id' => $this->customer_id,
            'customer_type' => $this->customer_type,
            'status' => $this->status,
			'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'customer_nickname', $this->customer_nickname])
            ->andFilterWhere(['like', 'customer_companyname', $this->customer_companyname])
            ->andFilterWhere(['like', 'customer_address', $this->customer_address])
            ->andFilterWhere(['like', 'customer_email_1', $this->customer_email_1])
            ->andFilterWhere(['like', 'customer_email_2', $this->customer_email_2])
            ->andFilterWhere(['like', 'customer_email_3', $this->customer_email_3])
            ->andFilterWhere(['like', 'customer_email_4', $this->customer_email_4])
            ->andFilterWhere(['like', 'customer_telephone', $this->customer_telephone])
            ->andFilterWhere(['like', 'customer_contact_person', $this->customer_contact_person])
            ->andFilterWhere(['like', 'customer_npwp', $this->customer_npwp])
            ->andFilterWhere(['like', 'customer_npwp_file', $this->customer_npwp_file]);

        return $dataProvider;
    }
}
