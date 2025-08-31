<?php

namespace app\controllers;

use app\models\MasterVesselRoutingDetail;
use app\models\MasterVesselRouting;
use app\models\Vessel;
use app\models\Point;
use app\models\Batch;
use app\models\BatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

class MasterBatchController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
	
    public function actionIndex()
    {
        $searchModel = new BatchSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionAdd()
    {
		$model = new MasterVesselRouting();
		
		if($this->request->isPost){
			if($model->load($this->request->post())){
				VarDumper::dump($this->request->post(),10,true);die();
				if($model->save()){
					foreach($_POST['MasterVesselRoutingDetail'] as $row)
					{
						$detail = new MasterVesselRoutingDetail();
						$detail->id_master_vessel_routing = $model->id;
						$detail->id_vessel = $row['id_vessel'];
						$detail->voyage = $row['voyage'];
						$detail->id_point_etd = $row['id_point_etd'];
						$detail->date_etd = $row['date_etd'];
						$detail->id_point_eta = $row['id_point_eta'];
						$detail->date_eta = $row['date_eta'];
						$detail->reference = $row['reference'];
						$detail->save();
					}
					return $this->redirect(['index']);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
		
        return $this->render('add', [
			'model' => $model,
        ]);
    }

    public function actionAdd2()
    {
        $vessel = Vessel::find()->asArray()->all();
        $point = Point::find()->asArray()->all();
		
        return $this->render('add2', [
            'vessel' => $vessel,
            'point' => $point,
        ]);
    }
	
    public function actionView($batch_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($batch_id),
        ]);
    }
	
    public function actionCreate()
    {
        $model = new Batch();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'batch_id' => $model->batch_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    public function actionUpdate($batch_id)
    {
        $model = $this->findModel($batch_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'batch_id' => $model->batch_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
    public function actionDelete($batch_id)
    {
        $this->findModel($batch_id)->delete();

        return $this->redirect(['index']);
    }
	
    protected function findModel($batch_id)
    {
        if (($model = Batch::findOne(['batch_id' => $batch_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
