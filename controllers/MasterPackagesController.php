<?php

namespace app\controllers;

use app\models\Packages;
use app\models\PackagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class MasterPackagesController extends Controller
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
		$model = new Packages();
        $searchModel = new PackagesSearch();
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
		if(empty($_POST['Packages']['packages_name_old']) || !isset($_POST['Packages']['packages_name_old'])){
			$model = new Packages();
		}else{
			$model = $this->findModel($_POST['Packages']['packages_name_old']);
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
	
	public function actionGetPackages(){
		$name = Yii::$app->request->post('name');
		$packages = Packages::find()->where(['packages_name' => $name])->asArray()->one();
		
		return json_encode([
			'packages' => $packages,
		]);
	}
	
	protected function findModel($name)
    {
        if(($model = Packages::findOne(['packages_name' => $name])) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
