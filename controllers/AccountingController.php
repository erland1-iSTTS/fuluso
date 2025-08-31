<?php

namespace app\controllers;

use app\models\MasterNewCostmisc;
use app\models\MasterNewCostopr;
use app\models\PosV8;
use app\models\Packages;
use app\models\Currency;
use app\models\CustomerAlias;
use app\models\Customer;
use app\models\MasterNewJobvoucher;
use app\models\MasterNewJobcostDetail;
use app\models\MasterNewJobcost;
use app\models\MasterNewJobinvoiceDetail;
use app\models\MasterNewJobinvoice;
use app\models\ArReceipt;
use app\models\CostVoucherV5;
use app\models\ApVoucher;
use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
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
		
        return $this->render('index-accounting');
    }
	
	// AR Index
	public function actionAr($month=0, $year=0, $curr='IDR')
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		$invoice = MasterNewJobinvoice::find()
					->where(['inv_is_active' => 1])
					->andWhere(['inv_currency' => $curr])
					->andWhere(['year(inv_date)' => $year, 'month(inv_date)' => $month])
					->orderBy(['inv_currency'=>SORT_ASC, 'inv_count'=>SORT_DESC])
					->all();
		
        return $this->render('ar/ar', [
			'model' => $model,
			'invoice' => $invoice,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
	
	public function actionSaveArPayment()
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
		}else{
			$model = MasterNewJobvoucher::find()
						->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
						->one();
		}
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 1])
						->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['vch_pembayaran_type']])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$model->vch_job_id = $model->vch_job_id;
				$model->vch_job_group = 0; 
				$model->vch_bank = $model->vch_bank ? $model->vch_bank : 0; 
				$model->vch_cost = 0; 
				$model->vch_invoice = $model->vch_invoice; 
				$model->vch_type = 1;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
				$model->vch_code = '-';
				$model->bbk_type = 0;
				$model->bkk_type = 0;
				$model->bbk_from = 0;
				$model->vch_date = $model->vch_date;
				$model->vch_currency = $model->vch_currency;
				$model->vch_hmc = 0;
				$model->vch_value_curr = 0;
				$model->vch_pos = 0;
				$model->vch_details = '-';
				$model->vch_quantity = 0;
				$model->vch_unit = '-';
				$model->vch_amount = $model->vch_amount;
				$model->vch_total = '-';
				$model->vch_keterangan = '-';
				$model->vch_customer = 0;
				$model->vch_counter_inv = 0;
				$model->vch_pembayar_customer = '-';
				$model->vch_pembayar_keterangan = '-';
				$model->vch_pembayaran_type = $model->vch_pembayaran_type;
				$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
				$model->vch_date_pph = $_POST['MasterNewJobvoucher']['vch_amount_pph'] ? $_POST['MasterNewJobvoucher']['vch_date_pph'] : '-';
				$model->vch_nomor_pph = $_POST['MasterNewJobvoucher']['vch_nomor_pph'] ? $_POST['MasterNewJobvoucher']['vch_nomor_pph'] : '-';
				$model->vch_amount_pph = $_POST['MasterNewJobvoucher']['vch_amount_pph'] ? $_POST['MasterNewJobvoucher']['vch_amount_pph'] : '-';
				$model->vch_amount_currency = 0;
				$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
				$model->vch_faktur_tgl = $model->vch_date;
				$model->vch_ck_pph = isset($_POST['MasterNewJobvoucher']['vch_ck_pph']) ? 1 : 0;
				$model->vch_label = 0;
				$model->nonbkk = 0;
				$model->vch_is_active = 1;
				$model->vch_edit = 0;
				$model->vch_del = 0;
				$model->vch_file = '';
				
				if($model->save()){
					return $this->redirect(['accounting/ar']);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveArPaymentMultiple()
    {
		$model = new MasterNewJobvoucher();
		
		$multiple = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
					 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 1])
						->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['detail']['1']['vch_pembayaran_type']])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				foreach($_POST['MasterNewJobvoucher']['detail'] as $key => $row){
					$detail = new MasterNewJobvoucher();
					$detail->vch_job_id = $row['vch_job_id'];
					$detail->vch_job_group = 0; 
					$detail->vch_bank = $row['vch_bank'] ? $row['vch_bank'] : 0; 
					$detail->vch_cost = 0; 
					$detail->vch_invoice = $row['vch_invoice']; 
					$detail->vch_type = 1;
					$detail->vch_count = $count;
					$detail->vch_count_multiple = $multiple[$key-1];
					$detail->vch_code = '-';
					$detail->bbk_type = 0;
					$detail->bkk_type = 0;
					$detail->bbk_from = 0;
					$detail->vch_date = $model->vch_date;
					$detail->vch_currency = $row['vch_currency'];
					$detail->vch_hmc = 0;
					$detail->vch_value_curr = 0;
					$detail->vch_pos = 0;
					$detail->vch_details = '-';
					$detail->vch_quantity = 0;
					$detail->vch_unit = '-';
					$detail->vch_amount = $row['vch_amount'];
					$detail->vch_total = '-';
					$detail->vch_keterangan = '-';
					$detail->vch_customer = 0;
					$detail->vch_counter_inv = 0;
					$detail->vch_pembayar_customer = '-';
					$detail->vch_pembayar_keterangan = '-';
					$detail->vch_pembayaran_type = $row['vch_pembayaran_type'];
					$detail->vch_pembayaran_info = $row['vch_pembayaran_info'] ? $row['vch_pembayaran_info'] : '-';
					$detail->vch_date_pph = $row['vch_amount_pph'] ? $row['vch_date_pph'] : '-';
					$detail->vch_nomor_pph = $row['vch_nomor_pph'] ? $row['vch_nomor_pph'] : '-';
					$detail->vch_amount_pph = $row['vch_amount_pph'] ? $row['vch_amount_pph'] : '-';
					$detail->vch_amount_currency = 0;
					$detail->vch_faktur = $row['vch_faktur1'].'.'.$row['vch_faktur2'].'-'.$row['vch_faktur3'].'.'.$row['vch_faktur4'];
					$detail->vch_faktur_tgl = $model->vch_date;
					$detail->vch_ck_pph = isset($row['vch_ck_pph']) ? 1 : 0;
					$detail->vch_label = 0;
					$detail->nonbkk = 0;
					$detail->vch_is_active = 1;
					$detail->vch_edit = 0;
					$detail->vch_del = 0;
					$detail->vch_file = '';
					$detail->save();
				}
				return $this->redirect(['accounting/ar']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	// Modal AR
	public function actionGetInvoiceIdt()
	{
		$id = Yii::$app->request->post('id');
        $invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id])->asArray()->one();
		$invoice_detail = MasterNewJobinvoiceDetail::find()->where(['invd_inv_id'=>$id])->orderBy(['invd_id'=>SORT_ASC])->asArray()->all();
		
		if(isset($invoice)){
			$data_customer = Customer::find()->where(['customer_id' => $invoice['inv_customer'], 'is_active'=>1])->asArray()->one();
			$data_customer_alias = CustomerAlias::find()->where(['customer_alias_id' => $invoice['inv_customer'], 'is_active'=>1])->asArray()->one();
			$date_invoice = date_format(date_create($invoice['inv_date']), 'd-m-Y');
			
			$total = number_format($invoice['inv_total'],2,'.',',');
			$total_ppn = number_format($invoice['inv_total_ppn'],2,'.',',');
			$grandtotal = number_format($invoice['inv_grandtotal'],2,'.',',');
		}else{
			$data_customer = '';
			$data_customer_alias = '';
			$date_invoice = '';
			$total = 0;
			$total_ppn = 0;
			$grandtotal = 0;
		}
		
		if(isset($invoice_detail)){
			foreach($invoice_detail as $row){
				$pos = PosV8::find()->where(['pos_id' => $row['invd_pos'], 'is_active'=>1])->one();
				$pos_name = $pos->pos_name;
				
				$total_basis = number_format($row['invd_basis1_total'],0,'.',',');
				$package = Packages::find()->where(['packages_name' => $row['invd_basis1_type']])->one();
				$packages_basis = $package->packages_name;
				
				$total_qty = number_format($row['invd_basis2_total'],0,'.',',');
				$package = Packages::find()->where(['packages_name' => $row['invd_basis2_type']])->one();
				$packages_qty = $package->packages_name;
				
				$rate = number_format($row['invd_rate'],2,'.',',');
				$amount = number_format($row['invd_amount'],2,'.',',');
				
				$detail[] = [
					'pos_name' => $pos_name,
					'total_basis' => $total_basis,
					'packages_basis' => $packages_basis,
					'total_qty' => $total_qty,
					'packages_qty' => $packages_qty,
					'rate' => $rate,
					'amount' => $amount,
				];
			}
		}else{
			$detail[]= [];
		}
		
		return json_encode([
			'invoice' => $invoice,
			'total' => $total,
			'total_ppn' => $total_ppn,
			'grandtotal' => $grandtotal,
			'detail' => $detail,
			'invoice_detail' => $invoice_detail,
			'data_customer' => $data_customer,
			'data_customer_alias' => $data_customer_alias,
			'date_invoice' => $date_invoice,
		]);
	}
	
	// Modal AR
	public function actionGetArIdt()
    {
		$id = Yii::$app->request->post('id');
		
		$ar_idt = MasterNewJobvoucher::find()
					->where(['vch_id'=>$id])
					->asArray()
					->one();
						
		$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$ar_idt['vch_invoice']])->asArray()->one();
		
		return json_encode([
			'ar_idt' => $ar_idt,
			'invoice' => $invoice,
		]);
	}
	
	// Pdf AR
	public function actionPrintAr($id){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/accounting.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$payment = MasterNewJobvoucher::find()->where(['vch_id'=>$id])->one();
		
		if(isset($payment)){
			if($payment->vch_pembayaran_type == 1){
				$bayar_type = 'ARC-BKM';
			}else{
				$bayar_type = 'ARB-BBM';
			}
			
			if(!empty($payment->vch_count_multiple) && $payment->vch_count_multiple !== '-'){
				$count_multiple = $v['vch_count_multiple'];
			}else{
				$count_multiple = '';
			}
			
			$tahun = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'y');
			$bulan = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'm');
			$vch_count = str_pad($payment->vch_count, 3, '0', STR_PAD_LEFT);
			
			$voucher_number = $tahun.''.$bulan.''.$vch_count;
			
			$filename = $bayar_type.''.$voucher_number.''.$count_multiple;
		}
		
		$content = $this->renderPartial('ar/print_ar',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	// AP Index
	public function actionAp($month=0, $year=0, $curr='IDR')
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		$cost = MasterNewJobcost::find()
			->where(['vch_is_active' => 1])
			->andWhere(['vch_currency' => $curr])
			->andWhere(['year(vch_date)' => $year, 'month(vch_date)' => $month])
			->orderBy(['vch_currency' => SORT_ASC, 'vch_count'=>SORT_DESC])
			->all();
		
        return $this->render('ap/ap', [
			'model' => $model,
			'cost' => $cost,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
	
	public function actionSaveApPayment()
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
		}else{
			$model = MasterNewJobvoucher::find()
						->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
						->one();
		}		
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 2])
						->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['vch_pembayaran_type']])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// Kas
				if($_POST['MasterNewJobvoucher']['vch_pembayaran_type'] == 1){
					$model->vch_job_id = $model->vch_job_id;
					$model->vch_job_group = 0; 
					$model->vch_bank = 0;
					$model->vch_cost = $_POST['MasterNewJobvoucher']['vch_cost']; 
					$model->vch_invoice = 0; 
					$model->vch_type = 2;
					$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
					$model->vch_code = '-';
					$model->bbk_type = 0;
					$model->bkk_type = $model->bkk_type;
					$model->bbk_from = 0;
					$model->vch_date = $model->vch_date;
					$model->vch_currency = $model->vch_currency;
					$model->vch_hmc = 0;
					$model->vch_value_curr = 0;
					$model->vch_pos = 0;
					$model->vch_details = '-';
					$model->vch_quantity = 0;
					$model->vch_unit = '-';
					$model->vch_amount = $model->vch_amount;
					$model->vch_total = '-';
					$model->vch_keterangan = '-';
					$model->vch_customer = 0;
					$model->vch_counter_inv = 0;
					$model->vch_pembayar_customer = '-';
					$model->vch_pembayar_keterangan = '-';
					$model->vch_pembayaran_type = $model->vch_pembayaran_type;
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_date_pph = '-';
					$model->vch_nomor_pph = '-';
					$model->vch_amount_pph = '-';
					$model->vch_amount_currency = 0;
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_faktur_tgl = null;
					$model->vch_ck_pph = 0;
					$model->vch_label = 0;
					$model->nonbkk = 0;
					$model->vch_is_active = 1;
					$model->vch_edit = 0;
					$model->vch_del = 0;
					$model->save();
					
					//Upload Bukti Bayar
					$upload = MasterNewJobvoucher::find()->where(['vch_id' => $model->vch_id])->one();
					
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name, false);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$upload->vch_file = $filename;
					$upload->save();
					
				// Bank
				}else{
					if(isset($_POST['MasterNewJobvoucher']['nonbkk'])){
						$nonbkk = 1;	// Create 1 data : BBK
					}else{
						$nonbkk = 0;	// Create 2 data : BKK dan BBK
					}
					
					// BBK
					$model->vch_job_id = $model->vch_job_id;
					$model->vch_job_group = 0; 
					$model->vch_bank = $_POST['MasterNewJobvoucher']['vch_bank']; 
					$model->vch_cost = $_POST['MasterNewJobvoucher']['vch_cost']; 
					$model->vch_invoice = 0; 
					$model->vch_type = 2;
					$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
					$model->vch_code = '-';
					$model->bbk_type = $model->bbk_type;
					$model->bkk_type = 0;
					$model->bbk_from = 0;
					$model->vch_date = $model->vch_date;
					$model->vch_currency = $model->vch_currency;
					$model->vch_hmc = 0;
					$model->vch_value_curr = 0;
					$model->vch_pos = 0;
					$model->vch_details = '-';
					$model->vch_quantity = 0;
					$model->vch_unit = '-';
					$model->vch_amount = $model->vch_amount;
					$model->vch_total = '-';
					$model->vch_keterangan = '-';
					$model->vch_customer = 0;
					$model->vch_counter_inv = 0;
					$model->vch_pembayar_customer = '-';
					$model->vch_pembayar_keterangan = '-';
					$model->vch_pembayaran_type = '2';
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_date_pph = '-';
					$model->vch_nomor_pph = '-';
					$model->vch_amount_pph = '-';
					$model->vch_amount_currency = 0;
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_faktur_tgl = null;
					$model->vch_ck_pph = 0;
					$model->vch_label = 0;
					$model->nonbkk = 0;
					$model->vch_is_active = 1;
					$model->vch_edit = 0;
					$model->vch_del = 0;
					$model->save();
					
					//Upload Bukti Bayar
					$upload = MasterNewJobvoucher::find()->where(['vch_id' => $model->vch_id])->one();
					
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name, false);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$upload->vch_file = $filename;
					$upload->save();
					
					// BKK
					if($nonbkk == 0){
						$last_count2 = MasterNewJobvoucher::find()
										->where(['vch_type' => 2])
										->andWhere(['vch_pembayaran_type' => 1])
										->orderBy(['vch_count'=>SORT_DESC])
										->one();
						if(isset($last_count2)){
							$count2 = $last_count2->vch_count + 1;
						}else{
							$count2 = 1;
						}
						
						$model2 = new MasterNewJobvoucher();
						$model2->vch_job_id = $model->vch_job_id;
						$model2->vch_job_group = 0; 
						$model2->vch_bank = 0; 
						$model2->vch_cost = $model->vch_cost; 
						$model2->vch_invoice = 0; 
						$model2->vch_type = 2;
						$model2->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count2;
						$model2->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
						$model2->vch_code = '-';
						$model2->bbk_type = 0;
						$model2->bkk_type = $_POST['MasterNewJobvoucher']['non_bkk_type'] ? $_POST['MasterNewJobvoucher']['non_bkk_type'] : 0;
						$model2->bbk_from = $model->vch_id;
						$model2->vch_date = $model->vch_date;
						$model2->vch_currency = $model->vch_currency;
						$model2->vch_hmc = 0;
						$model2->vch_value_curr = 0;
						$model2->vch_pos = 0;
						$model2->vch_details = '-';
						$model2->vch_quantity = 0;
						$model2->vch_unit = '-';
						$model2->vch_amount = $model->vch_amount;
						$model2->vch_total = '-';
						$model2->vch_keterangan = '-';
						$model2->vch_customer = 0;
						$model2->vch_counter_inv = 0;
						$model2->vch_pembayar_customer = '-';
						$model2->vch_pembayar_keterangan = '-';
						$model2->vch_pembayaran_type = '1';
						$model2->vch_pembayaran_info = $model->vch_pembayaran_info;
						$model2->vch_date_pph = '-';
						$model2->vch_nomor_pph = '-';
						$model2->vch_amount_pph = '-';
						$model2->vch_amount_currency = 0;
						$model2->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
						$model2->vch_faktur_tgl = null;
						$model2->vch_ck_pph = 0;
						$model2->vch_label = 0;
						$model2->nonbkk = 0;
						$model2->vch_is_active = 1;
						$model2->vch_edit = 0;
						$model2->vch_del = 0;
						$model2->save();
						
						//Upload Bukti Bayar
						$upload2 = MasterNewJobvoucher::find()->where(['vch_id' => $model2->vch_id])->one();
						
						if(!empty($file)){
							$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model2->vch_id;
							if(!file_exists($path)){
								mkdir($path, 0777, true);
							}
							$file->saveAs($path.'/'.$file->name, false);
							$filename = $file->name;
						}else{
							$filename = '';
						}
						
						$upload2->vch_file = $filename;
						$upload2->save();
					}
				}
				
				return $this->redirect(['accounting/ap']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionEditApPayment()
	{
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
		}else{
			$model = MasterNewJobvoucher::find()
						->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
						->one();
		}	
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// Kas
				if($_POST['MasterNewJobvoucher']['vch_pembayaran_type'] == 1){
					$model->vch_bank = 0;
					$model->bbk_type = 0;
					$model->bkk_type = $_POST['MasterNewJobvoucher']['bkk_type'];
					$model->vch_date = $_POST['MasterNewJobvoucher']['vch_date'];
					$model->vch_currency = $_POST['MasterNewJobvoucher']['vch_currency'];
					$model->vch_amount = $_POST['MasterNewJobvoucher']['vch_amount'];
					$model->vch_pembayaran_type = $_POST['MasterNewJobvoucher']['vch_pembayaran_type'];
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_edit = 1;
					
					//Upload Bukti Bayar
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$model->vch_file = !empty($filename) ? $filename : $model->getOldAttribute('vch_file');
					$model->save();
				// Bank
				}else{
					$model->vch_bank = $_POST['MasterNewJobvoucher']['vch_bank'];
					$model->bbk_type = $_POST['MasterNewJobvoucher']['bbk_type'];
					$model->bkk_type = 0;
					$model->vch_date = $_POST['MasterNewJobvoucher']['vch_date'];
					$model->vch_currency = $_POST['MasterNewJobvoucher']['vch_currency'];
					$model->vch_amount = $_POST['MasterNewJobvoucher']['vch_amount'];
					$model->vch_pembayaran_type = $_POST['MasterNewJobvoucher']['vch_pembayaran_type'];
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_edit = 1;
					
					//Upload Bukti Bayar
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$model->vch_file = !empty($filename) ? $filename : $model->getOldAttribute('vch_file');
					$model->save();
				}
				
				return $this->redirect(['accounting/ap']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveApPaymentMultiple()
    {
		$model = new MasterNewJobvoucher();
		
		$multiple = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
					 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 2])
						->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['detail']['1']['vch_pembayaran_type']])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				foreach($_POST['MasterNewJobvoucher']['detail'] as $key => $row){
					$detail = new MasterNewJobvoucher();
					
					// Kas
					if($row['vch_pembayaran_type'] == 1){
						$detail->vch_job_id = $row['vch_job_id'];
						$detail->vch_job_group = 0; 
						$detail->vch_bank = 0;
						$detail->vch_cost = $row['vch_cost']; 
						$detail->vch_invoice = 0; 
						$detail->vch_type = 2;
						$detail->vch_count = $count;
						$detail->vch_count_multiple = $multiple[$key-1];
						$detail->vch_code = '-';
						$detail->bbk_type = 0;
						$detail->bkk_type = $row['bkk_type'];
						$detail->bbk_from = 0;
						$detail->vch_date = $model->vch_date;
						$detail->vch_currency = $row['vch_currency'];
						$detail->vch_hmc = 0;
						$detail->vch_value_curr = 0;
						$detail->vch_pos = 0;
						$detail->vch_details = '-';
						$detail->vch_quantity = 0;
						$detail->vch_unit = '-';
						$detail->vch_amount = $row['vch_amount'];
						$detail->vch_total = '-';
						$detail->vch_keterangan = '-';
						$detail->vch_customer = 0;
						$detail->vch_counter_inv = 0;
						$detail->vch_pembayar_customer = '-';
						$detail->vch_pembayar_keterangan = '-';
						$detail->vch_pembayaran_type = $row['vch_pembayaran_type'];
						$detail->vch_pembayaran_info = $row['vch_pembayaran_info'] ? $row['vch_pembayaran_info'] : '-';
						$detail->vch_date_pph = '-';
						$detail->vch_nomor_pph = '-';
						$detail->vch_amount_pph = '-';
						$detail->vch_amount_currency = 0;
						$detail->vch_faktur = $row['vch_faktur1'].'.'.$row['vch_faktur2'].'-'.$row['vch_faktur3'].'.'.$row['vch_faktur4'];
						$detail->vch_faktur_tgl = null;
						$detail->vch_ck_pph = 0;
						$detail->vch_label = 0;
						$detail->nonbkk = 0;
						$detail->vch_is_active = 1;
						$detail->vch_edit = 0;
						$detail->vch_del = 0;
						$detail->save();
						
						//Upload Bukti Bayar
						$upload = MasterNewJobvoucher::find()->where(['vch_id' => $detail->vch_id])->one();
						
						$file = UploadedFile::getInstance($model, 'vch_file');
						
						if(!empty($file)){
							$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$detail->vch_id;
							if(!file_exists($path)){
								mkdir($path, 0777, true);
							}
							$file->saveAs($path.'/'.$file->name, false);
							
							$filename = $file->name;
						}else{
							$filename = '';
						}
						
						$upload->vch_file = $filename;
						$upload->save();
						
					// Bank
					}else{
						if(isset($row['nonbkk'])){
							$nonbkk = 1;	// Create 1 data : BBK
						}else{
							$nonbkk = 0;	// Create 2 data : BKK dan BBK
						}
						
						// BBK
						$detail->vch_job_id = $row['vch_job_id'];
						$detail->vch_job_group = 0; 
						$detail->vch_bank = $row['vch_bank']; 
						$detail->vch_cost = $row['vch_cost']; 
						$detail->vch_invoice = 0; 
						$detail->vch_type = 2;
						$detail->vch_count = $count;
						$detail->vch_count_multiple = $multiple[$key-1];
						$detail->vch_code = '-';
						$detail->bbk_type = $row['bbk_type'];
						$detail->bkk_type = 0;
						$detail->bbk_from = 0;
						$detail->vch_date = $model->vch_date;
						$detail->vch_currency = $row['vch_currency'];
						$detail->vch_hmc = 0;
						$detail->vch_value_curr = 0;
						$detail->vch_pos = 0;
						$detail->vch_details = '-';
						$detail->vch_quantity = 0;
						$detail->vch_unit = '-';
						$detail->vch_amount = $row['vch_amount'];
						$detail->vch_total = '-';
						$detail->vch_keterangan = '-';
						$detail->vch_customer = 0;
						$detail->vch_counter_inv = 0;
						$detail->vch_pembayar_customer = '-';
						$detail->vch_pembayar_keterangan = '-';
						$detail->vch_pembayaran_type = '2';
						$detail->vch_pembayaran_info = $row['vch_pembayaran_info'] ? $row['vch_pembayaran_info'] : '-';
						$detail->vch_date_pph = '-';
						$detail->vch_nomor_pph = '-';
						$detail->vch_amount_pph = '-';
						$detail->vch_amount_currency = 0;
						$detail->vch_faktur = $row['vch_faktur1'].'.'.$row['vch_faktur2'].'-'.$row['vch_faktur3'].'.'.$row['vch_faktur4'];
						$detail->vch_faktur_tgl = null;
						$detail->vch_ck_pph = 0;
						$detail->vch_label = 0;
						$detail->nonbkk = 0;
						$detail->vch_is_active = 1;
						$detail->vch_edit = 0;
						$detail->vch_del = 0;
						$detail->save();
						
						//Upload Bukti Bayar
						$upload = MasterNewJobvoucher::find()->where(['vch_id' => $detail->vch_id])->one();
						
						$file = UploadedFile::getInstance($model, 'vch_file');
						
						if(!empty($file)){
							$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$detail->vch_id;
							if(!file_exists($path)){
								mkdir($path, 0777, true);
							}
							$file->saveAs($path.'/'.$file->name, false);
							
							$filename = $file->name;
						}else{
							$filename = '';
						}
						
						$upload->vch_file = $filename;
						$upload->save();
						
						// BKK
						if($nonbkk == 0){
							$last_count2 = MasterNewJobvoucher::find()
											->where(['vch_type' => 2])
											->andWhere(['vch_pembayaran_type' => 1])
											->orderBy(['vch_count'=>SORT_DESC])
											->one();
							if(isset($last_count2)){
								$count2 = $last_count2->vch_count + 1;
							}else{
								$count2 = 1;
							}
							
							$detail2 = new MasterNewJobvoucher();
							$detail2->vch_job_id = $row['vch_job_id'];
							$detail2->vch_job_group = 0; 
							$detail2->vch_bank = 0; 
							$detail2->vch_cost = $row['vch_cost']; 
							$detail2->vch_invoice = 0; 
							$detail2->vch_type = 2;
							$detail2->vch_count = $count2;
							$detail2->vch_count_multiple = $multiple[$key-1];
							$detail2->vch_code = '-';
							$detail2->bbk_type = 0;
							$detail2->bkk_type = $row['non_bkk_type'] ? $row['non_bkk_type'] : 0;
							$detail2->bbk_from = $detail->vch_id;
							$detail2->vch_date = $model->vch_date;
							$detail2->vch_currency = $row['vch_currency'];
							$detail2->vch_hmc = 0;
							$detail2->vch_value_curr = 0;
							$detail2->vch_pos = 0;
							$detail2->vch_details = '-';
							$detail2->vch_quantity = 0;
							$detail2->vch_unit = '-';
							$detail2->vch_amount = $row['vch_amount'];
							$detail2->vch_total = '-';
							$detail2->vch_keterangan = '-';
							$detail2->vch_customer = 0;
							$detail2->vch_counter_inv = 0;
							$detail2->vch_pembayar_customer = '-';
							$detail2->vch_pembayar_keterangan = '-';
							$detail2->vch_pembayaran_type = '1';
							$detail2->vch_pembayaran_info = $row['vch_pembayaran_info'];
							$detail2->vch_date_pph = '-';
							$detail2->vch_nomor_pph = '-';
							$detail2->vch_amount_pph = '-';
							$detail2->vch_amount_currency = 0;
							$detail2->vch_faktur = $row['vch_faktur1'].'.'.$row['vch_faktur2'].'-'.$row['vch_faktur3'].'.'.$row['vch_faktur4'];
							$detail2->vch_faktur_tgl = null;
							$detail2->vch_ck_pph = 0;
							$detail2->vch_label = 0;
							$detail2->nonbkk = 0;
							$detail2->vch_is_active = 1;
							$detail2->vch_edit = 0;
							$detail2->vch_del = 0;
							$detail2->save();
							
							//Upload Bukti Bayar
							$upload2 = MasterNewJobvoucher::find()->where(['vch_id' => $detail2->vch_id])->one();
							
							if(!empty($file)){
								$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$detail2->vch_id;
								if(!file_exists($path)){
									mkdir($path, 0777, true);
								}
								$file->saveAs($path.'/'.$file->name, false);
								$filename = $file->name;
							}else{
								$filename = '';
							}
							
							$upload2->vch_file = $filename;
							$upload2->save();
						}
					}
				}
				return $this->redirect(['accounting/ap']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	// Modal AP
	public function actionGetCostIdt()
	{
		$id = Yii::$app->request->post('id');
        $cost = MasterNewJobcost::find()->where(['vch_id'=>$id])->asArray()->one();
		$cost_detail = MasterNewJobcostDetail::find()->where(['vchd_vch_id'=>$id])->orderBy(['vchd_id'=>SORT_ASC])->asArray()->all();
		
		if(isset($cost)){
			$data_pay_for = Customer::find()->where(['customer_id' => $cost['vch_pay_for'], 'is_active'=>1])->asArray()->one();
			$data_pay_for_alias = CustomerAlias::find()->where(['customer_alias_id' => $cost['vch_pay_for'], 'is_active'=>1])->asArray()->one();
			$data_pay_to = $cost['vch_pay_to'];
			
			$date_cost =  date_format(date_create($cost['vch_date']), 'd-m-Y');
			
			$total = number_format($cost['vch_total'],2,'.',',');
			$total_ppn = number_format($cost['vch_total_ppn'],2,'.',',');
			$grandtotal = number_format($cost['vch_grandtotal'],2,'.',',');
		}else{
			$data_pay_for = '';
			$data_pay_for_alias = '';
			$data_pay_to = '';
			$date_cost = '';
			$total = 0;
			$total_ppn = 0;
			$grandtotal = 0;
		}
		
		if(isset($cost_detail)){
			foreach($cost_detail as $row){
				$pos = PosV8::find()->where(['pos_id' => $row['vchd_pos'], 'is_active'=>1])->one();
				$pos_name = $pos->pos_name;
				
				$total_basis = number_format($row['vchd_basis1_total'],0,'.',',');
				$package = Packages::find()->where(['packages_name' => $row['vchd_basis1_type']])->one();
				$packages_basis = $package->packages_name;
				
				$total_qty = number_format($row['vchd_basis2_total'],0,'.',',');
				$package = Packages::find()->where(['packages_name' => $row['vchd_basis2_type']])->one();
				$packages_qty = $package->packages_name;
				
				$rate = number_format($row['vchd_rate'],2,'.',',');
				$amount = number_format($row['vchd_amount'],2,'.',',');
				
				$detail[] = [
					'pos_name' => $pos_name,
					'total_basis' => $total_basis,
					'packages_basis' => $packages_basis,
					'total_qty' => $total_qty,
					'packages_qty' => $packages_qty,
					'rate' => $rate,
					'amount' => $amount,
				];
			}
		}else{
			$detail[]= [];
		}
		
		return json_encode([
			'cost' => $cost,
			'total' => $total,
			'total_ppn' => $total_ppn,
			'grandtotal' => $grandtotal,
			'detail' => $detail,
			'cost_detail' => $cost_detail,
			'data_pay_for' => $data_pay_for,
			'data_pay_for_alias' => $data_pay_for_alias,
			'data_pay_to' => $data_pay_to,
			'date_cost' => $date_cost,
		]);
	}
	
	// Modal AP
	public function actionGetApIdt()
    {
		$id = Yii::$app->request->post('id');
		
		$ap_idt = MasterNewJobvoucher::find()
					->where(['vch_id'=>$id])
					->asArray()
					->one();
						
		$cost = MasterNewJobcost::find()->where(['vch_id'=>$ap_idt['vch_cost']])->asArray()->one();
		
		return json_encode([
			'ap_idt' => $ap_idt,
			'cost' => $cost,
		]);
	}
	
	// Pdf AP
	public function actionPrintAp($id){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/accounting.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$payment = MasterNewJobvoucher::find()->where(['vch_id'=>$id])->one();
		
		if(isset($payment)){
			if($payment->vch_pembayaran_type == 1){
				$bayar_type = 'APC-BKK';
			}else{
				$bayar_type = 'APB-BBK';
			}
			
			if(!empty($payment->vch_count_multiple) && $payment->vch_count_multiple !== '-'){
				$count_multiple = $v['vch_count_multiple'];
			}else{
				$count_multiple = '';
			}
			
			$tahun = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'y');
			$bulan = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'm');
			$vch_count = str_pad($payment->vch_count, 3, '0', STR_PAD_LEFT);
			
			$voucher_number = $tahun.''.$bulan.''.$vch_count;
			
			$filename = $bayar_type.''.$voucher_number.''.$count_multiple;
		}
		
		$content = $this->renderPartial('ap/print_ap',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	// Operational Index
	public function actionCostOperational($month=0, $year=0)
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		$cost_opr = MasterNewJobvoucher::find()
					->where(['vch_is_active' => 1])
					->andWhere(['vch_faktur' => 'BIAYA OP'])
					->orderBy(['vch_id'=>SORT_ASC])
					->all();
		
        return $this->render('operational/operational', [
			'model' => $model,
			'cost_opr' => $cost_opr,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
	
	public function actionSaveCostOperational()
    {
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
			$new = true;
		}else{
			$model = MasterNewJobvoucher::find()
						->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
						->one();
			$new = false;
		}
		
		if($_POST['MasterNewJobvoucher']['mode'] == 1){
			$vch_type = 1;				// ARB
			$vch_pembayaran_type = '2';	// BBM
		}
		else if($_POST['MasterNewJobvoucher']['mode'] == 2){
			$vch_type = 1;				// ARC
			$vch_pembayaran_type = '1';	// BKM
		}
		else if($_POST['MasterNewJobvoucher']['mode'] == 3){
			$vch_type = 2;				// APB
			$vch_pembayaran_type = '2';	// BBK
		}
		else if($_POST['MasterNewJobvoucher']['mode'] == 4){
			$vch_type = 2;				// APC
			$vch_pembayaran_type = '1';	// BKK
		}
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 2])
						->andWhere(['vch_faktur' => 'BIAYA OP'])
						->andWhere(['vch_pembayaran_type' => $vch_pembayaran_type])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		
		$last_inv_count = MasterNewJobvoucher::find()
						->andWhere(['vch_faktur' => 'BIAYA OP'])
						->orderBy(['vch_counter_inv'=>SORT_DESC])
						->one();
		
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
			$inv_count = $last_inv_count->vch_counter_inv + 1;
		}else{
			$count = 1;
			$inv_count = 1;
		}
		
		if(isset($_POST['MasterNewJobvoucher']['autobkk'])){
			$autobkk = 1;
		}else{
			$autobkk = 0;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				
				foreach($_POST['MasterNewJobvoucher']['Detail'] as $row){
					if($new){
						$model =  new MasterNewJobvoucher;
					}
					$model->vch_job_id = 0;
					$model->vch_job_group = 0; 
					$model->vch_bank = $row['vch_bank'];
					$model->vch_cost = 0; 
					$model->vch_invoice = 0;
					$model->vch_type = $vch_type;
					$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_multiple = '-';
					$model->vch_code = '-';
					$model->bbk_type = 0;
					$model->bkk_type = 0;
					$model->bbk_from = 0;
					$model->vch_date = $row['vch_date'];
					$model->vch_currency = 'IDR';
					$model->vch_hmc = 0;
					$model->vch_value_curr = 0;
					$model->vch_pos = $row['vch_pos'];
					$model->vch_details = $row['vch_details'];
					$model->vch_quantity = 0;
					$model->vch_unit = '-';
					$model->vch_amount = $row['vch_amount'];
					$model->vch_total = '-';
					$model->vch_keterangan = !empty($row['vch_keterangan']) ? $row['vch_keterangan'] : '-';
					$model->vch_customer = 0;
					$model->vch_counter_inv = $inv_count; // Akan dipakai untuk penanda 1 invoice cost dan saat print, bs multi (saat edit counter di report ini wajib update smw)
					$model->vch_pembayar_customer = '-';
					$model->vch_pembayar_keterangan = '-';
					$model->vch_pembayaran_type = $vch_pembayaran_type;
					$model->vch_pembayaran_info = '-';
					$model->vch_date_pph = '-';
					$model->vch_nomor_pph = '-';
					$model->vch_amount_pph = '-';
					$model->vch_amount_currency = 0;
					$model->vch_faktur = 'BIAYA OP';
					$model->vch_faktur_tgl = null;
					$model->vch_ck_pph = 0;
					$model->vch_label = $row['vch_label'];
					$model->nonbkk = 0;
					$model->vch_is_active = 1;
					$model->vch_edit = 0;
					$model->vch_del = 0;
					$model->vch_file = '';
					$model->save();
					
					if($autobkk == 1){
						$last_count2 = MasterNewJobvoucher::find()
										->where(['vch_type' => 2])
										->andWhere(['vch_pembayaran_type' => 1])
										->andWhere(['vch_faktur' => 'BIAYA OP'])
										->orderBy(['vch_count'=>SORT_DESC])
										->one();
						
						if(isset($last_count2)){
							$count2 = $last_count2->vch_count + 1;
						}else{
							$count2 = 1;
						}
						
						$model2 = new MasterNewJobvoucher();
						$model2->vch_job_id = 0;
						$model2->vch_job_group = 0; 
						$model2->vch_bank = $row['vch_bank'];
						$model2->vch_cost = 0; 
						$model2->vch_invoice = 0;
						$model2->vch_type = 2;
						$model2->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
						$model2->vch_count_multiple = '-';
						$model2->vch_code = '-';
						$model2->bbk_type = 0;
						$model2->bkk_type = 1;
						$model2->bbk_from = $model->vch_id;
						$model2->vch_date = $model->vch_date;
						$model2->vch_currency = 'IDR';
						$model2->vch_hmc = 0;
						$model2->vch_value_curr = 0;
						$model2->vch_pos = $row['vch_pos'];
						$model2->vch_details = $row['vch_details'];
						$model2->vch_quantity = 0;
						$model2->vch_unit = '-';
						$model2->vch_amount = $model->vch_amount;
						$model2->vch_total = '-';
						$model2->vch_keterangan = !empty($row['vch_keterangan']) ? $row['vch_keterangan'] : '-';
						$model2->vch_customer = 0;
						$model2->vch_counter_inv = $inv_count;
						$model2->vch_pembayar_customer = '-';
						$model2->vch_pembayar_keterangan = '-';
						$model2->vch_pembayaran_type = '1';
						$model2->vch_pembayaran_info = '-';
						$model2->vch_date_pph = '-';
						$model2->vch_nomor_pph = '-';
						$model2->vch_amount_pph = '-';
						$model2->vch_amount_currency = 0;
						$model2->vch_faktur = 'BIAYA OP';
						$model2->vch_faktur_tgl = null;
						$model2->vch_ck_pph = 0;
						$model2->vch_label = $row['vch_label'];
						$model2->nonbkk = 0;
						$model2->vch_is_active = 1;
						$model2->vch_edit = 0;
						$model2->vch_del = 0;
						$model2->vch_file = '';
						$model2->save();
					}
				}
				return $this->redirect(['accounting/cost-operational']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	// Edit Cost Opr
	public function actionGetCostOperational()
    {
		$id = Yii::$app->request->post('id');
		
		$cost_idr = MasterNewJobvoucher::find()
					->where(['vch_id'=>$id])
					->asArray()
					->one();
		
		if($cost_idr['vch_type'] == 1 && $cost_idr['vch_pembayaran_type'] == 2){
			$mode = 1;
			$mode_name = 'ARB-BBM';
		}else if($cost_idr['vch_type'] == 1 && $cost_idr['vch_pembayaran_type'] == 1){
			$mode = 2;
			$mode_name = 'ARC-BKM';
		}else if($cost_idr['vch_type'] == 2 && $cost_idr['vch_pembayaran_type'] == 2){
			$mode = 3;
			$mode_name = 'APB-BBK';
		}else if($cost_idr['vch_type'] == 2 && $cost_idr['vch_pembayaran_type'] == 1){
			$mode = 4;
			$mode_name = 'APC-BKK';
		}
		
		return json_encode([
			'cost_idr' => $cost_idr,
			'mode' => $mode,
		]);
	}
	
	// Delete Cost Opr
	public function actionDeleteCostOperational($id)
    {
		$cost_idr = MasterNewJobvoucher::find()
					->where(['vch_id'=>$id])
					->one();
		
		$cost_idr->vch_is_active = 0;
		if($cost_idr->save()){
			return $this->redirect(['accounting/cost-operational']);
		}
	}
	
	// Pdf Cost Operational
	public function actionPrintCostOperational($id){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/accounting.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$payment = MasterNewJobvoucher::find()->where(['vch_id'=>$id])->one();
		
		if(isset($payment)){
			if($payment->vch_type == 1 && $payment->vch_pembayaran_type == 2){
				$mode = 1;
				$type = 'BBM';
				$bayar_type = 'ARB-BBM';
			}else if($payment->vch_type == 1 && $payment->vch_pembayaran_type == 1){
				$mode = 2;
				$type = 'BKM';
				$bayar_type = 'ARC-BKM';
			}else if($payment->vch_type == 2 && $payment->vch_pembayaran_type == 2){
				$mode = 3;
				$type = 'BBK';
				$bayar_type = 'APB-BBK';
			}else if($payment->vch_type == 2 && $payment->vch_pembayaran_type == 1){
				$mode = 4;
				$type = 'BKK';
				$bayar_type = 'APC-BKK';
			}
			
			if(!empty($payment->vch_count_multiple) && $payment->vch_count_multiple !== '-'){
				$count_multiple = $v['vch_count_multiple'];
			}else{
				$count_multiple = '';
			}
			
			$tahun = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'y');
			$bulan = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'm');
			$vch_count = str_pad($payment->vch_count, 3, '0', STR_PAD_LEFT);
			
			$voucher_number = $tahun.''.$bulan.''.$vch_count;
			
			$filename = 'COST-OPR_'.$type.''.$voucher_number.''.$count_multiple;
		}
		
		$content = $this->renderPartial('operational/print_operational',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	//-----------------------------------------------------------------------------------------------
	// OLD CODE
	//-----------------------------------------------------------------------------------------------
	
	public function actionGetInvoiceUnpaid(){
		$id_customer = Yii::$app->request->post('id_customer');
		
		$invoice_unpaid = MasterNewJobinvoice::find()
							->joinWith('masterNewJob')
							->where(['inv_customer'=>$id_customer])
							// ->andWhere(['inv_status_bayar'=>0])
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
		
		$last_count = ArReceipt::find()->orderBy(['ar_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->ar_count + 1;
		}else{
			$count = 1;
		}
		
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
	
	
	
	
	public function actionCostOpr($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		$cost = MasterNewJobcost::find()
			->where(['vch_type' => 4])
			->andWhere(['vch_is_active' => 1])
			->andWhere(['year(vch_date)' => $year, 'month(vch_date)' => $month])
			->orderBy(['vch_count' => SORT_DESC])
			->all();
			
		return $this->render('cost_opr/cost_opr', [
			'cost' => $cost,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
	
	public function actionSaveCostOprPayment()
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
		}else{
			$model = MasterNewJobvoucher::find()
				->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
				->one();
		}
		
		$last_count = MasterNewJobvoucher::find()
						->where(['vch_type' => 2])
						->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['vch_pembayaran_type']])
						->orderBy(['vch_count'=>SORT_DESC])
						->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		$last_count_alias = MasterNewJobvoucher::find()
			->where(['vch_type' => 2])
			->andWhere(['vch_pembayaran_type' => $_POST['MasterNewJobvoucher']['vch_pembayaran_type']])
			->orderBy(['vch_count'=>SORT_DESC])
			->one();
		
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// Kas
				if($_POST['MasterNewJobvoucher']['vch_pembayaran_type'] == 1){
					$model->vch_job_id = $model->vch_job_id;
					$model->vch_job_group = 0; 
					$model->vch_bank = 0;
					$model->vch_cost = $_POST['MasterNewJobvoucher']['vch_cost']; 
					$model->vch_invoice = 0; 
					$model->vch_type = 2;
					$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_alias = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
					$model->vch_code = '-';
					$model->bbk_type = 0;
					$model->bkk_type = $model->bkk_type;
					$model->bbk_from = 0;
					$model->vch_date = $model->vch_date;
					$model->vch_currency = $model->vch_currency;
					$model->vch_hmc = 0;
					$model->vch_value_curr = 0;
					$model->vch_pos = 0;
					$model->vch_details = '-';
					$model->vch_quantity = 0;
					$model->vch_unit = '-';
					$model->vch_amount = $model->vch_amount;
					$model->vch_total = '-';
					$model->vch_keterangan = '-';
					$model->vch_customer = 0;
					$model->vch_counter_inv = 0;
					$model->vch_pembayar_customer = '-';
					$model->vch_pembayar_keterangan = '-';
					$model->vch_pembayaran_type = $model->vch_pembayaran_type;
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_date_pph = '-';
					$model->vch_nomor_pph = '-';
					$model->vch_amount_pph = '-';
					$model->vch_amount_currency = 0;
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_faktur_tgl = null;
					$model->vch_ck_pph = 0;
					$model->vch_label = 0;
					$model->nonbkk = 0;
					$model->vch_is_active = 1;
					$model->vch_edit = 0;
					$model->vch_del = 0;
					$model->save();
					
					//Upload Bukti Bayar
					$upload = MasterNewJobvoucher::find()->where(['vch_id' => $model->vch_id])->one();
					
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name, false);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$upload->vch_file = $filename;
					$upload->save();
					
				// Bank
				}else{
					if(isset($_POST['MasterNewJobvoucher']['splitbkk'])){
						$splitbkk = 1;	// Create 2 data : BKK dan BBK
					}else{
						$splitbkk = 0;	// Create 1 data : BBK
					}
					
					// BBK
					$model->vch_job_id = $model->vch_job_id;
					$model->vch_job_group = 0; 
					$model->vch_bank = $_POST['MasterNewJobvoucher']['vch_bank']; 
					$model->vch_cost = $_POST['MasterNewJobvoucher']['vch_cost']; 
					$model->vch_invoice = 0; 
					$model->vch_type = 2;
					$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
					$model->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
					$model->vch_code = '-';
					$model->bbk_type = $model->bbk_type;
					$model->bkk_type = 0;
					$model->bbk_from = 0;
					$model->vch_date = $model->vch_date;
					$model->vch_currency = $model->vch_currency;
					$model->vch_hmc = 0;
					$model->vch_value_curr = 0;
					$model->vch_pos = 0;
					$model->vch_details = '-';
					$model->vch_quantity = 0;
					$model->vch_unit = '-';
					$model->vch_amount = $model->vch_amount;
					$model->vch_total = '-';
					$model->vch_keterangan = '-';
					$model->vch_customer = 0;
					$model->vch_counter_inv = 0;
					$model->vch_pembayar_customer = '-';
					$model->vch_pembayar_keterangan = '-';
					$model->vch_pembayaran_type = '2';
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_date_pph = '-';
					$model->vch_nomor_pph = '-';
					$model->vch_amount_pph = '-';
					$model->vch_amount_currency = 0;
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_faktur_tgl = null;
					$model->vch_ck_pph = 0;
					$model->vch_label = 0;
					$model->nonbkk = 0;
					$model->vch_is_active = 1;
					$model->vch_edit = 0;
					$model->vch_del = 0;
					$model->save();
					
					//Upload Bukti Bayar
					$upload = MasterNewJobvoucher::find()->where(['vch_id' => $model->vch_id])->one();
					
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name, false);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$upload->vch_file = $filename;
					$upload->save();
					
					// BKK
					if($splitbkk == 1){
						$last_count2 = MasterNewJobvoucher::find()
										->where(['vch_type' => 2])
										->andWhere(['vch_pembayaran_type' => 1])
										->orderBy(['vch_count'=>SORT_DESC])
										->one();
						if(isset($last_count2)){
							$count2 = $last_count2->vch_count + 1;
						}else{
							$count2 = 1;
						}
						
						$model2 = new MasterNewJobvoucher();
						$model2->vch_job_id = $model->vch_job_id;
						$model2->vch_job_group = 0; 
						$model2->vch_bank = 0; 
						$model2->vch_cost = $model->vch_cost; 
						$model2->vch_invoice = 0; 
						$model2->vch_type = 2;
						$model2->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count2;
						$model2->vch_count_multiple = $model->getOldAttribute('vch_count_multiple') ? $model->getOldAttribute('vch_count_multiple') : '-';
						$model2->vch_code = '-';
						$model2->bbk_type = 0;
						$model2->bkk_type = $_POST['MasterNewJobvoucher']['non_bkk_type'] ? $_POST['MasterNewJobvoucher']['non_bkk_type'] : 0;
						$model2->bbk_from = $model->vch_id;
						$model2->vch_date = $model->vch_date;
						$model2->vch_currency = $model->vch_currency;
						$model2->vch_hmc = 0;
						$model2->vch_value_curr = 0;
						$model2->vch_pos = 0;
						$model2->vch_details = '-';
						$model2->vch_quantity = 0;
						$model2->vch_unit = '-';
						$model2->vch_amount = $model->vch_amount;
						$model2->vch_total = '-';
						$model2->vch_keterangan = '-';
						$model2->vch_customer = 0;
						$model2->vch_counter_inv = 0;
						$model2->vch_pembayar_customer = '-';
						$model2->vch_pembayar_keterangan = '-';
						$model2->vch_pembayaran_type = '1';
						$model2->vch_pembayaran_info = $model->vch_pembayaran_info;
						$model2->vch_date_pph = '-';
						$model2->vch_nomor_pph = '-';
						$model2->vch_amount_pph = '-';
						$model2->vch_amount_currency = 0;
						$model2->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
						$model2->vch_faktur_tgl = null;
						$model2->vch_ck_pph = 0;
						$model2->vch_label = 0;
						$model2->nonbkk = 0;
						$model2->vch_is_active = 1;
						$model2->vch_edit = 0;
						$model2->vch_del = 0;
						$model2->save();
						
						//Upload Bukti Bayar
						$upload2 = MasterNewJobvoucher::find()->where(['vch_id' => $model2->vch_id])->one();
						
						if(!empty($file)){
							$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model2->vch_id;
							if(!file_exists($path)){
								mkdir($path, 0777, true);
							}
							$file->saveAs($path.'/'.$file->name, false);
							$filename = $file->name;
						}else{
							$filename = '';
						}
						
						$upload2->vch_file = $filename;
						$upload2->save();
					}
				}
				
				return $this->redirect(['accounting/cost-opr']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionEditCostOprPayment()
	{
		if(empty($_POST['MasterNewJobvoucher']['vch_id'])){
			$model = new MasterNewJobvoucher;
		}else{
			$model = MasterNewJobvoucher::find()
						->where(['vch_id' => $_POST['MasterNewJobvoucher']['vch_id']])
						->one();
		}	
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// Kas
				if($_POST['MasterNewJobvoucher']['vch_pembayaran_type'] == 1){
					$model->vch_bank = 0;
					$model->bbk_type = 0;
					$model->bkk_type = $_POST['MasterNewJobvoucher']['bkk_type'];
					$model->vch_date = $_POST['MasterNewJobvoucher']['vch_date'];
					$model->vch_currency = $_POST['MasterNewJobvoucher']['vch_currency'];
					$model->vch_amount = $_POST['MasterNewJobvoucher']['vch_amount'];
					$model->vch_pembayaran_type = $_POST['MasterNewJobvoucher']['vch_pembayaran_type'];
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_edit = 1;
					
					//Upload Bukti Bayar
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$model->vch_file = !empty($filename) ? $filename : $model->getOldAttribute('vch_file');
					$model->save();
				// Bank
				}else{
					$model->vch_bank = $_POST['MasterNewJobvoucher']['vch_bank'];
					$model->bbk_type = $_POST['MasterNewJobvoucher']['bbk_type'];
					$model->bkk_type = 0;
					$model->vch_date = $_POST['MasterNewJobvoucher']['vch_date'];
					$model->vch_currency = $_POST['MasterNewJobvoucher']['vch_currency'];
					$model->vch_amount = $_POST['MasterNewJobvoucher']['vch_amount'];
					$model->vch_pembayaran_type = $_POST['MasterNewJobvoucher']['vch_pembayaran_type'];
					$model->vch_pembayaran_info = $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] ? $_POST['MasterNewJobvoucher']['vch_pembayaran_info'] : '-';
					$model->vch_faktur = $_POST['MasterNewJobvoucher']['vch_faktur1'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur2'].'-'.$_POST['MasterNewJobvoucher']['vch_faktur3'].'.'.$_POST['MasterNewJobvoucher']['vch_faktur4'];
					$model->vch_edit = 1;
					
					//Upload Bukti Bayar
					$file = UploadedFile::getInstance($model, 'vch_file');
					
					if(!empty($file)){
						$path = Yii::getAlias('@app').'/web/upload/payment_ap/'.$model->vch_id;
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$file->saveAs($path.'/'.$file->name);
						
						$filename = $file->name;
					}else{
						$filename = '';
					}
					
					$model->vch_file = !empty($filename) ? $filename : $model->getOldAttribute('vch_file');
					$model->save();
				}
				
				return $this->redirect(['accounting/cost-opr']);
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	
	
	public function actionCostMisc($month=0, $year=0)
    {
		$model = new MasterNewJobvoucher();
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		$cost = MasterNewCostmisc::find()
			->where(['vch_is_active' => 1])
			->andWhere(['year(vch_date)' => $year, 'month(vch_date)' => $month])
			->orderBy(['vch_count'=>SORT_DESC])
			->all();
		
        return $this->render('cost_misc/cost_misc', [
			'model' => $model,
			'cost' => $cost,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
}
