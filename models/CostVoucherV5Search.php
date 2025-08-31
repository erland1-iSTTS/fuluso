<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CostVoucherV5;

/**
 * CostVoucherV5Search represents the model behind the search form of `app\models\CostVoucherV5`.
 */
class CostVoucherV5Search extends CostVoucherV5
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cv_id', 'cv_code', 'cv_user', 'cv_type', 'cv_source', 'cv_payment', 'id_portfolio_account', 'status_payment', 'cv_pos', 'cv_qty', 'id_ppn', 'ppn', 'pph', 'cv_month', 'cv_year', 'cv_suboffice', 'cv_subtotal'], 'integer'],
            [['cv_datecreated', 'cv_datetransaction', 'cv_currency', 'payment_date', 'cv_detail', 'cv_packages', 'cv_remarks'], 'safe'],
            [['cv_amount'], 'number'],
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
        $query = CostVoucherV5::find();

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
            'cv_id' => $this->cv_id,
            'cv_code' => $this->cv_code,
            'cv_datecreated' => $this->cv_datecreated,
            'cv_datetransaction' => $this->cv_datetransaction,
            'cv_user' => $this->cv_user,
            'cv_type' => $this->cv_type,
            'cv_source' => $this->cv_source,
            'cv_payment' => $this->cv_payment,
            'id_portfolio_account' => $this->id_portfolio_account,
            'status_payment' => $this->status_payment,
            'cv_pos' => $this->cv_pos,
            'cv_qty' => $this->cv_qty,
            'cv_amount' => $this->cv_amount,
            'id_ppn' => $this->id_ppn,
            'ppn' => $this->ppn,
            'pph' => $this->pph,
            'cv_month' => $this->cv_month,
            'cv_year' => $this->cv_year,
            'cv_suboffice' => $this->cv_suboffice,
            'cv_subtotal' => $this->cv_subtotal,
        ]);

        $query->andFilterWhere(['like', 'cv_currency', $this->cv_currency])
            ->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'cv_detail', $this->cv_detail])
            ->andFilterWhere(['like', 'cv_packages', $this->cv_packages])
            ->andFilterWhere(['like', 'cv_remarks', $this->cv_remarks]);

        return $dataProvider;
    }
}
