<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApVoucher;

/**
 * ApVoucherSearch represents the model behind the search form of `app\models\ApVoucher`.
 */
class ApVoucherSearch extends ApVoucher
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_job', 'voucher_number', 'id_pay_for', 'id_pay_to', 'dpp', 'id_ppn', 'ppn', 'pph', 'amount_idr', 'amount_usd', 'id_portfolio_account', 'status_bayar', 'is_active'], 'integer'],
            [['voucher_year', 'voucher_month', 'voucher_day', 'voucher_name', 'no_mbl', 'type', 'invoice_no', 'invoice_date', 'due_date', 'payment_date', 'currency', 'file', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ApVoucher::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_job' => $this->id_job,
            'voucher_number' => $this->voucher_number,
            'id_pay_for' => $this->id_pay_for,
            'id_pay_to' => $this->id_pay_to,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'payment_date' => $this->payment_date,
            'dpp' => $this->dpp,
            'id_ppn' => $this->id_ppn,
            'ppn' => $this->ppn,
            'pph' => $this->pph,
            'amount_idr' => $this->amount_idr,
            'amount_usd' => $this->amount_usd,
            'id_portfolio_account' => $this->id_portfolio_account,
            'status_bayar' => $this->status_bayar,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'voucher_year', $this->voucher_year])
            ->andFilterWhere(['like', 'voucher_month', $this->voucher_month])
            ->andFilterWhere(['like', 'voucher_day', $this->voucher_day])
            ->andFilterWhere(['like', 'voucher_name', $this->voucher_name])
            ->andFilterWhere(['like', 'no_mbl', $this->no_mbl])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
