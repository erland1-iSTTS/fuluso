<?php

namespace app\controllers;

use app\models\Config;
use app\models\ConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

class ConfigController extends Controller
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
		$model = Config::find()->all();
        $searchModel = new ConfigSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
		
        return $this->render('index', [
			'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionSave()
    {
		if(isset($_POST['Config']['detail'])){
			foreach($_POST['Config']['detail'] as $row){
				$model = Config::find()->where(['id' => $row['id']])->one();
				
				if($row['id'] == 1){
					$model->value = $_POST['hmc'];
				}else{
					$model->value = $row['value'];
				}
				$model->save();
			}
		}
		return $this->redirect(['index']);
    }
	
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    public function actionCreate()
    {
        $model = new Config();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($this->request->isPost && $model->load($this->request->post()) && $model->save()){
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->flag = 0;
		$model->save();
		
        return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
        if (($model = Config::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
