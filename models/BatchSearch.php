<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Batch;

class BatchSearch extends Batch
{
    public function rules()
    {
        return [
            [['batch_id', 'is_active'], 'integer'],
            [['pol_id', 'pol_dod', 'pc_vessel', 'pc_voyage', 'pcv_doa', 'pcv_dod', 'lfp_id', 'lfp_doa', 'lfp_dod', 'lfp_vessel', 'lfp_voyage', 'pod_id', 'pod_doa'], 'safe'],
        ];
    }
	
    public function scenarios()
    {
        return Model::scenarios();
    }
	
    public function search($params)
    {
        $query = Batch::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'batch_id' => SORT_ASC,
				]
			],
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }
		
        $query->andFilterWhere([
            'batch_id' => $this->batch_id,
            'pol_dod' => $this->pol_dod,
            'pcv_doa' => $this->pcv_doa,
            'pcv_dod' => $this->pcv_dod,
            'lfp_doa' => $this->lfp_doa,
            'lfp_dod' => $this->lfp_dod,
            'pod_doa' => $this->pod_doa,
            'is_active' => 1,
        ]);

        $query->andFilterWhere(['like', 'pol_id', $this->pol_id])
            ->andFilterWhere(['like', 'pc_vessel', $this->pc_vessel])
            ->andFilterWhere(['like', 'pc_voyage', $this->pc_voyage])
            ->andFilterWhere(['like', 'lfp_id', $this->lfp_id])
            ->andFilterWhere(['like', 'lfp_vessel', $this->lfp_vessel])
            ->andFilterWhere(['like', 'lfp_voyage', $this->lfp_voyage])
            ->andFilterWhere(['like', 'pod_id', $this->pod_id]);

        return $dataProvider;
    }
}
