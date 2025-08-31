<?php

namespace app\controllers;

use app\models\MasterContainerSearch;
use app\models\MasterContainer;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\VarDumper;

class MobileContainerController extends Controller
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
	
	public function actionMenu()
    {
        return $this->render('menu');
    }
	
	public function actionCreate()
    {
		$model = new MasterContainer();
		
		if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}elseif($this->request->isPost && $model->load($this->request->post())){
			$model->con_job_id = 0;
			$model->con_bl = 0;
			$model->con_count = 0;
			
            if($model->save()){
				Yii::$app->session->setFlash('success', 'Data telah tersimpan');
                return $this->redirect(['create']);
			}else{
				$model->loadDefaultValues();
			}
		}
		
        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    public function actionView()
    {
		$searchModel = new MasterContainerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['<=', 'created_at', date('Y-m-d', strtotime(date('Y-m-d'). '- 1 days'))]);
        $dataProvider->query->orderBy(['created_at'=>SORT_DESC]);
		
		$model = new MasterContainer();
		
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model,
        ]);
    }
	
    public function actionDelete()
    {
        $model = $this->findModel($_POST['MasterContainer']['con_id']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->is_active = 0;
			
			if($model->save(false)){
				Yii::$app->session->setFlash('success', $model->con_code.' '.$model->con_text.' '.$model->con_name);
				return $this->redirect(['view']);
			}
        }
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
    protected function findModel($id)
    {
        if (($model = MasterContainer::findOne(['con_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
