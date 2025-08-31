<?php

namespace app\controllers;

use app\models\MasterNewJob;
use app\models\MasterNewJobvoucher;
use app\controllers\BaseController;
use Mpdf\Mpdf;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

date_default_timezone_set('Asia/Jakarta');

class ReportController extends BaseController
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
		
        return $this->render('index-report');
    }
	
	public function actionReportAr($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$job = MasterNewJob::find()
				->where(['job_year' => $query_year])
				->andWhere(['job_month' => $month])
				->orderBy(['id'=>SORT_ASC])
				->all();
		
        return $this->render('report-ar',[
			'job' => $job,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportAp($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$job = MasterNewJob::find()
				->where(['job_year' => $query_year])
				->andWhere(['job_month' => $month])
				->orderBy(['id'=>SORT_ASC])
				->all();
	
        return $this->render('report-ap', [
			'job' => $job,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportArb($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 2])
				->andWhere(['>', 'vch_invoice', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-arb',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportArbAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->where(['vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 2])
				->andWhere(['>', 'vch_invoice', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-arb',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionReportApb($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 2])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-apb',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportApbAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->where(['vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 2])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-apb',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionPrintArbApb($month=0, $year=0)
    {
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'L',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/report.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 2])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        $content = $this->renderPartial('print-arb-apb',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
		
		$filename = 'Report ARB - APB '.$month.$year;
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename, 'I');
	}
	
	/*public function actionReportArcApc($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-arc-apc',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }*/
	
	public function actionReportArc($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_invoice', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-arc',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportArcAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->where(['vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_invoice', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-arc',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionReportApcConvert($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['!=', 'bbk_from', 0])
				// ->andWhere(['split' => 1])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-apc-convert',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportApcConvertAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->where(['vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['!=', 'bbk_from', 0])
				// ->andWhere(['split' => 1])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-apc-convert',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionReportApcCash($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['OR',['bbk_from' => 0], ['is', 'bbk_from', NULL]])
				// ->andWhere(['split' => 0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-apc-cash',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportApcCashAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->where(['vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['>', 'vch_cost', 0])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' => 0])
				->andWhere(['OR',['bbk_from' => 0], ['is', 'bbk_from', NULL]])
				// ->andWhere(['split' => 0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-apc-cash',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionReportApcFixed($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->joinWith('jobcost.details.pos')
				->where('MONTH(master_new_jobvoucher.vch_date) ='.$month)
				->andWhere('YEAR(master_new_jobvoucher.vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['master_new_jobvoucher.vch_pembayaran_type' => 1])
				->andWhere(['>', 'master_new_jobvoucher.vch_cost', 0])
				->andWhere(['master_new_jobvoucher.vch_currency' => 'IDR'])
				->andWhere(['master_new_jobvoucher.vch_hmc' => 0])
				->andWhere(['OR',['master_new_jobvoucher.bbk_from' => 0], ['is', 'master_new_jobvoucher.bbk_from', NULL]])
				->andWhere(['pos_v8.pos_jenis' => 2])	// Hanya pos yg jenis fixed
				->andWhere(['master_new_jobvoucher.vch_is_active' => 1])
				->orderBy(['master_new_jobvoucher.vch_date' => SORT_ASC, 'master_new_jobvoucher.vch_count_alias' => SORT_ASC, 'master_new_jobvoucher.vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('report-apc-fixed',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportApcFixedAlias($date)
    {
		$filter_date = date_format(date_create_from_format('Y-m-d', $date), 'd-F-Y');
		
		$payments = MasterNewJobvoucher::find()
				->joinWith('jobcost.details.pos')
				->where(['master_new_jobvoucher.vch_date' => $date])
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['master_new_jobvoucher.vch_pembayaran_type' => 1])
				->andWhere(['>', 'master_new_jobvoucher.vch_cost', 0])
				->andWhere(['master_new_jobvoucher.vch_currency' => 'IDR'])
				->andWhere(['master_new_jobvoucher.vch_hmc' => 0])
				->andWhere(['OR',['master_new_jobvoucher.bbk_from' => 0], ['is', 'master_new_jobvoucher.bbk_from', NULL]])
				->andWhere(['pos_v8.pos_jenis' => 2])	// Hanya pos yg jenis fixed
				->andWhere(['master_new_jobvoucher.vch_is_active' => 1])
				->orderBy(['master_new_jobvoucher.vch_date' => SORT_ASC, 'master_new_jobvoucher.vch_count_alias' => SORT_ASC, 'master_new_jobvoucher.vch_count_multiple' => SORT_ASC])
				->all();
		
        return $this->render('modify/report-apc-fixed',[
			'payments' => $payments,
			'filter_date' => $filter_date,
		]);
    }
	
	public function actionPrintArcApc($month=0, $year=0)
    {
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'L',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/report.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$payments = MasterNewJobvoucher::find()
				->where('MONTH(vch_date) ='.$month)
				->andWhere('YEAR(vch_date) ='.$year)
				->andWhere(['AND', ['!=', 'vch_faktur', '-'], ['IS NOT', 'vch_faktur', NULL]])
				->andWhere(['vch_pembayaran_type' => 1])
				->andWhere(['vch_currency' => 'IDR'])
				->andWhere(['vch_hmc' =>  0])
				->andWhere(['vch_is_active' => 1])
				->orderBy(['vch_date' => SORT_ASC, 'vch_count_alias' => SORT_ASC, 'vch_count_multiple' => SORT_ASC])
				->all();
		
        $content = $this->renderPartial('print-arc-apc',[
			'payments' => $payments,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
		
		$filename = 'Report ARC - APC '.$month.$year;
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename, 'I');
	}
	
	public function actionSaveCountAlias()
    {
		$model = MasterNewJobvoucher::findOne($_POST['MasterNewJobvoucher']['vch_id']);
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$model->vch_count_alias = $_POST['MasterNewJobvoucher']['vch_count_alias'];
				$model->save();
				
				if($_POST['report_type'] == 'arb'){
					return $this->redirect(['report/report-arb']);
				}elseif($_POST['report_type'] == 'apb'){
					return $this->redirect(['report/report-apb']);
				}elseif($_POST['report_type'] == 'alias'){
					$link = $_POST['report_link'];
					$params = $_POST['report_params'];
					
					return $this->redirect([$link, 'date' => $params]);
				}
				
				
				
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionReportMr($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$job = MasterNewJob::find()
				->where(['job_year' => $query_year])
				->andWhere(['job_month' => $month])
				->orderBy(['id'=>SORT_ASC])
				->all();
		
        return $this->render('report-mr',[
			'job' => $job,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
	
	public function actionReportMp($month=0, $year=0)
    {
		if(empty($month) && empty($year)){
			$month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
			$year  = date('Y');
			$query_year = date('y');
			$month_year = date('M-Y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
			$query_year = date_format(date_create_from_format('Y', $year), 'y');
			$month_year = date_format(date_create_from_format('m', $month), 'M').'-'.$year;
		}
		
		$job = MasterNewJob::find()
				->where(['job_year' => $query_year])
				->andWhere(['job_month' => $month])
				->orderBy(['id'=>SORT_ASC])
				->all();
	
        return $this->render('report-mp', [
			'job' => $job,
			'filter_month' => $month,
			'filter_year' => $year,
			'month_year' => $month_year,
		]);
    }
}
