<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterRole;

/**
 * MasterRoleSearch represents the model behind the search form of `app\models\MasterRole`.
 */
class MasterRoleSearch extends MasterRole
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'flag'], 'integer'],
            [['role_name'], 'safe'],
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
        $query = MasterRole::find();

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
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name]);

        return $dataProvider;
    }
}
