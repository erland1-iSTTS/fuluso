<?php

namespace app\controllers;

use app\models\Unit;
use app\models\UnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterUnitController extends Controller
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
		$model = new Unit();
        $searchModel = new UnitSearch();
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
		if(empty($_POST['Unit']['unit_id']) || !isset($_POST['Unit']['unit_id'])){
			$model = new Unit();
		}else{
			$model = $this->findModel($_POST['Unit']['unit_id']);
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
	
	public function actionGetUnit(){
		$id = Yii::$app->request->post('id');
		$unit = Unit::find()->where(['unit_id' => $id])->asArray()->one();
		
		return json_encode([
			'unit' => $unit,
		]);
	}
	
    protected function findModel($id)
    {
        if(($model = Unit::findOne(['unit_id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
