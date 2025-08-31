<?php

namespace app\controllers;

use app\models\MasterVesselRoutingDetail;
use app\models\MasterVesselRouting;
use app\models\MasterVesselRoutingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use Yii;

class MasterVesselRoutingController extends Controller
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
        $searchModel = new MasterVesselRoutingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionView($id)
    {
		$details = MasterVesselRoutingDetail::find()->where(['id_vessel_routing'=>$id])->all();
		
        return $this->render('view', [
            'model' => $this->findModel($id),
			'details' => $details,
        ]);
    }
	
	public function actionCreate()
    {
		$model = new MasterVesselRouting();
		
		if($this->request->isPost){
			if($model->load($this->request->post())){
				$detail_count = count($_POST['MasterVesselRoutingDetail']);
				
				// Check nama vessel yg dicentang sbg laden_on_board
				foreach($_POST['MasterVesselRoutingDetail'] as $row){
					if(isset($row['laden_on_board'])){
						$laden_on_board = $row['vessel_code'];
					}
				}
				
				$model->point_start = $_POST['MasterVesselRoutingDetail'][0]['point_etd'];
				$model->vessel_start = $_POST['MasterVesselRoutingDetail'][0]['vessel_code'];
				$model->voyage_start = $_POST['MasterVesselRoutingDetail'][0]['voyage'];
				$model->date_start = $_POST['MasterVesselRoutingDetail'][0]['date_etd'];
				
				$model->point_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['point_eta'];
				$model->vessel_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['vessel_code'];
				$model->voyage_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['voyage'];
				$model->date_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['date_eta'];
				
				$model->laden_on_board = $laden_on_board;
				
				if($model->save()){
					foreach($_POST['MasterVesselRoutingDetail'] as $row)
					{
						$detail = new MasterVesselRoutingDetail();
						$detail->id_vessel_routing = $model->id;
						$detail->vessel_code = $row['vessel_code'];
						$detail->voyage = $row['voyage'];
						$detail->point_etd = $row['point_etd'];
						$detail->date_etd = $row['date_etd'];
						$detail->point_eta = $row['point_eta'];
						$detail->date_eta = $row['date_eta'];
						$detail->laden_on_board = isset($row['laden_on_board']) ? 1 : 0;
						$detail->reference = $row['reference'];
						$detail->save();
					}
					return $this->redirect(['index']);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
		
        return $this->render('create', [
			'model' => $model,
        ]);
    }
	
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$details = MasterVesselRoutingDetail::find()->where(['id_vessel_routing'=>$id])->all();
		
		if($this->request->isPost){
			if($model->load($this->request->post())){
				$detail_count = count($_POST['MasterVesselRoutingDetail']);
				
				// Check nama vessel yg dicentang sbg laden_on_board
				foreach($_POST['MasterVesselRoutingDetail'] as $row){
					if(isset($row['laden_on_board'])){
						$laden_on_board = $row['vessel_code'];
					}
				}
				
				$model->point_start = $_POST['MasterVesselRoutingDetail'][0]['point_etd'];
				$model->vessel_start = $_POST['MasterVesselRoutingDetail'][0]['vessel_code'];
				$model->voyage_start = $_POST['MasterVesselRoutingDetail'][0]['voyage'];
				$model->date_start = $_POST['MasterVesselRoutingDetail'][0]['date_etd'];
				
				$model->point_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['point_eta'];
				$model->vessel_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['vessel_code'];
				$model->voyage_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['voyage'];
				$model->date_end = $_POST['MasterVesselRoutingDetail'][$detail_count-1]['date_eta'];
				
				$model->laden_on_board = $laden_on_board;
				
				if($model->save()){
					$old_vessel_routing_detail = MasterVesselRoutingDetail::deleteall(['id_vessel_routing'=>$model->id]);
					
					foreach($_POST['MasterVesselRoutingDetail'] as $row)
					{
						$detail = new MasterVesselRoutingDetail();
						$detail->id_vessel_routing = $model->id;
						$detail->vessel_code = $row['vessel_code'];
						$detail->voyage = $row['voyage'];
						$detail->point_etd = $row['point_etd'];
						$detail->date_etd = $row['date_etd'];
						$detail->point_eta = $row['point_eta'];
						$detail->date_eta = $row['date_eta'];
						$detail->laden_on_board = isset($row['laden_on_board']) ? 1 : 0;
						$detail->reference = $row['reference'];
						$detail->save();
					}
					return $this->redirect(['index']);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
		
        return $this->render('update', [
            'model' => $model,
            'details' => $details,
        ]);
    }
	
    public function actionDelete()
    {
		$model = $this->findModel($_POST['MasterVesselRouting']['id']);
		
		$model->is_active = 0;
		if($model->save()){
			return $this->redirect(['index']);
		}
    }
	
	protected function findModel($id)
    {
        if(($model = MasterVesselRouting::findOne(['id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
