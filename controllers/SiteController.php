<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\ContactForm;
use app\controllers\BaseController;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
    public function actionIndex()
    {
		$this->layout = 'main-menu';
		
        return $this->render('index');
    }
	
	public function actionMerge()
    {
        return $this->render('merge');
    }
	
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new LoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
			
			// role 2 = accounting
			if(Yii::$app->user->identity->id_role == 2){
				return $this->redirect(['accounting/index']);
			// role 4 = operational	
			}elseif(Yii::$app->user->identity->id_role == 4){
				return $this->redirect(['job/index']);
			}else{
				return $this->redirect(['site/index']);
			}
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }
	
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
	
    public function actionAbout()
    {
        return $this->render('about');
    }
}
