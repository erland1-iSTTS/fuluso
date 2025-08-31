<?php

namespace app\controllers;

use app\models\PosV8;
use app\models\PosV8Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterPosV8Controller extends Controller
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
		$model = new PosV8();
        $searchModel = new PosV8Search();
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
	
	public function actionRenew($id){
		$model = PosV8::findOne($id);
		
		$date = date_create($model->pos_validity_end);
		$date->modify('+3 month');
		$model->pos_validity_end = $date->format('Y-m-d');
		
		if($model->save()){
			return $this->redirect(['index']);
		}
	}
	
    public function actionSave()
    {
		if(empty($_POST['PosV8']['pos_id']) || !isset($_POST['PosV8']['pos_id'])){
			$model = new PosV8();
		}else{
			$model = $this->findModel($_POST['PosV8']['pos_id']);
		}
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
				if($model->save()){
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
	
    public function actionDeleteData($id)
    {
        $model = $this->findModel($id);
		$model->is_active = 0;
		$model->save();
		
		return $this->redirect(['index']);
    }
	
	public function actionGetData(){
		$id = Yii::$app->request->post('id');
        $model = PosV8::find()->where(['pos_id' => $id])->asArray()->one();
		
        return json_encode($model);
    }
	
    protected function findModel($id)
    {
        if(($model = PosV8::findOne(['pos_id' => $id])) !== null){
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
