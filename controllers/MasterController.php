<?php

namespace app\controllers;

use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class MasterController extends BaseController
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
		
        return $this->render('index');
    }
}
