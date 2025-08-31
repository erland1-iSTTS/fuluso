<?php

namespace app\controllers;

use Mpdf\Mpdf;

use app\models\MasterNewJobinvoiceDetailCost;
use app\models\MasterNewJobinvoiceDetailSell;
use app\models\MasterNewJobcostDetail;
use app\models\MasterNewJobcost;
use app\models\MasterNewJobinvoiceDetail;
use app\models\MasterNewJobinvoice;

use app\models\MasterG3eJobrouting;

use app\models\MasterG3eHblDescription;

use app\models\MasterG3eHblCargodetail;
use app\models\MasterG3eContainer;

use app\models\MasterG3eHblRouting;
use app\models\MasterG3eVesselbatch;
use app\models\MasterNewJobBooking;

use app\models\MasterG3eHblCusdata;
use app\models\JobParty;
use app\models\JobInfo;
use app\models\MasterNewJob;

use app\models\MasterG3eBatch;

use app\models\Signature;
use app\models\MasterVesselRoutingDetail;
use app\models\MasterVesselRouting;
use app\models\CustomerAlias;
use app\models\Customer;
use app\models\Point;

use app\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\PosV8;
use app\models\MasterPpn;
use Yii;

date_default_timezone_set('Asia/Jakarta');

class JobController extends BaseController
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
	public function actionPrintInv($id)
	{
		return $this->render('billing/test_inv_print');
	}

	public function actionPrintInv2($id, $inv_id)
	{
		return $this->render('billing/print_invoice');
	}
	
	/*public function actionPrintCost($id)
	{
		return $this->render('billing/test_cost_print');
	}*/
	
    public function actionIndex($search='', $month=0, $year=0)
	{
		$this->layout = 'main-menu';
		
		// var_dump($month);die();
		
		if(empty($month) && empty($year)){
			$month = date('m');
			$year  = date('y');
		}else{
			$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		
		if(empty($search)){
			$query_search = '';
		}else{
			$query_search = ['OR', ['like', 'job_name', $search], ['like', 'customer_name', $search]];
		}
		
		$jobs = MasterNewJob::find()
				->where(['job'=>'G3'])
				->andWhere(['job_year'=>$year])
				->andWhere(['job_month'=>$month])
				->andWhere($query_search)
				->orderBy(['job_number'=>SORT_DESC])
				->all();
		
        return $this->render('index',[
			'jobs' => $jobs,
			'filter_search' => $search,
			'filter_month' => $month,
			'filter_year' => $year,
		]);
    }
	
	public function actionCreate(){
		$this->layout = 'main-menu';
		
		$model = new MasterNewJob;
		$info = new JobInfo;
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$model->job = 'G3';
				$model->job_location = $model->job_location;
				$model->job_year = date('y');
				$model->job_month = date('m');
				$job_number = str_pad($model->job_number,4,'0',STR_PAD_LEFT);
				$model->job_name = 'G3'.$model->job_type.'-'.$model->job_location.$model->job_year.$model->job_month.$job_number;
				$model->customer_name = '-';
				$model->job_customer = '-';
				$model->job_from = '-';
				$model->job_to = '-';
				$model->job_ship = '-';
				$model->job_hb = '-';
				$model->job_mb = '-';
				$model->g3_type = '-';
				$model->g3_total = '0';
				$model->g3_packages = '-';
				$model->status = '0';
				
                if($model->save()){
					$info->id_job = $model->id; 
					$info->step = 1;		// step draft
					$info->status = 0;		// status blm ada request
					
					if($info->save(false)){
						return $this->redirect(['update', 'id' => $model->id]);
					}
				}
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
	}
	
	public function actionCopyNew($id){
		$this->layout = 'main-menu';
		
		$model = MasterNewJob::find()->where(['id' => $id])->one();
		
		return $this->render('create', [
            'model' => $model,
        ]);
	}
	
	public function actionUpdate($id)
	{
		$this->layout = 'main-menu';
		
		$jobinfo = JobInfo::find()->where(['id_job' => $id, 'is_active' => 1])->one();
		if(!isset($jobinfo)){
			$jobinfo = new JobInfo;
		}
		
		$party = JobParty::find()->where(['id_job' => $id])->one();
		if(!isset($party)){
			$party = new JobParty;
		}
		
		$jobbooking = MasterNewJobBooking::find()->where(['id_job' => $id])->one();
		if(!isset($jobbooking)){
			$jobbooking = new MasterNewJobBooking;
		}
		
		$vessel_routing = MasterNewJobBooking::find()->where(['id_job' => $id])->one();
		if(!isset($vessel_routing)){
			$vessel_routing = new MasterNewJobBooking;
		}
		
		$hblrouting = $db3 = MasterG3eHblRouting::find()->where(['hblrouting_job_id' => $id])->one();
		if(!isset($hblrouting)){
			$hblrouting = new MasterG3eHblRouting;
		}
		
		$cargo = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id' => $id, 'hblcrg_is_active' => 1])->orderBy(['hblcrg_id'=>SORT_ASC])->all();
		if(!isset($cargo)){
			$cargo = new MasterG3eHblCargodetail;
		}
		
		$description = MasterG3eHblDescription::find()->where(['hbldes_job_id' => $id, 'hbldes_is_active' => 1])->one();
		if(!isset($description)){
			$description = new MasterG3eHblDescription;
		}
		
		$freight_terms = MasterG3eHblDescription::find()->where(['hbldes_job_id' => $id, 'hbldes_is_active' => 1])->one();
		if(!isset($freight_terms)){
			$freight_terms = new MasterG3eHblDescription;
		}
		
		$reference = MasterG3eJobrouting::find()->where(['jr_job_id' => $id])->one();
		if(!isset($reference)){
			$reference = new MasterG3eJobrouting;
		}
		
		$ori_bl_batch = MasterG3eBatch::find()->where(['batchform_job' => $id])->one();
		if(!isset($ori_bl_batch)){
			$ori_bl_batch = new MasterG3eBatch;
		}
		
		$footer = MasterG3eHblDescription::find()->where(['hbldes_job_id' => $id, 'hbldes_is_active' => 1])->one();
		if(!isset($footer)){
			$footer = new MasterG3eHblDescription;
		}else{
			$footer->date_of_issue = $footer->hbldes_doi_year.'-'.$footer->hbldes_doi_month.'-'.$footer->hbldes_doi_day;
		}
		
		return $this->render('update', [
            'jobinfo' => $jobinfo,
            'party' => $party,
            'jobbooking' => $jobbooking,
            'vessel_routing' => $vessel_routing,
            'hblrouting' => $hblrouting,
            'cargo' => $cargo,
            'description' => $description,
			'freight_terms' => $freight_terms,
			'reference' => $reference,
			'ori_bl_batch' => $ori_bl_batch,
            'footer' => $footer,
        ]);
    }
	
	public function actionSaveParty()
	{
		$db = MasterNewJobBooking::find()
			->where(['id_job' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		$db2 = MasterG3eHblCusdata::find()
			->where(['hblcusdata_job_id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		$db3 = MasterG3eJobrouting::find()
			->where(['jr_job_id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		$db4 = MasterNewJob::find()
			->where(['id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
			
		$db5 = JobParty::find()
			->where(['id_job' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobBooking;
		}
		
		if(isset($db2)){
			$model2 = $db2;
		}else{
			$model2 = new MasterG3eHblCusdata;
		}
		
		if(isset($db3)){
			$model3 = $db3;
		}else{
			$model3 = new MasterG3eJobrouting;
		}
		
		if(isset($db4)){
			$model4 = $db4;
		}else{
			$model4 = new MasterNewJob;
		}
		
		if(isset($db5)){
			$model5 = $db5;
		}else{
			$model5 = new JobParty;
		}
		
		// VarDumper::dump($this->request->post(),10,true);die();
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->id_job;
				$model->to1 = 0;
				$model->to2 = '-';
				$model->to3 = '-';
				$model->scac_code = '-';
				$model->booking_no = '-';
				$model->service_contract = '-';
				$model->date_booking = date('Y-m-d');
				$model->carrier = '-';
				$model->ref_number = '-';
				$model->port_of_receipt = $model->getOldAttribute('port_of_receipt') ? $model->getOldAttribute('port_of_receipt') : '-';
				$model->port_of_loading = $model->getOldAttribute('port_of_loading') ? $model->getOldAttribute('port_of_loading') : '-';
				$model->port_of_discharge = $model->getOldAttribute('port_of_discharge') ? $model->getOldAttribute('port_of_discharge') : '-';
				$model->final_destination = $model->getOldAttribute('final_destination') ? $model->getOldAttribute('final_destination') : '-';
				$model->hblrouting_movement = $model->getOldAttribute('hblrouting_movement') ? $model->getOldAttribute('hblrouting_movement') : '-';
				$model->batch = $model->getOldAttribute('batch') ? $model->getOldAttribute('batch') : 0;
				$model->shipper1 = $_POST['MasterNewJobBooking']['ship1'];
				$model->shipper2 = $_POST['MasterNewJobBooking']['ship2'];
				$model->shipper3 = $_POST['MasterNewJobBooking']['ship3'];
				$model->consignee1 = $_POST['MasterNewJobBooking']['consign1'];
				$model->consignee2 = $_POST['MasterNewJobBooking']['consign2'];
				$model->consignee3 = $_POST['MasterNewJobBooking']['consign3'];
				$model->notify1 = $_POST['MasterNewJobBooking']['notify_party1'];
				$model->notify2 = $_POST['MasterNewJobBooking']['notify_party2'];
				$model->notify3 = $_POST['MasterNewJobBooking']['notify_party3'];
				$model->contact1 = $_POST['MasterNewJobBooking']['cus1'];
				$model->contact2 = $_POST['MasterNewJobBooking']['cus2'];
				$model->contact3 = $_POST['MasterNewJobBooking']['cus3'];
				$model->detail_container = '-';
				$model->detail_info = '-';
				$model->detail_total = '-';
				$model->freight_term = $model->getOldAttribute('freight_term') ? $model->getOldAttribute('freight_term') : '-';
				$model->user = '-';
				$model->status = 1;
				
				if($model->save(false)){
					$model2->hblcusdata_job_id = $model->id_job;
					$model2->hblcusdata_hbl_id = 1;
					$model2->hblcusdata_shipper = $model->shipper1;
					$model2->hblcusdata_shipper2 = $model->shipper2;
					$model2->hblcusdata_shipper_info = $model->shipper3;
					$model2->hblcusdata_consignee= $model->consignee1;
					$model2->hblcusdata_consignee2 = $model->consignee2;
					$model2->hblcusdata_consignee_info = $model->consignee3;
					$model2->hblcusdata_notify = $model->notify1;
					$model2->hblcusdata_notify2 = $model->notify2;
					$model2->hblcusdata_notify_info = $model->notify3;
					
					if(isset($_POST['MasterNewJobBooking']['also_notify1'])){
						$model2->hblcusdata_alsonotify = $_POST['MasterNewJobBooking']['also_notify1'];
						$model2->hblcusdata_alsonotify2 = $_POST['MasterNewJobBooking']['also_notify2'];
						$model2->hblcusdata_alsonotify_info = $_POST['MasterNewJobBooking']['also_notify3'];
					}else{
						$model2->hblcusdata_alsonotify = 0;
						$model2->hblcusdata_alsonotify2 = 0;
						$model2->hblcusdata_alsonotify_info = '-';
					}
					$model2->hblcusdata_is_active = 1;
					
					if($model2->save(false)){
						$model3->jr_job_id = $model->id_job;
						$model3->jr_office = $model->getOldAttribute('jr_office') ? $model->getOldAttribute('jr_office') : '-';
						$model3->jr_account_repr = $model->getOldAttribute('jr_account_repr') ? $model->getOldAttribute('jr_account_repr') : 0;
						$model3->jr_type = $model->getOldAttribute('jr_type') ? $model->getOldAttribute('jr_type') : '-';
						$model3->jr_agent_list = $_POST['MasterNewJobBooking']['agent1'];
						$model3->jr_agentcity_list = $_POST['MasterNewJobBooking']['agent2'];
						$model3->jr_agentloc = $_POST['MasterNewJobBooking']['agent3'];
						$model3->jr_house_scac = $model->getOldAttribute('jr_house_scac') ? $model->getOldAttribute('jr_house_scac') : '-';
						$model3->jr_routing_no = $model->getOldAttribute('jr_routing_no') ? $model->getOldAttribute('jr_routing_no') : '-';
						$model3->jr_sc_no = $model->getOldAttribute('jr_sc_no') ? $model->getOldAttribute('jr_sc_no') : '-';
						$model3->jr_ref_number = $model->getOldAttribute('jr_ref_number') ? $model->getOldAttribute('jr_ref_number') : '-';
						$model3->jr_booking_number = $model->getOldAttribute('jr_booking_number') ? $model->getOldAttribute('jr_booking_number') : '-';
						$model3->jr_forwarding_agent = $model->getOldAttribute('jr_forwarding_agent') ? $model->getOldAttribute('jr_forwarding_agent') : '-';
						$model3->jr_country_origin = $model->getOldAttribute('jr_country_origin') ? $model->getOldAttribute('jr_country_origin') : 0;
						$model3->jr_crcode_list = $model->getOldAttribute('jr_crcode_list') ? $model->getOldAttribute('jr_crcode_list') : 0;
						$model3->jr_crname_list = $model->getOldAttribute('jr_crname_list') ? $model->getOldAttribute('jr_crname_list') : 0;
						$model3->jr_scac = $model->getOldAttribute('jr_scac') ? $model->getOldAttribute('jr_scac') : '-';
						$model3->jr_hbl = $model->getOldAttribute('jr_hbl') ? $model->getOldAttribute('jr_hbl') : 0;
						$model3->jr_hbl_update = $model->getOldAttribute('jr_hbl_update') ? $model->getOldAttribute('jr_hbl_update') : 0;
						$model3->jr_mbl = $model->getOldAttribute('jr_mbl') ? $model->getOldAttribute('jr_mbl') : '-';
						
						if($model3->save(false)){
							$cus = Customer::find()->where(['customer_id'=>$_POST['MasterNewJobBooking']['cus1']])->one();
							$model4->customer_name = $cus->customer_companyname;
							$model4->job_customer = $_POST['MasterNewJobBooking']['cus1'];
							
							if($model4->save(false)){
								$model5->id_job = $model->id_job;
								$model5->customer = $_POST['MasterNewJobBooking']['cus1'];
								$model5->customer_alias = $_POST['MasterNewJobBooking']['cus2'];
								$model5->customer_address = $_POST['MasterNewJobBooking']['cus3'];
								$model5->customer_count = $_POST['customer'];
								$model5->shipper = $_POST['MasterNewJobBooking']['ship1'];
								$model5->shipper_alias = $_POST['MasterNewJobBooking']['ship2'];
								$model5->shipper_address = $_POST['MasterNewJobBooking']['ship3'];
								$model5->shipper_count = $_POST['shipper'];
								$model5->consignee = $_POST['MasterNewJobBooking']['consign1'];
								$model5->consignee_alias = $_POST['MasterNewJobBooking']['consign2'];
								$model5->consignee_address = $_POST['MasterNewJobBooking']['consign3'];
								$model5->consignee_count = $_POST['consignee'];
								$model5->notify = $_POST['MasterNewJobBooking']['notify_party1'];
								$model5->notify_alias = $_POST['MasterNewJobBooking']['notify_party2'];
								$model5->notify_address = $_POST['MasterNewJobBooking']['notify_party3'];
								$model5->notify_count = $_POST['notify'];
								
								if(isset($_POST['MasterNewJobBooking']['also_notify1'])){
									$model5->alsonotify = $_POST['MasterNewJobBooking']['also_notify1'];
									$model5->alsonotify_alias = $_POST['MasterNewJobBooking']['also_notify2'];
									$model5->alsonotify_address = $_POST['MasterNewJobBooking']['also_notify3'];
									$model5->alsonotify_count = $_POST['also_notify'];
								}else{
									$model5->alsonotify = 0;
									$model5->alsonotify_alias = 0;
									$model5->alsonotify_address = '-';
									$model5->alsonotify_count = 0;
								}
								
								$model5->agent = $_POST['MasterNewJobBooking']['agent1'];
								$model5->agent_alias = $_POST['MasterNewJobBooking']['agent2'];
								$model5->agent_address = $_POST['MasterNewJobBooking']['agent3'];
								$model5->agent_count = $_POST['agent'];
								
								// Cek billing_party 1 kosong / tidak
								if(isset($_POST['MasterNewJobBooking']['billing_party_1'])){
									$model5->billingparty_1 = $_POST['MasterNewJobBooking']['billing_party_1'];
									$model5->billingparty_alias_1 = $_POST['MasterNewJobBooking']['billing_party_alias_1'];
									$model5->billingparty_address_1 = $_POST['MasterNewJobBooking']['billing_party_address_1'];
									$model5->billingparty_count_1 = $_POST['billing_party_1'];
								}else{
									$model5->billingparty_1 = 0;
									$model5->billingparty_alias_1 = 0;
									$model5->billingparty_address_1 = '-';
									$model5->billingparty_count_1 = 0;
								}
								
								// Cek billing_party 2 kosong / tidak
								if(isset($_POST['MasterNewJobBooking']['billing_party_2'])){
									$model5->billingparty_2 = $_POST['MasterNewJobBooking']['billing_party_2'];
									$model5->billingparty_alias_2 = $_POST['MasterNewJobBooking']['billing_party_alias_2'];
									$model5->billingparty_address_2 = $_POST['MasterNewJobBooking']['billing_party_address_2'];
									$model5->billingparty_count_2 = $_POST['billing_party_2'];
								}else{
									$model5->billingparty_2 = 0;
									$model5->billingparty_alias_2 = 0;
									$model5->billingparty_address_2 = '-';
									$model5->billingparty_count_2 = 0;
								}
								
								// Cek billing_party 3 kosong / tidak
								if(isset($_POST['MasterNewJobBooking']['billing_party_3'])){
									$model5->billingparty_3 = $_POST['MasterNewJobBooking']['billing_party_3'];
									$model5->billingparty_alias_3 = $_POST['MasterNewJobBooking']['billing_party_alias_3'];
									$model5->billingparty_address_3 = $_POST['MasterNewJobBooking']['billing_party_address_3'];
									$model5->billingparty_count_3 = $_POST['billing_party_3'];
								}else{
									$model5->billingparty_3 = 0;
									$model5->billingparty_alias_3 = 0;
									$model5->billingparty_address_3 = '-';
									$model5->billingparty_count_3 = 0;
								}
								
								// Cek billing_party 4 kosong / tidak
								if(isset($_POST['MasterNewJobBooking']['billing_party_erc'])){
									$model5->billingparty_erc = $_POST['MasterNewJobBooking']['billing_party_erc'];
									$model5->billingparty_alias_erc = $_POST['MasterNewJobBooking']['billing_party_alias_erc'];
									$model5->billingparty_address_erc = $_POST['MasterNewJobBooking']['billing_party_address_erc'];
									$model5->billingparty_count_erc = $_POST['erc'];
								}else{
									$model5->billingparty_erc = 0;
									$model5->billingparty_alias_erc = 0;
									$model5->billingparty_address_erc = '-';
									$model5->billingparty_count_erc = 0;
								}
								
								$model5->is_active = 1;
								
								if($model5->save(false)){
									return $this->redirect(['job/update', 'id' => $id_job]);
								}
							}
						}
					}
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveParties()
	{
		$db = MasterNewJobBooking::find()
			->where(['id_job' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobBooking;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->id_job;
				$model->to1 = 0;
				$model->to2 = '-';
				$model->to3 = '-';
				$model->scac_code = '-';
				$model->booking_no = '-';
				$model->service_contract = '-';
				$model->date_booking = date('Y-m-d');
				$model->carrier = '-';
				$model->ref_number = '-';
				$model->port_of_receipt = $model->getOldAttribute('port_of_receipt') ? $model->getOldAttribute('port_of_receipt') : '-';
				$model->port_of_loading = $model->getOldAttribute('port_of_loading') ? $model->getOldAttribute('port_of_loading') : '-';
				$model->port_of_discharge = $model->getOldAttribute('port_of_discharge') ? $model->getOldAttribute('port_of_discharge') : '-';
				$model->final_destination = $model->getOldAttribute('final_destination') ? $model->getOldAttribute('final_destination') : '-';
				$model->hblrouting_movement = $model->getOldAttribute('hblrouting_movement') ? $model->getOldAttribute('hblrouting_movement') : '-';
				$model->batch = $model->getOldAttribute('batch') ? $model->getOldAttribute('batch') : 0;
				$model->detail_container = '-';
				$model->detail_info = '-';
				$model->detail_total = '-';
				$model->freight_term = '-';
				$model->user = '-';
				$model->status = 1;
				
				if($model->save(false)){
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveVesselRouting()
	{
		$db = MasterNewJobBooking::find()
			->where(['id_job' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		$db2 = MasterG3eVesselbatch::find()
			->where(['vessel_job_id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
			
		$db3 = MasterG3eHblRouting::find()
			->where(['hblrouting_job_id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		$db4 = MasterNewJob::find()
			->where(['id' => $_POST['MasterNewJobBooking']['id_job']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobBooking;
		}
		
		if(isset($db2)){
			$model2 = $db2;
		}else{
			$model2 = new MasterG3eVesselbatch;
		}
		
		if(isset($db3)){
			$model3 = $db3;
		}else{
			$model3 = new MasterG3eHblRouting;
		}
		
		if(isset($db4)){
			$model4 = $db4;
		}else{
			$model4 = new MasterNewJob;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->id_job;
				$model->to1 = 0;
				$model->to2 = '-';
				$model->to3 = '-';
				$model->scac_code = '-';
				$model->booking_no = '-';
				$model->service_contract = '-';
				$model->date_booking = date('Y-m-d');
				$model->carrier = '-';
				$model->ref_number = '-';
				$model->shipper1 = $model->getOldAttribute('shipper1') ? $model->getOldAttribute('shipper1') : 0;
				$model->shipper2 = $model->getOldAttribute('shipper2') ? $model->getOldAttribute('shipper2') : '-';
				$model->shipper3 = $model->getOldAttribute('shipper3') ? $model->getOldAttribute('shipper3') : '-';
				$model->consignee1 = $model->getOldAttribute('consignee1') ? $model->getOldAttribute('consignee1') : 0;
				$model->consignee2 = $model->getOldAttribute('consignee2') ? $model->getOldAttribute('consignee2') : '-';
				$model->consignee3 = $model->getOldAttribute('consignee3') ? $model->getOldAttribute('consignee3') : '-';
				$model->notify1 = $model->getOldAttribute('notify1') ? $model->getOldAttribute('notify1') : 0;
				$model->notify2 = $model->getOldAttribute('notify2') ? $model->getOldAttribute('notify2') : '-';
				$model->notify3 = $model->getOldAttribute('notify3') ? $model->getOldAttribute('notify3') : '-';
				$model->contact1 = $model->getOldAttribute('contact1') ? $model->getOldAttribute('contact1') : 0;
				$model->contact2 = $model->getOldAttribute('contact2') ? $model->getOldAttribute('contact2') : '-';
				$model->contact3 = $model->getOldAttribute('contact3') ? $model->getOldAttribute('contact3') : '-';
				$model->detail_container = '-';
				$model->detail_info = '-';
				$model->detail_total = '-';
				$model->freight_term = $model->getOldAttribute('freight_term') ? $model->getOldAttribute('freight_term') : '-';
				$model->user = '-';
				$model->status = 1;
				
				if($model->save(false)){
					$model2->vessel_job_id = $model->id_job;
					$model2->vessel_batch_id = $model->batch;
					$model2->vessel_place_receipt = $model->port_of_receipt;
					$model2->vessel_place_delivery = $model->final_destination;
					$model2->vessel_day = '-';
					$model2->vessel_month = '-';
					$model2->vessel_year = '-';
					$model2->vessel_movement = $model->hblrouting_movement;
					$model2->vessel_freight_term = $model->hblrouting_movement;
					
					if($model2->save(false)){
						$model3->hblrouting_hbl_id = 1;
						$model3->hblrouting_job_id = $model->id_job;
						$model3->hblrouting_receipt = $model->port_of_receipt;
						$model3->hblrouting_cargo_day = '-';
						$model3->hblrouting_cargo_month = '-';
						$model3->hblrouting_cargo_year = '-';
						$model3->hblrouting_delivery =  $model->final_destination;
						$model3->hblrouting_arrival_day = '-';
						$model3->hblrouting_arrival_month = '-';
						$model3->hblrouting_arrival_year = '-';
						$model3->hblrouting_movement = $model->hblrouting_movement;
						$model3->place_of_receipt =  empty($_POST['MasterG3eHblRouting']['place_of_receipt']) ? $model->por->point_name : $_POST['MasterG3eHblRouting']['place_of_receipt'];
						$model3->port_of_loading = empty($_POST['MasterG3eHblRouting']['port_of_loading']) ? $model->pol->point_name : $_POST['MasterG3eHblRouting']['port_of_loading'];
						$model3->port_of_discharge =  empty($_POST['MasterG3eHblRouting']['port_of_discharge']) ? $model->pod->point_name : $_POST['MasterG3eHblRouting']['port_of_discharge'];
						$model3->port_of_delivery =  empty($_POST['MasterG3eHblRouting']['port_of_delivery']) ? $model->fod->point_name : $_POST['MasterG3eHblRouting']['port_of_delivery'];
						$model3->hblrouting_is_active = 1;
						
						if($model3->save(false)){
							$vesselrouting = MasterVesselRouting::find()->where(['id'=>$model->batch])->one();
							
							$model4->job_from = $model->port_of_receipt;
							$model4->job_to = $model->final_destination;
							$model4->job_ship = $vesselrouting->laden_on_board;
							
							if($model4->save(false)){
								return $this->redirect(['job/update', 'id' => $id_job]);
							}
						}
					}
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveCargo()
	{
		$db = MasterG3eHblCargodetail::find()
			->where(['hblcrg_job_id' => $_POST['MasterG3eHblCargodetail']['hblcrg_job_id']])
			->andWhere(['hblcrg_is_active' => 1])
			->one();
		
		$db2 = MasterG3eContainer::find()
			->where(['con_job_id' => $_POST['MasterG3eHblCargodetail']['hblcrg_job_id']])
			->one();
			
		$db3 = MasterNewJob::find()
			->where(['id' => $_POST['MasterG3eHblCargodetail']['hblcrg_job_id']])
			->one();
		
		$db4 = MasterG3eHblDescription::find()
			->where(['hbldes_job_id' => $_POST['MasterG3eHblCargodetail']['hblcrg_job_id']])
			->andWhere(['hbldes_is_active' => 1])
			->one();
		
		if(isset($db)){
			$detail = MasterG3eHblCargodetail::deleteall(['hblcrg_job_id'=>$_POST['MasterG3eHblCargodetail']['hblcrg_job_id']]);
			$model = new MasterG3eHblCargodetail;
		}else{
			$model = new MasterG3eHblCargodetail;
		}
		
		if(isset($db2)){
			$detail2 = MasterG3eContainer::deleteall(['con_job_id'=>$_POST['MasterG3eHblCargodetail']['hblcrg_job_id']]);
			$model2 = new MasterG3eContainer;
		}else{
			$model2 = new MasterG3eContainer;
		}
		
		if(isset($db3)){
			$model3 = $db3;
		}else{
			$model3 = new MasterNewJob;
		}
		
		if(isset($db4)){
			$model4 = $db4;
		}else{
			$model4 = new MasterG3eHblDescription;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->hblcrg_job_id;
				
				$i = 1;
				$fcl_pack = '';
				// FCL
				if($_POST['container_type'] == 'FCL'){
					foreach($_POST['MasterG3eHblCargodetail']['detail'] as $row){
						$cargo = new MasterG3eHblCargodetail;
						$cargo->hblcrg_hbl_id = 1;
						$cargo->hblcrg_job_id = $model->hblcrg_job_id;
						$cargo->hblcrg_name = $row['hblcrg_name'];
						$cargo->hblcrg_container_count = $i;
						$cargo->hblcrg_seal = $row['hblcrg_seal'];
						$cargo->hblcrg_pack_value = $row['hblcrg_pack_value'];
						$cargo->hblcrg_pack_type = $row['hblcrg_pack_type'];
						$cargo->hblcrg_gross_value = number_format((float)$row['hblcrg_gross_value'], 3, '.', '');
						$cargo->hblcrg_gross_type = $model->hblcrg_gross_type;
						$cargo->hblcrg_nett_value = number_format((float)$row['hblcrg_nett_value'], 3, '.', '');
						$cargo->hblcrg_nett_type = $model->hblcrg_nett_type;
						$cargo->hblcrg_msr_value = number_format((float)$row['hblcrg_msr_value'], 4, '.', '');
						$cargo->hblcrg_msr_type = $model->hblcrg_msr_type;
						$cargo->hblcrg_combined = 0;
						$cargo->hblcrg_description = $row['hblcrg_description'];
						$cargo->hblcrg_is_active = 1;
						$fcl_pack .= '#'.$row['hblcrg_pack_type'];
						$cargo->save(false);
						// if($cargo->save(false)){
							// $container = new MasterG3eContainer;
							// $nama = explode(' ', $row['hblcrg_name']);
							// $container->con_job_id = $model->hblcrg_job_id;
							// $container->con_bl = 1;
							// $container->con_count = $i;
							// $container->con_code = $nama[0];
							// $container->con_text = $nama[1];
							// $container->con_name = $nama[2];
							// $container->save(false);
						// }
						$i++;
					}
					
					$model3->g3_type = $_POST['container_type'];
					$model3->g3_total = $_POST['pack_fcl_total'];
					$model3->g3_packages = $fcl_pack;
					$model3->save(false);
				}else{
					// LCL
					$model3->g3_type = $_POST['container_type'];
					$model3->g3_total = $_POST['pack_lcl_total'];
					$model3->g3_packages = '#'.$_POST['pack_lcl_type'];
					$model3->save(false);
				}
				
				$model4->hbldes_job_id = $model->hblcrg_job_id;
				$model4->hbldes_hbl_id = 1;
				$model4->hbldes_mark = $model4->getOldAttribute('hbldes_mark') ? $model4->getOldAttribute('hbldes_mark') : '-';
				$model4->hbldes_desofgood = $model4->getOldAttribute('hbldes_desofgood') ? $model4->getOldAttribute('hbldes_desofgood') : '-';
				
				if($_POST['Desc']['hbldes_desofgood_text']){
					$model4->hbldes_desofgood_text = $_POST['Desc']['hbldes_desofgood_text'];
				}else{
					$model4->hbldes_desofgood_text = empty($_POST['Desc']['hbldes_desofgood_text']) ? '-' : $model4->getOldAttribute('hbldes_desofgood_text');
				}
				
				if($_POST['Desc']['hbldes_weight']){
					$model4->hbldes_weight = $_POST['Desc']['hbldes_weight'];
				}else{
					$model4->hbldes_weight = empty($_POST['Desc']['hbldes_weight']) ? '-' : $model4->getOldAttribute('hbldes_weight');
				}
				
				$model4->hbldes_freight = $model4->getOldAttribute('hbldes_freight') ? $model4->getOldAttribute('hbldes_freight') : '-';
				$model4->hbldes_payable = $model4->getOldAttribute('hbldes_payable') ? $model4->getOldAttribute('hbldes_payable') : '-';
				$model4->hbldes_payable_details = $model4->getOldAttribute('hbldes_payable_details') ? $model4->getOldAttribute('hbldes_payable_details') : '-';
				
				$model4->hbldes_declared_list = $model4->getOldAttribute('hbldes_declared_list') ? $model4->getOldAttribute('hbldes_declared_list') : '-';
				$model4->hbldes_declared_text1 = $model4->getOldAttribute('hbldes_declared_text1') ? $model4->getOldAttribute('hbldes_declared_text1') : 0;
				$model4->hbldes_declared_text2 = $model4->getOldAttribute('hbldes_declared_text2') ? $model4->getOldAttribute('hbldes_declared_text2') : 0;
				$model4->hbldes_original = $model4->getOldAttribute('hbldes_original') ? $model4->getOldAttribute('hbldes_original') : 0;
				$model4->hbldes_poi = $model4->getOldAttribute('hbldes_poi') ? $model4->getOldAttribute('hbldes_poi') : '-';
				$model4->hbldes_doi_day = $model4->getOldAttribute('hbldes_doi_day') ? $model4->getOldAttribute('hbldes_doi_day') : '-';
				$model4->hbldes_doi_month = $model4->getOldAttribute('hbldes_doi_month') ? $model4->getOldAttribute('hbldes_doi_month') : '-';
				$model4->hbldes_doi_year = $model4->getOldAttribute('hbldes_doi_year') ? $model4->getOldAttribute('hbldes_doi_year') : '-';
				$model4->hbldes_signature = $model4->getOldAttribute('hbldes_signature') ? $model4->getOldAttribute('hbldes_signature') : '-';
				$model4->hbldes_signature_text = $model4->getOldAttribute('hbldes_signature_text') ? $model4->getOldAttribute('hbldes_signature_text') : '-';
				$model4->hbldes_is_active = 1;
				
				$model4->save(false);
				
				return $this->redirect(['job/update', 'id' => $id_job]);
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveDescription()
	{
		$db = MasterG3eHblDescription::find()
			->where(['hbldes_job_id' => $_POST['MasterG3eHblDescription']['hbldes_job_id']])
			->andWhere(['hbldes_is_active' => 1])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterG3eHblDescription;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->hbldes_job_id;
				$model->hbldes_job_id = $id_job;
				$model->hbldes_hbl_id = 1;
				$model->hbldes_declared_list = $model->getOldAttribute('hbldes_declared_list') ? $model->getOldAttribute('hbldes_declared_list') : '-';
				$model->hbldes_declared_text1 = $model->getOldAttribute('hbldes_declared_text1') ? $model->getOldAttribute('hbldes_declared_text1') : '0';
				$model->hbldes_declared_text2 = $model->getOldAttribute('hbldes_declared_text2') ? $model->getOldAttribute('hbldes_declared_text2') : '0';
				$model->hbldes_freight = $model->getOldAttribute('hbldes_freight') ? $model->getOldAttribute('hbldes_freight') : '-';
				$model->hbldes_payable = $model->getOldAttribute('hbldes_payable') ? $model->getOldAttribute('hbldes_payable') : '-';
				$model->hbldes_payable_details = $model->getOldAttribute('hbldes_payable_details') ? $model->getOldAttribute('hbldes_payable_details') : '-';
				$model->hbldes_original = $model->getOldAttribute('hbldes_original') ? $model->getOldAttribute('hbldes_original') : '0';
				$model->hbldes_poi = $model->getOldAttribute('hbldes_poi') ? $model->getOldAttribute('hbldes_poi') : '-';
				$model->hbldes_doi_day = $model->getOldAttribute('hbldes_doi_day') ? $model->getOldAttribute('hbldes_doi_day') : '-';
				$model->hbldes_doi_month = $model->getOldAttribute('hbldes_doi_month') ? $model->getOldAttribute('hbldes_doi_month') : '-';
				$model->hbldes_doi_year = $model->getOldAttribute('hbldes_doi_year') ? $model->getOldAttribute('hbldes_doi_year') : '-';
				$model->hbldes_signature = $model->getOldAttribute('hbldes_signature') ? $model->getOldAttribute('hbldes_signature') : '-';
				$model->hbldes_signature_text = $model->getOldAttribute('hbldes_signature_text') ? $model->getOldAttribute('hbldes_signature_text') : '-';
				$model->hbldes_is_active = 1;
				
				if($model->save(false)){
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveFreight()
	{
		$db = MasterG3eHblDescription::find()
			->where(['hbldes_job_id' => $_POST['MasterG3eHblDescription']['hbldes_job_id']])
			->andWhere(['hbldes_is_active' => 1])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterG3eHblDescription;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->hbldes_job_id;
				$model->hbldes_hbl_id = $model->getOldAttribute('hbldes_hbl_id') ? $model->getOldAttribute('hbldes_hbl_id') : '-';
				$model->hbldes_mark = $model->getOldAttribute('hbldes_mark') ? $model->getOldAttribute('hbldes_mark') : '-';
				$model->hbldes_payable_status = isset($_POST['MasterG3eHblDescription']['hbldes_payable_status']) ? $_POST['MasterG3eHblDescription']['hbldes_payable_status'] : 0;
				$model->hbldes_desofgood = $model->getOldAttribute('hbldes_desofgood') ? $model->getOldAttribute('hbldes_desofgood') : '-';
				$model->hbldes_desofgood_text = $model->getOldAttribute('hbldes_desofgood_text') ? $model->getOldAttribute('hbldes_desofgood_text') : '-';
				$model->hbldes_weight = $model->getOldAttribute('hbldes_weight') ? $model->getOldAttribute('hbldes_weight') : '-';
				$model->hbldes_declared_list = $model->getOldAttribute('hbldes_declared_list') ? $model->getOldAttribute('hbldes_declared_list') : '-';
				$model->hbldes_declared_text1 = $model->getOldAttribute('hbldes_declared_text1') ? $model->getOldAttribute('hbldes_declared_text1') : 0;
				$model->hbldes_declared_text2 = $model->getOldAttribute('hbldes_declared_text2') ? $model->getOldAttribute('hbldes_declared_text2') : 0;
				$model->hbldes_original = $model->getOldAttribute('hbldes_original') ? $model->getOldAttribute('hbldes_original') : 0;
				$model->hbldes_poi = $model->getOldAttribute('hbldes_poi') ? $model->getOldAttribute('hbldes_poi') : '-';
				$model->hbldes_doi_day = $model->getOldAttribute('hbldes_doi_day') ? $model->getOldAttribute('hbldes_doi_day') : '-';
				$model->hbldes_doi_month = $model->getOldAttribute('hbldes_doi_month') ? $model->getOldAttribute('hbldes_doi_month') : '-';
				$model->hbldes_doi_year = $model->getOldAttribute('hbldes_doi_year') ? $model->getOldAttribute('hbldes_doi_year') : '-';
				$model->hbldes_signature = $model->getOldAttribute('hbldes_signature') ? $model->getOldAttribute('hbldes_signature') : '-';
				$model->hbldes_signature_text = $model->getOldAttribute('hbldes_signature_text') ? $model->getOldAttribute('hbldes_signature_text') : '-';
				$model->hbldes_is_active = 1;
				
				if($model->save(false)){
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveReference()
	{
		$db = MasterG3eJobrouting::find()
			->where(['jr_job_id' => $_POST['MasterG3eJobrouting']['jr_job_id']])
			->one();
			
		$batch_oribl = MasterG3eBatch::find()
				->where(['batchform_job' => $_POST['MasterG3eJobrouting']['jr_job_id']])
				->one();
		
		$job = MasterNewJob::find()->where(['id' => $_POST['MasterG3eJobrouting']['jr_job_id']])->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterG3eJobrouting;
		}
		
		if(isset($batch_oribl)){
			$model2 = $batch_oribl;
		}else{
			$model2 = new MasterG3eBatch;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$job->job_hb = $_POST['MasterG3eJobrouting']['jr_hbl'] ? $_POST['MasterG3eJobrouting']['jr_hbl'] : '-';
				$job->job_mb = $_POST['MasterG3eJobrouting']['jr_mbl'] ? $_POST['MasterG3eJobrouting']['jr_mbl'] : '-';
				$job->save();
				
				//Export Reference 3 baris
				$reff1 = $_POST['MasterG3eJobrouting']['jr_ref_number1'];
				$reff2 = $_POST['MasterG3eJobrouting']['jr_ref_number2'];
				$reff3 = $_POST['MasterG3eJobrouting']['jr_ref_number3'];
				$reff4 = $_POST['MasterG3eJobrouting']['jr_ref_number4'];
				
				if(empty($reff1) && empty($reff2) && empty($reff3) && empty($reff4)){
					$export_reference = '-';
				}else{
					// $textArray = [$reff1, $reff2, $reff3, $reff4];
					// $export_reference = implode('\n', $textArray); 
					$export_reference = $reff1."\r\n".$reff2."\r\n".$reff3."\r\n".$reff4;
				}
				
				$id_job = $model->jr_job_id;
				$model->jr_hbl = $_POST['MasterG3eJobrouting']['jr_hbl'] ? $_POST['MasterG3eJobrouting']['jr_hbl'] : 0; 
				
				$model->jr_ref_number = $export_reference;
				
				$model->jr_account_repr = $model->getOldAttribute('jr_account_repr') ? $model->getOldAttribute('jr_account_repr') : 0;
				$model->jr_agent_list = $model->getOldAttribute('jr_agent_list') ? $model->getOldAttribute('jr_agent_list') : '-';
				$model->jr_agentcity_list = $model->getOldAttribute('jr_agentcity_list') ? $model->getOldAttribute('jr_agentcity_list') : '-';
				$model->jr_agentloc = $model->getOldAttribute('jr_agentloc') ? $model->getOldAttribute('jr_agentloc') : '-';
				$model->jr_routing_no = $model->getOldAttribute('jr_routing_no') ? $model->getOldAttribute('jr_routing_no') : '-';
				$model->jr_sc_no = $model->getOldAttribute('jr_sc_no') ? $model->getOldAttribute('jr_sc_no') : '-';
				$model->jr_booking_number = $model->getOldAttribute('jr_booking_number') ? $model->getOldAttribute('jr_booking_number') : '-';
				$model->jr_forwarding_agent = $model->getOldAttribute('jr_forwarding_agent') ? $model->getOldAttribute('jr_forwarding_agent') : '-';
				$model->jr_crname_list = $model->getOldAttribute('jr_crname_list') ? $model->getOldAttribute('jr_crname_list') : 0;
				$model->jr_hbl_update = $model->getOldAttribute('jr_hbl_update') ? $model->getOldAttribute('jr_hbl_update') : 0;
				
				if($model->save(false)){
					/*$model2->batchform_job = $id_job;
					$model2->batchform_hbl = 1;
					$model2->batchform_1 = empty($_POST['MasterG3eBatch']['batchform_1']) ? 0 : $_POST['MasterG3eBatch']['batchform_1'];
					$model2->batchform_2 = empty($_POST['MasterG3eBatch']['batchform_2']) ? 0 : $_POST['MasterG3eBatch']['batchform_2'];
					$model2->batchform_3 = empty($_POST['MasterG3eBatch']['batchform_3']) ? 0 : $_POST['MasterG3eBatch']['batchform_3'];
					$model2->batchform_is_active = 1;
					
					if($model2->save()){
						return $this->redirect(['job/update', 'id' => $id_job]);
					}*/
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveFooter()
	{
		$db = MasterG3eHblDescription::find()
			->where(['hbldes_job_id' => $_POST['MasterG3eHblDescription']['hbldes_job_id']])
			->andWhere(['hbldes_is_active' => 1])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterG3eHblDescription;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->hbldes_job_id;
				$date_of_issue = date_create_from_format('Y-m-d', $_POST['MasterG3eHblDescription']['date_of_issue']);
				$model->hbldes_doi_day = date_format($date_of_issue, 'd');
				$model->hbldes_doi_month = date_format($date_of_issue, 'm');
				$model->hbldes_doi_year = date_format($date_of_issue, 'Y');
				$model->hbldes_hbl_id = 1;
				$model->hbldes_mark = $model->getOldAttribute('hbldes_mark') ? $model->getOldAttribute('hbldes_mark') : '-';
				$model->hbldes_desofgood = $model->getOldAttribute('hbldes_desofgood') ? $model->getOldAttribute('hbldes_desofgood') : '-';
				$model->hbldes_desofgood_text = $model->getOldAttribute('hbldes_desofgood_text') ? $model->getOldAttribute('hbldes_desofgood_text') : '-';
				$model->hbldes_weight = $model->getOldAttribute('hbldes_weight') ? $model->getOldAttribute('hbldes_weight') : '-';
				$model->hbldes_freight = $model->getOldAttribute('hbldes_freight') ? $model->getOldAttribute('hbldes_freight') : '-';
				$model->hbldes_payable = $model->getOldAttribute('hbldes_payable') ? $model->getOldAttribute('hbldes_payable') : '-';
				$model->hbldes_payable_details = $model->getOldAttribute('hbldes_payable_details') ? $model->getOldAttribute('hbldes_payable_details') : '-';
				$model->hbldes_is_active = 1;
				
				if($model->save(false)){
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
        }else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveInvoiceIdt()
	{
		$db = MasterNewJobinvoice::find()
			->where(['inv_id' => $_POST['MasterNewJobinvoice']['inv_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobinvoice;
		}
		
		$last_count = MasterNewJobinvoice::find()->where(['inv_currency'=>'IDR'])->orderBy(['inv_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->inv_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->inv_job_id;
				$model->inv_job_id = $_POST['MasterNewJobinvoice']['inv_job_id'];
				$model->inv_job_group = 0;
				$model->inv_type = 1;
				$model->inv_group = 0;
				$model->inv_count = $model->getOldAttribute('inv_count') ? $model->getOldAttribute('inv_count') : $count;
				$model->inv_date = $_POST['MasterNewJobinvoice']['inv_date'];
				$model->inv_due_date = $_POST['MasterNewJobinvoice']['inv_due_date'];
				$model->inv_code = '-';
				$model->inv_currency = 'IDR';
				$model->inv_customer = $_POST['MasterNewJobinvoice']['inv_customer'];
				$model->inv_customer2 = $_POST['MasterNewJobinvoice']['inv_customer2'];
				$model->inv_customer3 = $_POST['MasterNewJobinvoice']['inv_customer3'];
				$model->inv_to = $_POST['MasterNewJobinvoice']['inv_to'];
				$model->inv_to2 = $_POST['MasterNewJobinvoice']['inv_to2'];
				$model->inv_to3 = $_POST['MasterNewJobinvoice']['inv_to3'];
				$model->inv_total = $_POST['MasterNewJobinvoice']['inv_total'];
				$model->inv_total_ppn = $_POST['MasterNewJobinvoice']['inv_total_ppn'];
				$model->inv_grandtotal = $_POST['MasterNewJobinvoice']['inv_grandtotal'];
				$model->additional_notes = $_POST['MasterNewJobinvoice']['additional_notes'];
				$model->inv_is_active = 1;
				
				if($model->save(false)){
					$invoice_detail = MasterNewJobinvoiceDetail::deleteall(['invd_inv_id'=>$model->inv_id]);
					$i = 1;
					foreach($_POST['MasterNewJobinvoiceDetail']['detail'] as $row)
					{
						$detail = new MasterNewJobinvoiceDetail();
						$detail->invd_inv_id = $model->inv_id;
						$detail->invd_job_id = $id_job;
						$detail->invd_job_group = 0;
						$detail->invd_type = 0;
						$detail->invd_count = $i;
						$detail->invd_pos = $row['invd_pos'];
						$detail->invd_detail = $row['invd_detail'] ? $row['invd_detail'] : '-';
						$detail->invd_basis1_total = $row['invd_basis1_total'];
						$detail->invd_basis1_type = $row['invd_basis1_type'];
						$detail->invd_basis2_total = $row['invd_basis2_total'];
						$detail->invd_basis2_type = $row['invd_basis2_type'];
						$detail->invd_rate = $row['invd_rate'];
						$detail->invd_rate_type = '-';
						$detail->invd_amount = $row['invd_amount'];
						$detail->invd_sector = '-';
						$detail->invd_exch = '-';
						$detail->invd_id_ppn = $row['invd_id_ppn'];
						$detail->invd_ppn = $row['invd_ppn'];
						$detail->invd_id_pph = $row['invd_id_pph'];
						$detail->invd_pph = $row['invd_pph'];
						$detail->invd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}

	public function actionDeleteInvoiceIdt()
	{
		$model = MasterNewJobinvoice::find()
			->where(['inv_id' => $_POST['id']])
			->one();
		
		$model->inv_is_active = 0;
		$model->save();
		
		return json_encode(['message' => 'success']);
	}

	public function actionSaveInvoiceHmc()
	{
		$db = MasterNewJobinvoice::find()
			->where(['inv_id' => $_POST['MasterNewJobinvoice']['inv_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobinvoice;
		}
		
		// $last_count = MasterNewJobinvoice::find()->andWhere(['inv_currency' => 'USD'])->orderBy(['inv_count'=>SORT_DESC])->one();
		$last_count = MasterNewJobinvoice::find()->where(['in', 'inv_type' => [3,4]])->orderBy(['inv_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->inv_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->inv_job_id;
				$model->inv_job_id = $_POST['MasterNewJobinvoice']['inv_job_id'];
				$model->inv_job_group = 0;
				$model->inv_type = $_POST['MasterNewJobinvoice']['inv_type'];
				$model->inv_group = 0;
				$model->inv_count = $model->getOldAttribute('inv_count') ? $model->getOldAttribute('inv_count') : $count;
				$model->inv_date = $_POST['MasterNewJobinvoice']['inv_date'];
				$model->inv_due_date = $_POST['MasterNewJobinvoice']['inv_due_date'];
				$model->inv_code = '-';
				$model->inv_currency = $_POST['MasterNewJobinvoice']['inv_currency'];
				$model->inv_customer = $_POST['MasterNewJobinvoice']['inv_customer'];
				$model->inv_customer2 = $_POST['MasterNewJobinvoice']['inv_customer2'];
				$model->inv_customer3 = $_POST['MasterNewJobinvoice']['inv_customer3'];
				$model->inv_to = $_POST['MasterNewJobinvoice']['inv_to'];
				$model->inv_to2 = $_POST['MasterNewJobinvoice']['inv_to2'];
				$model->inv_to3 = $_POST['MasterNewJobinvoice']['inv_to3'];
				$model->inv_total = $_POST['MasterNewJobinvoice']['inv_grandtotal'];
				$model->inv_total_ppn = 0;
				$model->inv_grandtotal = $_POST['MasterNewJobinvoice']['inv_grandtotal'];
				$model->additional_notes = $_POST['MasterNewJobinvoice']['additional_notes'];
				$model->inv_is_active = 1;
				
				if($model->save(false)){
					$invoice_detail = MasterNewJobinvoiceDetail::deleteall(['invd_inv_id'=>$model->inv_id]);
					$i = 1;
					foreach($_POST['MasterNewJobinvoiceDetail']['detail'] as $row)
					{
						$detail = new MasterNewJobinvoiceDetail();
						$detail->invd_inv_id = $model->inv_id;
						$detail->invd_job_id = $id_job;
						$detail->invd_job_group = 0;
						$detail->invd_type = 0;
						$detail->invd_count = $i;
						$detail->invd_pos = $row['invd_pos'];
						$detail->invd_detail = $row['invd_detail'] ? $row['invd_detail'] : '-';
						$detail->invd_basis1_total = $row['invd_basis1_total'];
						$detail->invd_basis1_type = $row['invd_basis1_type'];
						$detail->invd_basis2_total = $row['invd_basis2_total'];
						$detail->invd_basis2_type = $row['invd_basis2_type'];
						$detail->invd_rate = $row['invd_rate'];
						$detail->invd_rate_type = '-';
						$detail->invd_amount = $row['invd_amount'];
						$detail->invd_sector = '-';
						$detail->invd_exch = '-';
						$detail->invd_id_ppn = 0;
						$detail->invd_ppn = 0;
						$detail->invd_pph = 0;
						$detail->invd_id_pph = 0;
						$detail->invd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionSaveInvoiceHmcBk()
	{
		$db = MasterNewJobinvoice::find()
			->where(['inv_id' => $_POST['MasterNewJobinvoice']['inv_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobinvoice;
		}
		
		// $last_count = MasterNewJobinvoice::find()->andWhere(['inv_currency' => 'USD'])->orderBy(['inv_count'=>SORT_DESC])->one();
		$last_count = MasterNewJobinvoice::find()->where(['in', 'inv_type' => [3,4]])->orderBy(['inv_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->inv_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->inv_job_id;
				$model->inv_job_id = $_POST['MasterNewJobinvoice']['inv_job_id'];
				$model->inv_job_group = 0;
				$model->inv_type = $_POST['MasterNewJobinvoice']['inv_type'];
				$model->inv_group = 0;
				$model->inv_count = $model->getOldAttribute('inv_count') ? $model->getOldAttribute('inv_count') : $count;
				$model->inv_date = $_POST['MasterNewJobinvoice']['inv_date'];
				$model->inv_due_date = $_POST['MasterNewJobinvoice']['inv_due_date'];
				$model->inv_code = '-';
				$model->inv_currency = $_POST['MasterNewJobinvoice']['inv_currency'];
				$model->inv_customer = $_POST['MasterNewJobinvoice']['inv_customer'];
				$model->inv_customer2 = $_POST['MasterNewJobinvoice']['inv_customer2'];
				$model->inv_customer3 = $_POST['MasterNewJobinvoice']['inv_customer3'];
				$model->inv_to = $_POST['MasterNewJobinvoice']['inv_to'];
				$model->inv_to2 = $_POST['MasterNewJobinvoice']['inv_to2'];
				$model->inv_to3 = $_POST['MasterNewJobinvoice']['inv_to3'];
				$model->inv_total = $_POST['MasterNewJobinvoice']['inv_grandtotal'];
				$model->inv_total_ppn = 0;
				$model->inv_grandtotal = $_POST['MasterNewJobinvoice']['inv_grandtotal'];
				$model->additional_notes = $_POST['MasterNewJobinvoice']['additional_notes'];
				$model->inv_is_active = 1;
				
				if($model->save(false)){
					// sell
					$invoice_detail_sell = MasterNewJobinvoiceDetailSell::deleteall(['invd_inv_id'=>$model->inv_id]);
					$i = 1;
					foreach($_POST['MasterNewJobinvoiceDetail']['detail']['sell'] as $row)
					{
						$detail = new MasterNewJobinvoiceDetailSell();
						$detail->invd_inv_id = $model->inv_id;
						$detail->invd_job_id = $id_job;
						$detail->invd_job_group = 0;
						$detail->invd_type = 0;
						$detail->invd_count = $i;
						$detail->invd_pos = $row['invd_pos'];
						$detail->invd_detail = $row['invd_detail'] ? $row['invd_detail'] : '-';
						$detail->invd_basis1_total = $row['invd_basis1_total'];
						$detail->invd_basis1_type = $row['invd_basis1_type'];
						$detail->invd_basis2_total = $row['invd_basis2_total'];
						$detail->invd_basis2_type = $row['invd_basis2_type'];
						$detail->invd_rate = $row['invd_rate'];
						$detail->invd_rate_type = '-';
						$detail->invd_amount = $row['invd_amount'];
						$detail->invd_ccpp = $row['invd_ccpp'];
						$detail->invd_sector = '-';
						$detail->invd_exch = '-';
						$detail->invd_ppn = 0;
						$detail->invd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					// cost
					$invoice_detail = MasterNewJobinvoiceDetailCost::deleteall(['invd_inv_id'=>$model->inv_id]);
					$i = 1;
					foreach($_POST['MasterNewJobinvoiceDetail']['detail']['cost'] as $row)
					{
						$detail = new MasterNewJobinvoiceDetailCost();
						$detail->invd_inv_id = $model->inv_id;
						$detail->invd_job_id = $id_job;
						$detail->invd_job_group = 0;
						$detail->invd_type = 0;
						$detail->invd_count = $i;
						$detail->invd_pos = $row['invd_pos'];
						$detail->invd_detail = $row['invd_detail'] ? $row['invd_detail'] : '-';
						$detail->invd_basis1_total = $row['invd_basis1_total'];
						$detail->invd_basis1_type = $row['invd_basis1_type'];
						$detail->invd_basis2_total = $row['invd_basis2_total'];
						$detail->invd_basis2_type = $row['invd_basis2_type'];
						$detail->invd_rate = $row['invd_rate'];
						$detail->invd_rate_type = '-';
						$detail->invd_amount = $row['invd_amount'];
						$detail->invd_ccpp = $row['invd_ccpp'];
						$detail->invd_sector = '-';
						$detail->invd_exch = '-';
						$detail->invd_ppn = 0;
						$detail->invd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}

	public function actionDeleteInvoiceHmc()
	{
		$model = MasterNewJobinvoice::find()
			->where(['inv_id' => $_POST['id']])
			->one();
		
		$model->inv_is_active = 0;
		$model->save();
		
		return json_encode(['message' => 'success']);
	}

	public function actionSaveCostIdt()
	{
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
				$id_job = $model->vch_job_id;
				$model->vch_job_id = $_POST['MasterNewJobcost']['vch_job_id'];
				$model->vch_job_group = 0;
				$model->vch_type = 1;
				$model->vch_group = 0;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_date = $_POST['MasterNewJobcost']['vch_date'];
				$model->vch_due_date = $_POST['MasterNewJobcost']['vch_due_date'];
				$model->vch_code = '-';
				$model->vch_currency = 'IDR';
				$model->vch_pay_for = $_POST['MasterNewJobcost']['vch_pay_for'];
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
						$detail->vchd_basis1_total = $row['vchd_basis1_total'];
						$detail->vchd_basis1_type = $row['vchd_basis1_type'];
						$detail->vchd_basis2_total = $row['vchd_basis2_total'];
						$detail->vchd_basis2_type = $row['vchd_basis2_type'];
						$detail->vchd_rate = $row['vchd_rate'];
						$detail->vchd_rate_type = '-';
						$detail->vchd_amount = $row['vchd_amount'];
						$detail->vchd_sector = '-';
						$detail->vchd_exch = '-';
						$detail->vchd_id_ppn = $row['vchd_id_ppn'];
						$detail->vchd_ppn = $row['vchd_ppn'];
						$detail->vchd_pph = $row['vchd_pph'];
						$detail->vchd_id_pph = $row['vchd_id_pph'];
						$detail->vchd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}

	public function actionDeleteCostIdt()
	{
		$model = MasterNewJobcost::find()
			->where(['vch_id' => $_POST['id']])
			->one();
		
		$model->vch_is_active = 0;
		$model->save();
		
		return json_encode(['message' => 'success']);
	}

	public function actionSaveCostHmc()
	{
		$db = MasterNewJobcost::find()
			->where(['vch_id' => $_POST['MasterNewJobcost']['vch_id']])
			->one();
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterNewJobcost;
		}
		
		$last_count = MasterNewJobcost::find()->andWhere(['vch_currency' => 'USD'])->orderBy(['vch_count'=>SORT_DESC])->one();
		if(isset($last_count)){
			$count = $last_count->vch_count + 1;
		}else{
			$count = 1;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->vch_job_id;
				$model->vch_job_id = $_POST['MasterNewJobcost']['vch_job_id'];
				$model->vch_job_group = 0;
				$model->vch_type = 2;
				$model->vch_group = 0;
				$model->vch_count = $model->getOldAttribute('vch_count') ? $model->getOldAttribute('vch_count') : $count;
				$model->vch_date = $_POST['MasterNewJobcost']['vch_date'];
				$model->vch_due_date = $_POST['MasterNewJobcost']['vch_due_date'];
				$model->vch_code = '-';
				$model->vch_currency = 'USD';
				$model->vch_pay_for = $_POST['MasterNewJobcost']['vch_pay_for'];
				$model->vch_pay_to = $_POST['MasterNewJobcost']['vch_pay_to'];
				$model->vch_total = $_POST['MasterNewJobcost']['vch_grandtotal'];
				$model->vch_total_ppn = 0;
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
						$detail->vchd_basis1_total = $row['vchd_basis1_total'];
						$detail->vchd_basis1_type = $row['vchd_basis1_type'];
						$detail->vchd_basis2_total = $row['vchd_basis2_total'];
						$detail->vchd_basis2_type = $row['vchd_basis2_type'];
						$detail->vchd_rate = $row['vchd_rate'];
						$detail->vchd_rate_type = '-';
						$detail->vchd_amount = $row['vchd_amount'];
						$detail->vchd_sector = '-';
						$detail->vchd_exch = '-';
						$detail->vchd_id_ppn = 0;
						$detail->vchd_ppn = 0;
						$detail->vchd_is_active = 1;
						$detail->save();
						
						$i++;
					}
					
					return $this->redirect(['job/update', 'id' => $id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}

	public function actionDeleteCostHmc()
	{
		$model = MasterNewJobcost::find()
			->where(['vch_id' => $_POST['id']])
			->one();
		
		$model->vch_is_active = 0;
		$model->save();
		
		return json_encode(['message' => 'success']);
	}

	
	public function actionGetInvoiceIdt()
	{
		$id = Yii::$app->request->post('id');
        $invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id])->asArray()->one();
		$invoice_detail = MasterNewJobinvoiceDetail::find()->where(['invd_inv_id'=>$id])->orderBy(['invd_id'=>SORT_ASC])->asArray()->all();
		
		if(isset($invoice)){
			$data_customer = Customer::find()->where(['customer_id' => $invoice['inv_customer'], 'is_active'=>1])->asArray()->one();
			$data_customer_alias = CustomerAlias::find()->where(['customer_alias_id' => $invoice['inv_customer2'], 'is_active'=>1])->asArray()->one();
			
			$data['invoice'] = [$invoice];
			$data['customer'] = $data_customer;
			$data['customer_alias'] = $data_customer_alias;
		}else{
			$data['invoice'] = [];
		}
		
		if(isset($invoice)){
			$data['invoice_detail'] = $invoice_detail;
		}else{
			$data['invoice_detail'] = [];
		}
		
        return json_encode($data);
	}
	
	public function actionGetCostIdt()
	{
		$id = Yii::$app->request->post('id');
        $cost = MasterNewJobcost::find()->where(['vch_id'=>$id])->asArray()->one();
		$cost_detail = MasterNewJobcostDetail::find()->where(['vchd_vch_id'=>$id])->orderBy(['vchd_id'=>SORT_ASC])->asArray()->all();
		
		if(isset($cost)){
			$data['cost'] =  [$cost];
		}else{
			$data['cost'] = [];
		}
		
		if(isset($cost)){
			$data['cost_detail'] = $cost_detail;
		}else{
			$data['cost_detail'] = [];
		}
		
        return json_encode($data);
	}

	// ---------- Change Step n Status ---------- 
	public function actionPrintInvoice($id_job, $id_invoice){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id_invoice])->one();
		$terbilang = $this->terbilang($invoice->inv_grandtotal);
		
		if($invoice->inv_currency == 'IDR'){
			$filename = 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
			
			$content = $this->renderPartial('billing/invoice_idr/invoice_idr_print',[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}else{
			$filename = 'HMC'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
			
			if($invoice->inv_type == 3){
				$file = 'invoice_hmc_short_print';
			}elseif($invoice->inv_type == 4){
				$file = 'invoice_hmc_breakdown_print';
			}
			
			$content = $this->renderPartial('billing/invoice_hmc/'.$file,[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionPrintInvoiceHmc($id_job, $id_invoice){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id_invoice])->one();
		$terbilang = $this->terbilang_english($invoice->inv_grandtotal);
		
		$filename = 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
		
		if($invoice->inv_type == 3){
			$content = $this->renderPartial('billing/invoice_hmc/invoice_hmc_short_print',[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}elseif($invoice->inv_type == 4){
			$content = $this->renderPartial('billing/invoice_hmc/invoice_hmc_breakdown_print',[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionPrintInvoiceHmcBk($id_job, $id_invoice){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id_invoice])->one();
		$terbilang = $this->terbilang_english($invoice->inv_grandtotal);
		
		$filename = 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
		
		if($invoice->inv_type == 3){
			$content = $this->renderPartial('billing/invoice_hmc/invoice_hmc_short_print',[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}elseif($invoice->inv_type == 4){
			$content = $this->renderPartial('billing/invoice_hmc/invoice_hmc_breakdown_print',[
				'id_job' => $id_job,
				'id_invoice' => $id_invoice,
				'terbilang' => $terbilang,
			]);
		}
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionPrintCost($id_job, $id_cost){
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
		$terbilang = $this->terbilang($cost->vch_grandtotal);
		
		$filename = 'VPI'.str_pad($cost->vch_count,6,'0',STR_PAD_LEFT);
		
		$content = $this->renderPartial('billing/cost_idr/cost_idr_print',[
			'id_job' => $id_job,
			'id_cost' => $id_cost,
			'terbilang' => $terbilang,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionPrintCostHmc($id_job, $id_cost){
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
		$terbilang = $this->terbilang($cost->vch_grandtotal);
		
		$filename = 'VPI'.str_pad($cost->vch_count,6,'0',STR_PAD_LEFT);
		
		$content = $this->renderPartial('billing/cost_hmc/cost_hmc_print',[
			'id_job' => $id_job,
			'id_cost' => $id_cost,
			'terbilang' => $terbilang,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai){
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}
	
	public function terbilang_english($number)
    {
        $hyphen      = ' ';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . self::terbilang_english(abs($number));
        }

        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string    = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::terbilang_english($remainder);
                }
                break;
            default:
                $baseUnit     = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder    = $number % $baseUnit;
                $string       = self::terbilang_english($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::terbilang_english($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucwords($string);
    }
	
	
	
	public function actionGenerateNnBl($id)
	{
		$model = JobInfo::find()->where(['id_job' => $id])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$model->id_job = $id;
		$model->step = 2;
		$model->status = 0;
		$model->updated_at = date('Y-m-d H:i:s');;
		
		if($model->save(false)){
			return $this->redirect(['job/update', 'id' => $id]);
		}
	}
	
	public function actionSaveDoc1(){
		$model = JobInfo::find()->where(['id_job' => $_POST['JobInfo']['id_job']])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$batch_oribl = MasterG3eBatch::find()
				->where(['batchform_job' => $_POST['JobInfo']['id_job']])
				->one();
		
		if(isset($batch_oribl)){
			$model2 = $batch_oribl;
		}else{
			$model2 = new MasterG3eBatch;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$document = UploadedFile::getInstance($model, 'doc_1');
				
				if(!empty($document)){
					$path = Yii::getAlias('@app').'/web/upload/job/'.$model->id_job.'/doc1';
					if(!file_exists($path)){
						mkdir($path, 0777, true);
					}
					
					$document->saveAs($path.'/'.$document->name);
					$model->doc_1 = $document->name;
				}
				
				$model->step = 3;
				$model->status = 1;
				$model->updated_at = date('Y-m-d H:i:s');
				
				if($model->save(false)){
					$model2->batchform_job = $_POST['JobInfo']['id_job'];
					$model2->batchform_hbl = 1;
					$model2->batchform_1 = empty($_POST['branch_1']) ? 0 : $_POST['branch_1'];
					$model2->batchform_2 = empty($_POST['branch_2']) ? 0 : $_POST['branch_2'];
					$model2->batchform_3 = empty($_POST['branch_3']) ? 0 : $_POST['branch_3'];
					$model2->batchform_is_active = 1;
					
					if($model2->save()){
						return $this->redirect(['job/update', 'id' => $model->id_job]);
					}
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionApproveOriginalBl($id)
	{
		$model = JobInfo::find()->where(['id_job' => $id])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$model->id_job = $id;
		$model->step = 4;
		$model->status = 0;
		$model->updated_at = date('Y-m-d H:i:s');;
		
		if($model->save(false)){
			return $this->redirect(['job/update', 'id' => $id]);
		}
	}
	
	public function actionSaveDoc2(){
		$model = JobInfo::find()->where(['id_job' => $_POST['JobInfo']['id_job']])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$document = UploadedFile::getInstance($model, 'doc_2');
				
				if(!empty($document)){
					$path = Yii::getAlias('@app').'/web/upload/job/'.$model->id_job.'/doc2';
					if(!file_exists($path)){
						mkdir($path, 0777, true);
					}
					
					$document->saveAs($path.'/'.$document->name);
					$model->doc_2 = $document->name;
				}
				
				if($_POST['req-type'] == 'erc'){
					$model->step = 5;
					$model->status = 1;
					
					// Save to master_new_jobinvoice
					$db = MasterNewJobinvoice::find()
						->where(['inv_job_id' => $_POST['JobInfo']['id_job']])
						->andWhere(['inv_type'=>2])
						->andWhere(['inv_currency'=>'IDR'])
						->andWhere(['inv_is_active' => 1])
						->one();
					
					if(isset($db)){
						$model_inv = $db;
					}else{
						$model_inv = new MasterNewJobinvoice;
					}
					
					$last_count = MasterNewJobinvoice::find()->where(['inv_currency'=>'IDR'])->orderBy(['inv_count'=>SORT_DESC])->one();
					if(isset($last_count)){
						$count = $last_count->inv_count + 1;
					}else{
						$count = 1;
					}
					
					$job_party = JobParty::find()->where(['id_job' => $_POST['JobInfo']['id_job']])->andWhere(['is_active' => 1])->one();
					$pos_erc = Posv8::find()
						->where(['like', 'pos_name', 'EXPRESS RELEASE'])
						->andWhere(['>=', 'pos_validity_end', date('Y-m-d')])
						->andWhere(['is_active' => 1])
						->one();
					
					if(isset($pos_erc)){
						$invoice = $pos_erc->pos_fee_idr;
					}else{
						$invoice = 0;
					}
					
					$master_ppn = MasterPpn::find()->where(['defaults' => 1])->andWhere(['is_active' => 1])->one();
					
					if(isset($master_ppn)){
						$ppn = (($master_ppn->amount*1) / 100) * $invoice;
					}else{
						$ppn = 0;
					}
					
					$inv_grandtotal = $invoice + $ppn;
					
					$id_job = $_POST['JobInfo']['id_job'];
					$model_inv->inv_job_id = $id_job;
					$model_inv->inv_job_group = 0;
					$model_inv->inv_type = 2;
					$model_inv->inv_group = 0;
					$model_inv->inv_count = $model_inv->getOldAttribute('inv_count') ? $model_inv->getOldAttribute('inv_count') : $count;
					$model_inv->inv_date = date('Y-m-d');
					$model_inv->inv_due_date = date('Y-m-d');
					$model_inv->inv_code = '-';
					$model_inv->inv_currency = 'IDR';
					$model_inv->inv_customer = isset($job_party->customer) && !empty($job_party->customer) ? $job_party->customer : 0;
					$model_inv->inv_customer2 = isset($job_party->customer_alias) && !empty($job_party->customer_alias) ? $job_party->customer_alias : 0;
					$model_inv->inv_customer3 = isset($job_party->customer_address)  && !empty($job_party->customer_address) ? $job_party->customer_address : 0;
					$model_inv->inv_to = isset($job_party->billingparty_erc) && !empty($job_party->billingparty_erc) ? $job_party->billingparty_erc : 0;
					$model_inv->inv_to2 = isset($job_party->billingparty_alias_erc) && !empty($job_party->billingparty_alias_erc) ? $job_party->billingparty_alias_erc : 0;
					$model_inv->inv_to3 = isset($job_party->billingparty_address_erc) && !empty($job_party->billingparty_address_erc) ? $job_party->billingparty_address_erc : 0;
					$model_inv->inv_total = $invoice;
					$model_inv->inv_total_ppn = $ppn;
					$model_inv->inv_grandtotal = $inv_grandtotal;
					$model_inv->additional_notes = '';
					$model_inv->inv_is_active = 1;
					
					if($model_inv->save(false)){
						$invoice_detail = MasterNewJobinvoiceDetail::deleteall(['invd_inv_id'=>$model_inv->inv_id]);
						
						$detail = new MasterNewJobinvoiceDetail();
						$detail->invd_inv_id = $model_inv->inv_id;
						$detail->invd_job_id = $id_job;
						$detail->invd_job_group = 0;
						$detail->invd_type = 2;
						$detail->invd_count = 1;
						$detail->invd_pos = isset($pos_erc) ? $pos_erc->pos_id : 0;
						$detail->invd_detail = isset($pos_erc) ? (string) $pos_erc->pos_name : '-';
						$detail->invd_basis1_total = 0;
						$detail->invd_basis1_type = '0';
						$detail->invd_basis2_total = 0;
						$detail->invd_basis2_type = '0';
						$detail->invd_rate = '0';
						$detail->invd_rate_type = '-';
						$detail->invd_amount = isset($pos_erc) ? (string) $pos_erc->pos_fee_idr : '0';
						$detail->invd_sector = '-';
						$detail->invd_exch = '-';
						$detail->invd_id_ppn = isset($master_ppn) ? $master_ppn->id : 0;
						$detail->invd_ppn = $ppn;
						$detail->invd_is_active = 1;
						$detail->save();
					}
				}elseif($_POST['req-type'] == 'swb'){
					$model->step = 7;
					$model->status = 1;
				}elseif($_POST['req-type'] == 'cr'){
					$model->step = 9;
					$model->status = 1;
				}
				$model->updated_at = date('Y-m-d H:i:s');
				
				if($model->save(false)){
					return $this->redirect(['job/update', 'id' => $model->id_job]);
				}
			}
		}else{
            $model->loadDefaultValues();
        }
	}
	
	public function actionApproveExpressRelease($id)
	{
		$model = JobInfo::find()->where(['id_job' => $id])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$model->id_job = $id;
		$model->step = 6;
		$model->status = 0;
		$model->updated_at = date('Y-m-d H:i:s');;
		
		if($model->save(false)){
			return $this->redirect(['job/update', 'id' => $id]);
		}
	}
	
	public function actionApproveSeawayBill($id)
	{
		$model = JobInfo::find()->where(['id_job' => $id])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$model->id_job = $id;
		$model->step = 8;
		$model->status = 0;
		$model->updated_at = date('Y-m-d H:i:s');;
		
		if($model->save(false)){
			return $this->redirect(['job/update', 'id' => $id]);
		}
	}
	
	public function actionApproveCargoReceipt($id)
	{
		$model = JobInfo::find()->where(['id_job' => $id])->andWhere(['is_active' => 1])->one();
		
		if(!isset($model)){
			$model = new JobInfo;
		}
		
		$model->id_job = $id;
		$model->step = 10;
		$model->status = 0;
		$model->updated_at = date('Y-m-d H:i:s');;
		
		if($model->save(false)){
			return $this->redirect(['job/update', 'id' => $id]);
		}
	}
	
	// ---------- Print PDF ---------- 
	public function actionPrintDraftBl($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/draft-bl2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - Draft.pdf', 'I');
	}
	
	public function actionPrintNnBl($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/nn-bl2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - NN BL.pdf', 'I');
	}
	
	public function actionPrintNnBlLogo($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/nn-bl-logo2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - NN BL Logo.pdf', 'I');
	}
	
	public function actionPrintOriBl($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/ori-bl2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - Original BL.pdf', 'I');
	}
	
	public function actionPrintInvErc($id){
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/billing.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$invoice = MasterNewJobinvoice::find()->where(['inv_job_id'=>$id])->one();
		
		if(isset($invoice)){
			$terbilang = $this->terbilang($invoice->inv_grandtotal);
			$id_invoice = $invoice->inv_id;
		}else{
			$terbilang = '';
			$id_invoice = 0;
		}
		$filename = 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
		
		$content = $this->renderPartial('billing/invoice_erc/invoice_erc_print',[
			'id_job' => $id,
			'id_invoice' => $id_invoice,
			'terbilang' => $terbilang,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename.'.pdf', 'I');
	}
	
	public function actionPrintErc($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		$invoice = MasterNewJobinvoice::find()->where(['inv_job_id'=>$id])->andWhere(['inv_type' => 2])->one();
		
		if(isset($invoice)){
			$id_invoice = $invoice->inv_id;
		}else{
			$id_invoice = 0;
		}
		
		$content = $this->renderPartial('laporan/erc2',[
			'id' => $id,
			'id_invoice' => $id_invoice,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - Erc.pdf', 'I');
	}
	
	public function actionPrintSeawayBill($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/seaway_bill2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - Seaway Bill.pdf', 'I');
	}
	
	public function actionPrintCargoReceipt($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/bl.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$job = MasterNewJob::find()->where(['id'=>$id])->one();
		
		$content = $this->renderPartial('laporan/cargo_receipt2',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output($job->job_name.' - Cargo Receipt.pdf', 'I');
	}
	
	public function actionGetCustomerAlias()
	{
		$id = Yii::$app->request->post('id');
        $cus = Customer::find()->where(['customer_id'=>$id])->one();
        $list_customer = CustomerAlias::find()->where(['customer_id'=>$id])->all();
        $arrCus = [];
		
        foreach($list_customer as $c){
            array_push($arrCus,['customer_alias_id'=>$c->customer_alias_id, 'customer_name'=>$c->customer_name]);
        }
		
		$customer_alias = CustomerAlias::find()->where(['customer_alias_id'=>$arrCus[0]['customer_alias_id']])->asArray()->one();
		
        $data['list_customer'] =  $arrCus;
        $data['address'] = $customer_alias['customer_alias'];
		
        return json_encode($data);
    }
	
	public function actionGetCustomerAliasAddress()
	{
		$id = Yii::$app->request->post('id');
		
        $customer_alias = CustomerAlias::find()->where(['customer_alias_id'=>$id])->asArray()->one();
        
		if(isset($customer_alias)){
			return json_encode(array(
				'success' => true,
				'data' => $customer_alias,
			));
		}else{
			return json_encode(array(
				'success' => true,
				'message' => 'Data tidak ditemukan',
			));
		}
    }
	
	public function actionGetVesselRouting()
	{
		$id = Yii::$app->request->post('id');
        $master_vr = MasterVesselRouting::find()->where(['id'=>$id])->asArray()->one();
        $master_vr_detail = MasterVesselRoutingDetail::find()->where(['id_vessel_routing'=>$id])->asArray()->all();
		
		if(isset($master_vr)){
			$point_start = Point::find()->where(['point_code'=>$master_vr['point_start']])->one();
			$point_end = Point::find()->where(['point_code'=>$master_vr['point_end']])->one();
			
			$from = $point_start->point_code;
			$from_text = $point_start->point_name;
			$to = $point_end->point_name;
			$vessel = $master_vr['laden_on_board'];
		}else{
			$from = '-';
			$from_text = '-';
			$to = '-';
			$vessel = '-';
		}
		
        $data['from'] = $from;
        $data['from_text'] = $from_text;
        $data['to'] = $to;
        $data['vessel'] = $vessel;
        $data['details'] =  $master_vr_detail;
		
        return json_encode($data);
    }
	
	public function actionGetSignature()
	{
		$id = Yii::$app->request->post('id');
        $signature = Signature::find()->where(['signature_id'=>$id])->asArray()->one();
		
        $data['signature'] =  $signature;
		
        return json_encode($data);
    }
	
	protected function findModel($id)
    {
        if (($model = MasterNewJob::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
