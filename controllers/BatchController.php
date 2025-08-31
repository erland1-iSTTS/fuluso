<?php

namespace app\controllers;

use app\models\MasterVesselRoutingDetail;
use app\models\MasterVesselRouting;
use app\models\MasterVesselRoutingSearch;
use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class BatchController extends BaseController
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
		$this->layout = 'main-menu';
		
		$searchModel = new MasterVesselRoutingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
		$dataProvider->query->orderBy(['id' => SORT_DESC]);
		
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
