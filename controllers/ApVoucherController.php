<?php

namespace app\controllers;

use app\models\ApVoucher;
use app\models\Customer;
use app\models\MasterG3eJobrouting;
use app\models\MasterNewJob;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');

class ApVoucherController extends Controller
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
		
		$model = new ApVoucher;
		
        return $this->render('index', [
            'model' => $model,
        ]);
    }
	
	public function actionCreate()
    {
		$this->layout = 'main-menu';
		
		$model = new ApVoucher();

        if($this->request->isPost){
            if($model->load($this->request->post())){
				
				foreach($_POST['ApVoucher']['detail'] as $row){
					$job = MasterNewJob::find()->where(['id'=>$row['id_job']])->one();
					$reference = MasterG3eJobrouting::find()->where(['jr_job_id'=>$row['id_job']])->one();
					
					if(empty($reference->jr_mbl)){
						$mbl = '-';
					}else{
						$mbl = strtoupper($reference->jr_mbl);
					}
					
					if($row['type'] == 'IDT'){
						$id_ppn = $row['id_ppn'];
						$ppn = $row['ppn'];
						$pph = $row['pph'];
					}else{
						$id_ppn = null;
						$ppn = 0;
						$pph = 0;
					}
					
					$last_count = ApVoucher::find()->where(['is_active'=>1])->orderBy(['voucher_number'=>SORT_DESC])->one();
					if(isset($last_count)){
						$count = $last_count->voucher_number + 1;
					}else{
						$count = 1;
					}
					
					$model = new ApVoucher();
					$model->id_job = $row['id_job'];
					$model->voucher_year = date('Y');
					$model->voucher_month = date('m');
					$model->voucher_day = date('d');
					$model->voucher_number = $count;
					$model->voucher_name = 'AP-'.$row['type'].'-'.date('y').date('m').date('d').'-'.$count;
					$model->no_mbl = $mbl;
					$model->type = $row['type'];
					$model->id_pay_for = $job->job_customer;
					$model->id_pay_to = $row['pay_to'];
					$model->invoice_no = $row['invoice_no'];
					$model->invoice_date = $row['invoice_date'];
					$model->due_date = $row['due_date'];
					$model->dpp = $row['dpp'];
					$model->id_ppn = $id_ppn;
					$model->ppn = $ppn;
					$model->pph = $pph;
					$model->amount_idr = $row['amount_idr'];
					$model->amount_usd = $row['amount_usd'];
					$model->currency = $row['currency'];
					$model->id_portfolio_account = $row['id_account'];
					$model->save();
				}
				
                return $this->redirect(['index']);
            }
        }else{
            $model->loadDefaultValues();
        }
		
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
