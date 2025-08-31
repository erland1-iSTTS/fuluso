<?php

namespace app\controllers;

use app\models\Signature;
use app\models\SignatureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterSignatureController extends Controller
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
		$model = new Signature();
        $searchModel = new SignatureSearch();
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
        if(empty($_POST['Signature']['signature_id']) || !isset($_POST['Signature']['signature_id'])){
			$model = new Signature();
		}else{
			$model = $this->findModel($_POST['Signature']['signature_id']);
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
	
	public function actionGetSignature(){
		$id = Yii::$app->request->post('id');
		$signature = Signature::find()->where(['signature_id' => $id])->asArray()->one();
		
		return json_encode([
			'signature' => $signature,
		]);
	}
	
    protected function findModel($id)
    {
        if (($model = Signature::findOne(['signature_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
