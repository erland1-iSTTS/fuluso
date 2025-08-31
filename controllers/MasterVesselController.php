<?php

namespace app\controllers;

use app\models\Vessel;
use app\models\VesselSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterVesselController extends Controller
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
		$model = new Vessel();
        $searchModel = new VesselSearch();
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
	
    public function actionSave()
    {
		if(empty($_POST['Vessel']['id'])){
			$model = new Vessel();
		}else{
			$model = $this->findModel($_POST['Vessel']['id']);
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
	
	public function actionGetVessel(){
		$id = Yii::$app->request->post('id');
		$vessel = Vessel::find()->where(['id' => $id])->asArray()->one();
		
		return json_encode([
			'vessel' => $vessel,
		]);
	}
	
    public function actionDeleteData($id)
    {
		$model = $this->findModel($id);
		$model->is_active = 0;
		$model->save();
		
		return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
        if(($model = Vessel::findOne(['id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
