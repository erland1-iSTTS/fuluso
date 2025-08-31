<?php

namespace app\controllers;

use app\models\Movement;
use app\models\MovementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterMovementController extends Controller
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
		$model = new Movement();
        $searchModel = new MovementSearch();
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
		if(empty($_POST['Movement']['movement_id']) || !isset($_POST['Movement']['movement_id'])){
			$model = new Movement();
		}else{
			$model = $this->findModel($_POST['Movement']['movement_id']);
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
	
	public function actionGetMovement(){
		$id = Yii::$app->request->post('id');
		$movement = Movement::find()->where(['movement_id' => $id])->asArray()->one();
		
		return json_encode([
			'movement' => $movement,
		]);
	}
	
    protected function findModel($id)
    {
        if(($model = Movement::findOne(['movement_id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
