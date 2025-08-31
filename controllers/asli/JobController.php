<?php

namespace app\controllers;

use Mpdf\Mpdf;

use app\models\MasterG3eJobrouting;

use app\models\MasterG3eHblDescription;

use app\models\MasterG3eHblCargodetail;
use app\models\MasterG3eContainer;

use app\models\MasterG3eHblRouting;
use app\models\MasterG3eVesselbatch;
use app\models\MasterNewJobBooking;

use app\models\MasterG3eHblCusdata;
use app\models\MasterNewJob;

use app\models\Signature;
use app\models\MasterG3eContainer2;
use app\models\MasterVesselRoutingDetail;
use app\models\MasterVesselRouting;
use app\models\CustomerAlias;
use app\models\Customer;
use app\models\Point;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Yii;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');

class JobController extends Controller
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
	
	public function actionCreate(){
		$this->layout = 'main-menu';
		
		$model = new MasterNewJob;
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$model->job = 'G3';
				$model->job_location = $model->job_location;
				$model->job_year = date('y');
				$model->job_month = date('m');
				$model->job_name = 'G3'.$model->job_type.'-'.$model->job_location.$model->job_year.$model->job_month.$model->job_number;
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
					return $this->redirect(['update', 'id' => $model->id]);
				}
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
	}
	
	public function actionUpdate($id)
	{
		$this->layout = 'main-menu';
		
		$parties = MasterNewJobBooking::find()->where(['id_job' => $id])->one();
		if(!isset($parties)){
			$parties = new MasterNewJobBooking;
		}
		
		$vessel_routing = MasterNewJobBooking::find()->where(['id_job' => $id])->one();
		if(!isset($vessel_routing)){
			$vessel_routing = new MasterNewJobBooking;
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
		
		$footer = MasterG3eHblDescription::find()->where(['hbldes_job_id' => $id, 'hbldes_is_active' => 1])->one();
		if(!isset($footer)){
			$footer = new MasterG3eHblDescription;
		}else{
			$footer->date_of_issue = $footer->hbldes_doi_year.'-'.$footer->hbldes_doi_month.'-'.$footer->hbldes_doi_day;
		}
		
		return $this->render('update', [
            'parties' => $parties,
            'vessel_routing' => $vessel_routing,
            'cargo' => $cargo,
            'description' => $description,
			'freight_terms' => $freight_terms,
			'reference' => $reference,
            'footer' => $footer,
        ]);
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
				$model->freight_term = '-';
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
						$model3->place_of_receipt =  $model->por->point_name;
						$model3->port_of_loading =  $model->pol->point_name;
						$model3->port_of_discharge =  $model->pod->point_name;
						$model3->port_of_delivery =  $model->fod->point_name;
						$model3->hblrouting_is_active = 1;
						
						if($model3->save(false)){
							return $this->redirect(['job/update', 'id' => $id_job]);
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
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->hblcrg_job_id;
				
				$i = 1;
				foreach($_POST['MasterG3eHblCargodetail']['detail'] as $row){
					$cargo = new MasterG3eHblCargodetail;
					$cargo->hblcrg_hbl_id = 1;
					$cargo->hblcrg_job_id = $model->hblcrg_job_id;
					$cargo->hblcrg_name = $row['hblcrg_name'];
					$cargo->hblcrg_name = $row['hblcrg_name'];
					$cargo->hblcrg_container_count = $i;
					$cargo->hblcrg_seal = $row['hblcrg_seal'];
					$cargo->hblcrg_pack_value = $row['hblcrg_pack_value'];
					$cargo->hblcrg_pack_type = $row['hblcrg_pack_type'];
					
					$row['hblcrg_gross_value1'] == '' ? $hblcrg_gross_value1 = '0' : $hblcrg_gross_value1 = $row['hblcrg_gross_value1'];
					$row['hblcrg_gross_value2'] == '' ? $hblcrg_gross_value2 = '00' : $hblcrg_gross_value2 = $row['hblcrg_gross_value2'];
					$row['hblcrg_nett_value1'] == '' ? $hblcrg_nett_value1 = '0' : $hblcrg_nett_value1 = $row['hblcrg_nett_value1'];
					$row['hblcrg_nett_value2'] == '' ? $hblcrg_nett_value2 = '00' : $hblcrg_nett_value2 = $row['hblcrg_nett_value2'];
					$row['hblcrg_msr_value1'] == '' ? $hblcrg_msr_value1 = '0' : $hblcrg_msr_value1 = $row['hblcrg_msr_value1'];
					$row['hblcrg_msr_value2'] == '' ? $hblcrg_msr_value2 = '00' : $hblcrg_msr_value2 = $row['hblcrg_msr_value2'];
					
					$cargo->hblcrg_gross_value = $hblcrg_gross_value1.'.'.$hblcrg_gross_value2;
					$cargo->hblcrg_gross_type = $model->hblcrg_gross_type;
					$cargo->hblcrg_nett_value = $hblcrg_nett_value1.'.'.$hblcrg_nett_value2;
					$cargo->hblcrg_nett_type = $model->hblcrg_nett_type;
					$cargo->hblcrg_msr_value = $hblcrg_msr_value1.'.'.$hblcrg_msr_value2;
					$cargo->hblcrg_msr_type = $model->hblcrg_msr_type;
					$cargo->hblcrg_combined = 0;
					$cargo->hblcrg_description = $row['hblcrg_description'];
					$cargo->hblcrg_is_active = 1;
					
					if($cargo->save(false)){
						$container = new MasterG3eContainer;
						$nama = explode(' ', $row['hblcrg_name']);
						$container->con_job_id = $model->hblcrg_job_id;
						$container->con_bl = 1;
						$container->con_count = $i;
						$container->con_code = $nama[0];
						$container->con_text = $nama[1];
						$container->con_name = $nama[2];
						$container->save(false);
					}
					
					$i++;
				}
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
				$model->hbldes_hbl_id = 1;
				$model->hbldes_declared_list = $model->getOldAttribute('hbldes_declared_list') ? $model->getOldAttribute('hbldes_declared_list') : '-';
				$model->hbldes_declared_text1 = $model->getOldAttribute('hbldes_declared_text1') ? $model->getOldAttribute('hbldes_declared_text1') : 0;
				$model->hbldes_declared_text2 = $model->getOldAttribute('hbldes_declared_text2') ? $model->getOldAttribute('hbldes_declared_text2') : 0;
				$model->hbldes_freight = $model->getOldAttribute('hbldes_freight') ? $model->getOldAttribute('hbldes_freight') : '-';
				$model->hbldes_payable = $model->getOldAttribute('hbldes_payable') ? $model->getOldAttribute('hbldes_payable') : '-';
				$model->hbldes_payable_details = $model->getOldAttribute('hbldes_payable_details') ? $model->getOldAttribute('hbldes_payable_details') : '-';
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
		
		if(isset($db)){
			$model = $db;
		}else{
			$model = new MasterG3eJobrouting;
		}
		
		if($this->request->isPost){
            if($model->load($this->request->post())){
				$id_job = $model->jr_job_id;
				$model->jr_account_repr = $model->getOldAttribute('jr_account_repr') ? $model->getOldAttribute('jr_account_repr') : 0;
				$model->jr_type = $model->getOldAttribute('jr_type') ? $model->getOldAttribute('jr_type') : '-';
				$model->jr_agent_list = $model->getOldAttribute('jr_agent_list') ? $model->getOldAttribute('jr_agent_list') : '-';
				$model->jr_agentcity_list = $model->getOldAttribute('jr_agentcity_list') ? $model->getOldAttribute('jr_agentcity_list') : '-';
				$model->jr_agentloc = $model->getOldAttribute('jr_agentloc') ? $model->getOldAttribute('jr_agentloc') : '-';
				$model->jr_house_scac = $model->getOldAttribute('jr_house_scac') ? $model->getOldAttribute('jr_house_scac') : '-';
				$model->jr_routing_no = $model->getOldAttribute('jr_routing_no') ? $model->getOldAttribute('jr_routing_no') : '-';
				$model->jr_sc_no = $model->getOldAttribute('jr_sc_no') ? $model->getOldAttribute('jr_sc_no') : '-';
				$model->jr_booking_number = $model->getOldAttribute('jr_booking_number') ? $model->getOldAttribute('jr_booking_number') : '-';
				$model->jr_forwarding_agent = $model->getOldAttribute('jr_forwarding_agent') ? $model->getOldAttribute('jr_forwarding_agent') : '-';
				$model->jr_crcode_list = $model->getOldAttribute('jr_crcode_list') ? $model->getOldAttribute('jr_crcode_list') : 0;
				$model->jr_crname_list = $model->getOldAttribute('jr_crname_list') ? $model->getOldAttribute('jr_crname_list') : 0;
				$model->jr_hbl_update = $model->getOldAttribute('jr_hbl_update') ? $model->getOldAttribute('jr_hbl_update') : 0;
				
				if($model->save(false)){
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
	
	public function actionDraftBl($id)
	{
		$mpdf = new \Mpdf\Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'orientation'=>'P',
			'setAutoTopMargin'=>'stretch',
        ]);
		
		//Css Mpdf
        $stylesheet = file_get_contents(Url::base(true).'/css/pdf.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		
		$content = $this->renderPartial('laporan/draft-bl',[
			'id' => $id,
		]);
		
		$mpdf->WriteHTML($content);
		$mpdf->Output();
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
		
        $data['list_customer'] =  $arrCus;
        $data['address'] = $cus->customer_address;
		
        echo json_encode($data);
    }
	
	public function actionGetVesselRouting()
	{
		$id = Yii::$app->request->post('id');
        $master_vr = MasterVesselRouting::find()->where(['id'=>$id])->asArray()->one();
        $master_vr_detail = MasterVesselRoutingDetail::find()->where(['id_vessel_routing'=>$id])->asArray()->all();
		
		if(isset($master_vr)){
			$point_start = Point::find()->where(['point_code'=>$master_vr['point_start']])->one();
			$point_end = Point::find()->where(['point_code'=>$master_vr['point_end']])->one();
			
			$from = $point_start->point_name;
			$to = $point_end->point_name;
			$vessel = $master_vr['laden_on_board'];
		}else{
			$from = '-';
			$to = '-';
			$vessel = '-';
		}
		
        $data['from'] = $from;
        $data['to'] = $to;
        $data['vessel'] = $vessel;
        $data['details'] =  $master_vr_detail;
		
        echo json_encode($data);
    }
	
	public function actionGetContainer()
	{
		$key = Yii::$app->request->post('key');
		$arrCon = [];
		
		if(empty($key)){
			$list_container = MasterG3eContainer2::find()->limit(100)->orderBy(['con_code'=>SORT_ASC]);
		}else{
			$list_container = MasterG3eContainer2::find()->where(['or', ['like', 'con_code', $key], ['like', 'con_text', $key], ['like', 'con_name', $key], ['like', 'concat(con_code," ",con_text," ",con_name)', $key]])->limit(100)->orderBy(['con_code'=>SORT_ASC]);
		}
		
		// if($list_container->count() > 0){
			$i=1;
			$cont = '';
			foreach($list_container->all() as $row){
				if($i == 1){
					$cont.= '<tr>'.
						'<td width="20%" class="align-top">
							<div class="form-check mb-2">
								<input class="form-check-input" type="checkbox" id="checkbox-'.$i.'" value="'.$row['con_id'].'">'.
								'<label class="fw-normal" for="checkbox-'.$i.'">'.$row['con_code'].'&nbsp;'.$row['con_text'].'&nbsp;'.$row['con_name'].'</label>'.
							'</div>
						</td>';
				}else{
					if($i % 5 == 0){
						$cont.= '</tr>';
					}else{
						$cont.= '<td width="20%" class="align-top">
								<div class="form-check mb-2">
									<input class="form-check-input" type="checkbox" id="checkbox-'.$i.'" value="'.$row['con_id'].'">'.
									'<label class="fw-normal" for="checkbox-'.$i.'">'.$row['con_code'].'&nbsp;'.$row['con_text'].'&nbsp;'.$row['con_name'].'</label>'.
								'</div>
							</td>';
					}
				}
				
				$i++;
			}
		// }else{
			// $cont = '<tr><td colspan="5">Data Tidak Ditemukan</td></tr>';
		// }
		
        $data['container'] = $cont;
		
        return json_encode($data);
    }
	
	public function actionGetContainer2()
	{
		$id = Yii::$app->request->post('id');
        $container = MasterG3eContainer2::find()->where(['con_id'=>$id])->asArray()->one();
		
        $data['container'] =  $container;
		
        echo json_encode($data);
    }
	
	public function actionGetSignature()
	{
		$id = Yii::$app->request->post('id');
        $signature = Signature::find()->where(['signature_id'=>$id])->asArray()->one();
		
        $data['signature'] =  $signature;
		
        echo json_encode($data);
    }
	
	protected function findModel($id)
    {
        if (($model = MasterNewJob::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
