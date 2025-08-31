<?php

namespace app\controllers;

use app\models\AccountRepr;
use app\models\AccountReprSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterAccountReprController extends Controller
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
		$model = new AccountRepr();
        $searchModel = new AccountReprSearch();
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
		if(empty($_POST['AccountRepr']['id']) || !isset($_POST['AccountRepr']['id'])){
			$model = new AccountRepr();
		}else{
			$model = $this->findModel($_POST['AccountRepr']['id']);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionGetAccountRepr(){
		$id = Yii::$app->request->post('id');
		$account_repr = AccountRepr::find()->where(['id' => $id])->asArray()->one();
		
		return json_encode([
			'account_repr' => $account_repr,
		]);
	}
	
    protected function findModel($id)
    {
        if(($model = AccountRepr::findOne(['id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
