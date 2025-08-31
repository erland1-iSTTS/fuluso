<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterNewJob;

/**
 * MasterNewJobSearch represents the model behind the search form of `app\models\MasterNewJob`.
 */
class MasterNewJobSearch extends MasterNewJob
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'job_number', 'g3_total', 'status'], 'integer'],
            [['job', 'job_type', 'job_location', 'job_year', 'job_month', 'job_name', 'customer_name', 'job_customer', 'job_from', 'job_to', 'job_ship', 'job_hb', 'job_mb', 'g3_type', 'g3_packages', 'timestamp', 'additional_notes'], 'safe'],
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
        $query = MasterNewJob::find();

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
            'job_number' => $this->job_number,
            'g3_total' => $this->g3_total,
            'status' => $this->status,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'job_type', $this->job_type])
            ->andFilterWhere(['like', 'job_location', $this->job_location])
            ->andFilterWhere(['like', 'job_year', $this->job_year])
            ->andFilterWhere(['like', 'job_month', $this->job_month])
            ->andFilterWhere(['like', 'job_name', $this->job_name])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'job_customer', $this->job_customer])
            ->andFilterWhere(['like', 'job_from', $this->job_from])
            ->andFilterWhere(['like', 'job_to', $this->job_to])
            ->andFilterWhere(['like', 'job_ship', $this->job_ship])
            ->andFilterWhere(['like', 'job_hb', $this->job_hb])
            ->andFilterWhere(['like', 'job_mb', $this->job_mb])
            ->andFilterWhere(['like', 'g3_type', $this->g3_type])
            ->andFilterWhere(['like', 'additional_notes', $this->additional_notes])
            ->andFilterWhere(['like', 'g3_packages', $this->g3_packages]);

        return $dataProvider;
    }
}
