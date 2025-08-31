<?php

namespace app\controllers;

use app\models\Source;
use app\models\SourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterSourceController extends Controller
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
		$model = new Source();
        $searchModel = new SourceSearch();
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
        if(empty($_POST['Source']['source_id']) || !isset($_POST['Source']['source_id'])){
			$model = new Source();
		}else{
			$model = $this->findModel($_POST['Source']['source_id']);
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
	
	public function actionGetSource(){
		$id = Yii::$app->request->post('id');
		$source = Source::find()->where(['source_id' => $id])->asArray()->one();
		
		return json_encode([
			'source' => $source,
		]);
	}
	
    protected function findModel($id)
    {
        if(($model = Source::findOne(['source_id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
