<?php

namespace app\controllers;

use app\models\MasterPpn;
use app\models\MasterPpnSearch;
use app\models\PpnDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterPpnController extends Controller
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
		$model = new MasterPpn();
        $searchModel = new MasterPpnSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
			'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new MasterPpn();

        if($this->request->isPost){
            //return "<pre>".print_r($this->request->post(), true)."</pre>";
            if($model->load($this->request->post()) && $model->save()){
                if($this->request->post('details')){
                    foreach($this->request->post('details') as $detail){
                        $modelDetail = new PpnDetail();
                        $modelDetail->name = $detail['name'];
                        $modelDetail->id_header = $model->id;
                        $modelDetail->amount = $detail['amount'];
                        $modelDetail->validity = $detail['validity'];
                        if($modelDetail->save()){

                        }
                        else{
                            return var_dump($modelDetail->getErrors());
                        }
                    }
                }

                return $this->redirect(['index']);
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
        
        if($this->request->isPost){
            if($model->load($this->request->post()) && $model->save()){
                // Handle removed details
                $removedDetails = $this->request->post('removed_details');
                if (!empty($removedDetails)) {
                    $removedIds = json_decode($removedDetails);
                    if (!empty($removedIds)) {
                        PpnDetail::deleteAll(['id' => $removedIds]);
                    }
                }
                
                // Update or create details
                if($this->request->post('details')){
                    foreach($this->request->post('details') as $detail){
                        if (isset($detail['id'])) {
                            // Update existing detail
                            $modelDetail = PpnDetail::findOne($detail['id']);
                            if ($modelDetail) {
                                $modelDetail->name = $detail['name'];
                                $modelDetail->amount = $detail['amount'];
                                $modelDetail->validity = $detail['validity'];
                                $modelDetail->save();
                                continue;
                            }
                        }
                        
                        // Create new detail
                        $modelDetail = new PpnDetail();
                        $modelDetail->name = $detail['name'];
                        $modelDetail->id_header = $model->id;
                        $modelDetail->amount = $detail['amount'];
                        $modelDetail->validity = $detail['validity'];
                        $modelDetail->save();
                    }
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSave()
    {
		if(empty($_POST['MasterPpn']['id']) || !isset($_POST['MasterPpn']['id'])){
			$model = new MasterPpn();
		}else{
			$model = $this->findModel($_POST['MasterPpn']['id']);
		}
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
                $model->save();
				
				return $this->redirect(['index']);
            }
        }else{
            $model->loadDefaultValues();
        }
    }
	
    public function actionDeleteData($id)
    {
		$model = $this->findModel($id);
		$model->is_active = 0;
		$model->save();
		
        return $this->redirect(['index']);
    }
	
	public function actionSetDefault($id)
    {
		MasterPpn::UpdateAll(['defaults'=>0]);
		
		$model = $this->findModel($id);
		$model->defaults = 1;
		$model->save();
		
		return $this->redirect(['index']);
    }
	
	public function actionGetPpn(){
		$id = Yii::$app->request->post('id');
		$ppn = MasterPpn::find()->where(['id' => $id])->asArray()->one();
		
		return json_encode([
			'ppn' => $ppn,
		]);
	}
	
    protected function findModel($id)
    {
        if(($model = MasterPpn::findOne(['id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
