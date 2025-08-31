<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\MasterRole;
use app\models\MasterRoleSearch;
use app\models\MasterHakAkses;
use yii\helpers\VarDumper;

class MasterHakAksesController extends BaseController
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
		$model = new MasterRole();
        $searchModel = new MasterRoleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
			'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionCreate()
    {
        $model = new MasterRole();
		
		if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}elseif($this->request->isPost && $model->load($this->request->post())){
			if($model->save()){
				if(isset($_POST['MasterHakAkses']['HakAkses'])){
					foreach($_POST['MasterHakAkses']['HakAkses'] as $row){
						$HakAksesDetail = new MasterHakAkses();
						$data = explode('-', $row);
						
						$HakAksesDetail->id_role = $model->id;
						$HakAksesDetail->id_menu= $data[0];
						$HakAksesDetail->id_action = $data[1];
						$HakAksesDetail->save();
					}
				}
			}
			return $this->redirect(['index']);
        }else{
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdate($id)
    {
		$model = MasterRole::findOne($id);
		
		if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}elseif($this->request->isPost && $model->load($this->request->post())){
			$HakAkses = MasterHakAkses::deleteAll(['id_role'=>$_POST['MasterRole']['id']]);
			
			if(isset($_POST['MasterHakAkses']['HakAkses'])){
				foreach($_POST['MasterHakAkses']['HakAkses'] as $row){
					$HakAksesDetail = new MasterHakAkses();
					$data = explode('-', $row);
					
					$HakAksesDetail->id_role = $model->id;
					$HakAksesDetail->id_menu= $data[0];
					$HakAksesDetail->id_action = $data[1];
					$HakAksesDetail->save();
				}
			}
			
			if($model->save()){
				return $this->redirect(['index']);
			}
        }else{
            $model->loadDefaultValues();
        }
		
		return $this->render('update', [
            'model' => $model,
        ]);
	}
	
	public function actionDelete()
    {
		$model = MasterRole::findOne($_POST['MasterHakAkses']['id']);
		
		if($this->request->isPost && $model->load($this->request->post())){
			$HakAksesDetail = MasterHakAkses::deleteAll(['id_role'=>$_POST['MasterRole']['id']]);
			
			if($model->delete()){
				return $this->redirect(['index']);
			}
        }else{
            $model->loadDefaultValues();
        }
	}
}
