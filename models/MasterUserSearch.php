<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterUser;

/**
 * MasterUserSearch represents the model behind the search form of `app\models\MasterUser`.
 */
class MasterUserSearch extends MasterUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_role', 'flag'], 'integer'],
            [['fullname', 'email', 'username', 'password', 'timestamp'], 'safe'],
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
        $query = MasterUser::find();

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
            'id_role' => $this->id_role,
            'timestamp' => $this->timestamp,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
