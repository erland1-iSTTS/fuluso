<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Point;

/**
 * PointSearch represents the model behind the search form of `app\models\Point`.
 */
class PointSearch extends Point
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'por', 'pol', 'pot', 'pod', 'fd', 'pots', 'podel', 'is_active'], 'integer'],
            [['point_code', 'point_name', 'point_notes'], 'safe'],
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
        $query = Point::find();

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
            'por' => $this->por,
            'pol' => $this->pol,
            'pot' => $this->pot,
            'pod' => $this->pod,
            'fd' => $this->fd,
            'pots' => $this->pots,
            'podel' => $this->podel,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'point_code', $this->point_code])
            ->andFilterWhere(['like', 'point_name', $this->point_name])
            ->andFilterWhere(['like', 'point_notes', $this->point_notes]);

        return $dataProvider;
    }
}
