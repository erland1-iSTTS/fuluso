<?php

namespace app\controllers;

use app\models\Bank;
use app\models\BankSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MasterBankController extends Controller
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
        $searchModel = new BankSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionView($b_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($b_id),
        ]);
    }
	
    public function actionCreate()
    {
        $model = new Bank();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'b_id' => $model->b_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    public function actionUpdate($b_id)
    {
        $model = $this->findModel($b_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'b_id' => $model->b_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
    public function actionDelete($b_id)
    {
        $this->findModel($b_id)->delete();

        return $this->redirect(['index']);
    }
	
    protected function findModel($b_id)
    {
        if (($model = Bank::findOne(['b_id' => $b_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
