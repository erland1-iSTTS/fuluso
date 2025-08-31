<?php

namespace app\controllers;

use app\models\MasterPortfolioAccount;
use app\models\MasterPortfolioAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterPortfolioAccountController extends Controller
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
        $searchModel = new MasterPortfolioAccountSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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
	
    public function actionCreate()
    {
        $model = new MasterPortfolioAccount();

        if($this->request->isPost){
            if($model->load($this->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }
        }else{
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
	
    public function actionDeleteData($id)
    {
        $model = $this->findModel($id);
		$model->flag = 0;
		$model->save();

        return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
        if(($model = MasterPortfolioAccount::findOne(['id' => $id])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
