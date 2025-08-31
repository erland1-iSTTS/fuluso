<?php

namespace app\controllers;

use app\models\MasterNewCostmiscDetail;
use app\models\MasterNewCostmisc;
use app\models\MasterNewCostoprDetail;
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

class CostOtherController extends BaseController
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
		
        return $this->render('index-cost-other');
    }
	
	public function actionSaveCostOpr()
	{
		// VarDumper::dump($this->request->post(),10,true);die();
		
		$db = MasterNewJobcost::find()
			->where(['vch_id' => $_POST['MasterNewJobcost']['vch_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobcost;
		}
		
		$last_count = MasterNewJobcost::find()->where(['vch_currency'=>'IDR'])->orderBy(['vch_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = 0;
				$model->vch_job_id = 0;
				$model->vch_office_id = $_POST['MasterNewJobcost']['office_id'];
				$model->vch_job_group = 0;
				$model->vch_type = 3;
				$model->vch_group = 0;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_date = $_POST['MasterNewJobcost']['vch_date'];
				$model->vch_due_date = $_POST['MasterNewJobcost']['vch_due_date'];
				$model->vch_code = '-';
				$model->vch_currency = 'IDR';
				$model->vch_pay_for = 0;
				$model->vch_pay_to = $_POST['MasterNewJobcost']['vch_pay_to'];
				$model->vch_total = $_POST['MasterNewJobcost']['vch_total'];
				$model->vch_total_ppn = $_POST['MasterNewJobcost']['vch_total_ppn'];
				$model->vch_grandtotal = $_POST['MasterNewJobcost']['vch_grandtotal'];
				$model->vch_carrier = 0;
				$model->vch_pengembalian = '-';
				$model->vch_is_active = 1;
				
				if($model->save(false)){
					$cost_detail = MasterNewJobcostDetail::deleteall(['vchd_vch_id'=>$model->vch_id]);
					$i = 1;
					foreach($_POST['MasterNewJobcostDetail']['detail'] as $row)
					{
						$detail = new MasterNewJobcostDetail();
						$detail->vchd_vch_id = $model->vch_id;
						$detail->vchd_job_id = $id_job;
						$detail->vchd_job_group = 0;
						$detail->vchd_type = 0;
						$detail->vchd_count = $i;
						$detail->vchd_pos = $row['vchd_pos'];
						$detail->vchd_detail = $row['vchd_detail'] ? $row['vchd_detail'] : '-';
						$detail->vchd_basis1_total = 0;
						$detail->vchd_basis1_type = '-';
						$detail->vchd_basis2_total = $row['qty'];
						$detail->vchd_basis2_type = $row['vchd_unit_type'];
						$detail->vchd_rate = $row['vchd_rate'];
						$detail->vchd_rate_type = '-';
						$detail->vchd_amount = $row['vchd_amount'];
						$detail->vchd_sector = '-';
						$detail->vchd_exch = '-';
						$detail->vchd_id_ppn = $row['vchd_id_ppn'];
						$detail->vchd_ppn = $row['vchd_ppn'];
						$detail->vchd_id_pph = $row['vchd_id_pph'];
						$detail->vchd_pph = $row['vchd_pph'];
						$detail->vchd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['cost-other/index']);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	/* Asli
	
	public function actionSaveCostOpr()
	{
		VarDumper::dump($this->request->post(),10,true);die();
		
		$db = MasterNewCostopr::find()
			->where(['vch_id' => $_POST['MasterNewCostopr']['vch_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewCostopr;
		}
		
		$last_count = MasterNewCostopr::find()->where(['vch_currency'=>'IDR'])->orderBy(['vch_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// $id_job = $model->vch_job_id;
				// $model->vch_job_id = 0;
				// $model->vch_job_group = 0;
				$model->vch_type = 4;
				// $model->vch_group = 0;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_date = $_POST['MasterNewCostopr']['vch_date'];
				$model->vch_due_date = $_POST['MasterNewCostopr']['vch_due_date'];
				// $model->vch_code = '-';
				$model->vch_currency = 'IDR';
				// $model->vch_pay_for = $_POST['MasterNewCostopr']['vch_pay_for'];
				$model->vch_pay_to = $_POST['MasterNewCostopr']['vch_pay_to'];
				$model->vch_total = $_POST['MasterNewCostopr']['vch_total'];
				$model->vch_total_ppn = $_POST['MasterNewCostopr']['vch_total_ppn'];
				$model->vch_grandtotal = $_POST['MasterNewCostopr']['vch_grandtotal'];
				// $model->vch_carrier = 0;
				// $model->vch_pengembalian = '-';
				$model->vch_is_active = 1;
				
				if($model->save(false)){
					$cost_detail = MasterNewCostoprDetail::deleteall(['vchd_vch_id'=>$model->vch_id]);
					$i = 1;
					foreach($_POST['MasterNewCostoprDetail']['detail'] as $row)
					{
						$detail = new MasterNewCostoprDetail();
						$detail->vchd_vch_id = $model->vch_id;
						// $detail->vchd_job_id = $id_job;
						// $detail->vchd_job_group = 0;
						$detail->vchd_type = 0;
						$detail->vchd_count = $i;
						$detail->vchd_pos = $row['vchd_pos'];
						$detail->vchd_detail = $row['vchd_detail'] ? $row['vchd_detail'] : '-';
						// $detail->vchd_basis1_total = $row['vchd_basis1_total'];
						// $detail->vchd_basis1_type = $row['vchd_basis1_type'];
						$detail->vchd_qty = $row['qty'];
						$detail->vchd_rate = $row['vchd_rate'];
						$detail->vchd_unit_type = $row['vchd_unit_type'];
						$detail->vchd_amount = $row['vchd_amount'];
						// $detail->vchd_sector = '-';
						// $detail->vchd_exch = '-';
						$detail->vchd_id_ppn = $row['vchd_id_ppn'];
						$detail->vchd_ppn = $row['vchd_ppn'];
						$detail->vchd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['cost-other/index']);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}*/
	
	public function actionPrintCostOpr($id_cost){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$cost = MasterNewJobcost::find()->where(['vch_id'=>$id_cost])->one();
		
		$filename = 'VPI'.str_pad($cost->vch_count,6,'0',STR_PAD_LEFT);
		
		$content = $this->renderPartial('opr/cost_opr_print',[
			'id_cost' => $id_cost,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionSaveCostMisc()
	{
		$db = MasterNewCostmisc::find()
			->where(['vch_id' => $_POST['MasterNewCostmisc']['vch_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewCostmisc;
		}
		
		$last_count = MasterNewCostmisc::find()->where(['vch_currency'=>'IDR'])->orderBy(['vch_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				// $id_job = $model->vch_job_id;
				// $model->vch_job_id = 0;
				// $model->vch_job_group = 0;
				// $model->vch_type = 0;
				// $model->vch_group = 0;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_date = $_POST['MasterNewCostmisc']['vch_date'];
				$model->vch_due_date = $_POST['MasterNewCostmisc']['vch_due_date'];
				// $model->vch_code = '-';
				$model->vch_currency = 'IDR';
				// $model->vch_pay_for = $_POST['MasterNewCostmisc']['vch_pay_for'];
				$model->vch_pay_to = $_POST['MasterNewCostmisc']['vch_pay_to'];
				$model->vch_total = $_POST['MasterNewCostmisc']['vch_total'];
				$model->vch_total_ppn = $_POST['MasterNewCostmisc']['vch_total_ppn'];
				$model->vch_grandtotal = $_POST['MasterNewCostmisc']['vch_grandtotal'];
				// $model->vch_carrier = 0;
				// $model->vch_pengembalian = '-';
				$model->vch_is_active = 1;
				
				if($model->save(false)){
					$cost_detail = MasterNewCostmiscDetail::deleteall(['vchd_vch_id'=>$model->vch_id]);
					$i = 1;
					foreach($_POST['MasterNewCostmiscDetail']['detail'] as $row)
					{
						$detail = new MasterNewCostmiscDetail();
						$detail->vchd_vch_id = $model->vch_id;
						// $detail->vchd_job_id = $id_job;
						// $detail->vchd_job_group = 0;
						$detail->vchd_type = 0;
						$detail->vchd_count = $i;
						$detail->vchd_pos = $row['vchd_pos'];
						$detail->vchd_detail = $row['vchd_detail'] ? $row['vchd_detail'] : '-';
						// $detail->vchd_basis1_total = $row['vchd_basis1_total'];
						// $detail->vchd_basis1_type = $row['vchd_basis1_type'];
						$detail->vchd_qty = $row['qty'];
						$detail->vchd_rate = $row['vchd_rate'];
						$detail->vchd_unit_type = $row['vchd_unit_type'];
						$detail->vchd_amount = $row['vchd_amount'];
						// $detail->vchd_sector = '-';
						// $detail->vchd_exch = '-';
						$detail->vchd_id_ppn = $row['vchd_id_ppn'];
						$detail->vchd_ppn = $row['vchd_ppn'];
						$detail->vchd_id_pph = $row['vchd_id_pph'];
						$detail->vchd_pph = $row['vchd_pph'];
						$detail->vchd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['cost-other/index']);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionPrintCostMisc($id_cost){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$cost = MasterNewCostmisc::find()->where(['vch_id'=>$id_cost])->one();
		
		$filename = 'VPI'.str_pad($cost->vch_count,6,'0',STR_PAD_LEFT);
		
		$content = $this->renderPartial('misc/cost_misc_print',[
			'id_cost' => $id_cost,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
}
