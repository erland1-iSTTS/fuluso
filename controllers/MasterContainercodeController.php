<?php

namespace app\controllers;

use app\models\Containercode;
use app\models\ContainercodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterContainercodeController extends Controller
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
		$model = new Containercode();
        $searchModel = new ContainercodeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
			'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionView($name)
    {
		$model = $this->findModel($name);
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
    public function actionSave()
    {
		if(empty($_POST['Containercode']['containercode_name_old']) || !isset($_POST['Containercode']['containercode_name_old'])){
			$model = new Containercode();
		}else{
			$model = $this->findModel($_POST['Containercode']['containercode_name_old']);
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
	
    public function actionDeleteData($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionGetContainercode(){
		$name = Yii::$app->request->post('name');
		$container = Containercode::find()->where(['containercode_name' => $name])->asArray()->one();
		
		return json_encode([
			'container' => $container,
		]);
	}
	
    protected function findModel($name)
    {
        if(($model = Containercode::findOne(['containercode_name' => $name])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
