<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterContainer;

/**
 * MasterContainerSearch represents the model behind the search form of `app\models\MasterContainer`.
 */
class MasterContainerSearch extends MasterContainer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['con_id', 'con_job_id', 'con_bl', 'con_count', 'is_active'], 'integer'],
            [['con_code', 'con_text', 'con_name', 'created_at'], 'safe'],
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
        $query = MasterContainer::find();

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
            'con_id' => $this->con_id,
            'con_job_id' => $this->con_job_id,
            'con_bl' => $this->con_bl,
            'con_count' => $this->con_count,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'con_code', $this->con_code])
            ->andFilterWhere(['like', 'con_text', $this->con_text])
            ->andFilterWhere(['like', 'con_name', $this->con_name]);

        return $dataProvider;
    }
}
