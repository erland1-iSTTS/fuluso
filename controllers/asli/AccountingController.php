<?php

namespace app\controllers;

use app\models\MasterNewJobinvoiceDetail;
use app\models\MasterNewJobinvoice;
use app\models\ArReceipt;
use app\models\CostVoucherV5;
use app\models\ApVoucher;
use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

date_default_timezone_set('Asia/Jakarta');

class AccountingController extends BaseController
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
	
	public function actionGetInvoiceUnpaid(){
		$id_customer = Yii::$app->request->post('id_customer');
		
		$invoice_unpaid = MasterNewJobinvoice::find()
							->joinWith('masterNewJob')
							->where(['inv_customer'=>$id_customer])
							->andWhere(['inv_status_bayar'=>0])
							->andWhere(['inv_is_active'=>1])
							->orderBy(['inv_date'=>SORT_ASC])
							->asArray()
							->all();
							
		if(isset($invoice_unpaid)){
			return json_encode(array(
				'success' => true,
				'invoice_unpaid' => $invoice_unpaid,
			));
		}else{
			return json_encode(array(
				'success' => false,
				'message' => 'Data tidak ada',
			));
		}
	}
	
	public function actionSaveArReceipt()
    {
		$model = new ArReceipt();
		
		$last_count = ArReceipt::find()->where(['like', 'payment_date', date('Y')])->orderBy(['ar_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->ar_count + 1;
		}else{
			$count = 1;
		}
		
		// VarDumper::dump($this->request->post(),10,true);die();
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				
				foreach($_POST['ArReceipt']['detail'] as $row)
				{
					if($row['total_payment'] > 0){
						$detail = new ArReceipt();
						$detail->ar_count = $count;
						$detail->id_job = $row['id_job'];
						$detail->id_invoice = $row['id_invoice'];
						$detail->id_customer = $model->id_customer;
						$detail->invoice_date = $row['invoice_date'];
						$detail->dpp = $row['dpp'];
						$detail->ppn = $row['ppn'];
						$detail->pph = $row['pph'] ? $row['pph'] : 0;
						$detail->total_invoice = $row['total_invoice'];
						$detail->payment_date = date('Y-m-d');
						
						if($row['total_payment'] >= $row['short_paid']){
							$detail->payment_type = 1; // Full
						}else{
							$detail->payment_type = 2; // Partial
						}
						
						if(empty($row['total_payment'])){
							$total_payment = 0;
						}else{
							$total_payment = $row['total_payment'];
						}
						
						$detail->total_payment = $total_payment;
						$detail->currency = 'IDR';
						$detail->id_portfolio_account = $model->id_portfolio_account;
						$detail->id_ppn = 0;
						
						if($detail->save()){
							$invoice = MasterNewJobinvoice::find()->where(['inv_id'=> $row['id_invoice']])->one();
							
							if(empty($row['total_payment'])){
								$total_payment = 0;
							}else{
								$total_payment = $row['total_payment'];
							}
							$sisa = $row['short_paid'] - $total_payment;
							
							// cek Jk pph di jobinvoice sblm nya msh kosongan dan yg skrg post pph nya > 0, mk akan di update data nya 
							if($invoice->is_pph == 0 && $row['pph'] > 0){
								$invoice->is_pph = 1;
								$invoice->inv_pph = $row['pph'];
								
								$invoice->inv_short_paid = $row['short_paid'];
								$invoice->inv_grandtotal = $row['total_invoice'];
							}
							
							if($sisa <= 0){
								$invoice->inv_short_paid = 0;
								$invoice->inv_status_bayar = 1;
							}else{
								$invoice->inv_short_paid = $sisa;
								$invoice->inv_status_bayar = 0;
							}
							$invoice->save();
						}
					}
					
					$count++;
				}
				return $this->redirect(['accounting/index']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionUpdateApPayment()
    {
		$id_ap_voucher = Yii::$app->request->post('id');
		$id_account = Yii::$app->request->post('id_account');
		
		$model = ApVoucher::find()->where(['id' => $id_ap_voucher])->one();
		$model->payment_date = date('Y-m-d');
		$model->id_portfolio_account = $id_account;
		$model->status_bayar = 1;
		
		if($model->save()){
			return json_encode(array(
				'success' => true,
				'message' => 'Data berhasil disimpan',
			));
		}else{
			return json_encode(array(
				'success' => true,
				'message' => 'Data gagal disimpan',
			));
		}
    }
	
	public function actionCreateApOprVoucher()
    {
		$model = new CostVoucherV5();
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
				
				foreach($_POST['CostVoucherV5']['detail'] as $row){
					
					$last_count = CostVoucherV5::find()->where(['cv_year'=>date('Y')])->orderBy(['cv_id'=>SORT_DESC])->one();
					if(isset($last_count)){
						$count = $last_count->cv_code + 1;
					}else{
						$count = 1;
					}
					
					$model = new CostVoucherV5();
					$model->cv_code = $count;
					$model->cv_datecreated = date('Y-m-d');
					$model->cv_datetransaction = date('Y-m-d');
					$model->cv_user = 0;
					$model->cv_type = $_POST['CostVoucherV5']['cv_type'];
					$model->cv_currency = 'IDR';
					$model->cv_source = 0;
					$model->cv_payment = 2;
					$model->id_portfolio_account = 0;
					$model->payment_date = null;
					$model->status_payment = 0;
					$model->cv_pos = $row['cv_pos'];
					$model->cv_detail = $row['cv_detail'];
					$model->cv_qty = $row['cv_qty'];
					$model->cv_packages = $row['cv_packages'];
					$model->cv_amount = $row['cv_amount'];
					$model->id_ppn = 0;
					$model->ppn = 0;
					$model->pph = 0;
					$model->cv_remarks = '-';
					$model->cv_month = date('n');
					$model->cv_year = date('Y');
					$model->cv_suboffice = 0;
					$model->cv_subtotal = $row['cv_subtotal'];
					$model->save();
				}
				return $this->redirect(['index']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionUpdateApOprVoucher()
    {
		$model = new CostVoucherV5();
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
				
				$old = [];
				foreach($_POST['CostVoucherV5']['detail'] as $row){
					if(isset($row['cv_id'])){
						array_push($old, $row['cv_id']);
					}
				}
				
				// Delete data lama, selain yg skrg akan dihapus
				$old_model = CostVoucherV5::deleteall(['NOT IN', 'cv_id', $old]);
				
				// Cek data - update old / create new
				foreach($_POST['CostVoucherV5']['detail'] as $row){
					
					$last_count = CostVoucherV5::find()->where(['cv_year'=>date('Y')])->orderBy(['cv_id'=>SORT_DESC])->one();
					if(isset($last_count)){
						$count = $last_count->cv_code + 1;
					}else{
						$count = 1;
					}
					
					//Update old
					if(isset($row['cv_id'])){
						$model = CostVoucherV5::find()->where(['cv_id'=>$row['cv_id']])->one();
						$model->cv_type = $_POST['CostVoucherV5']['cv_type'];
						$model->cv_pos = $row['cv_pos'];
						$model->cv_detail = $row['cv_detail'];
						$model->cv_qty = $row['cv_qty'];
						$model->cv_packages = $row['cv_packages'];
						$model->cv_amount = $row['cv_amount'];
						$model->id_ppn = 0;
						$model->ppn = 0;
						$model->pph = 0;
						$model->cv_subtotal = $row['cv_subtotal'];
						$model->save();
					
					//Create new
					}else{
						$model = new CostVoucherV5();
						$model->cv_code = $count;
						$model->cv_datecreated = date('Y-m-d');
						$model->cv_datetransaction = date('Y-m-d');
						$model->cv_user = 0;
						$model->cv_type = $_POST['CostVoucherV5']['cv_type'];
						$model->cv_currency = 'IDR';
						$model->cv_source = 0;
						$model->cv_payment = 2;
						$model->id_portfolio_account = 0;
						$model->payment_date = 0;
						$model->status_payment = 0;
						$model->cv_pos = $row['cv_pos'];
						$model->cv_detail = $row['cv_detail'];
						$model->cv_qty = $row['cv_qty'];
						$model->cv_packages = $row['cv_packages'];
						$model->cv_amount = $row['cv_amount'];
						$model->id_ppn = 0;
						$model->ppn = 0;
						$model->pph = 0;
						$model->cv_remarks = '-';
						$model->cv_month = date('n');
						$model->cv_year = date('Y');
						$model->cv_suboffice = 0;
						$model->cv_subtotal = $row['cv_subtotal'];
						$model->save();
					}
				}
				return $this->redirect(['index']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionUpdateApOprVoucherPayment()
    {
		$model = new CostVoucherV5();
		
		//Check $_POST ada / tidak
		if(!isset($_POST['CostVoucherV5']['detail'])){	
			return $this->redirect(['index']);
		}
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
				foreach($_POST['CostVoucherV5']['detail'] as $row){
					if(isset($row['paid'])){
						$model = CostVoucherV5::find()->where(['cv_id'=>$row['cv_id']])->one();
						$model->payment_date = date('Y-m-d');
						$model->status_payment = 1;
						$model->id_portfolio_account = $row['id_portfolio_account'];
						$model->save();
					}
				}
				return $this->redirect(['index']);
			}
		}else{
            $model->loadDefaultValues();
        }	
	}
}
