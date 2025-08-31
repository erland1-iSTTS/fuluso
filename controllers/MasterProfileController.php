<?php

namespace app\controllers;

use app\models\MasterVendor;
use app\models\Carrier;
use app\models\CustomerAlias;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\VarDumper;


class MasterProfileController extends Controller
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
		$model = new Customer;
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index_customer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
	
    public function actionView($customer_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($customer_id),
        ]);
    }
	
    public function actionCreate()
    {
        $model = new Customer();
		
		// VarDumper::dump($this->request->post(),10,true);die();
		
        if($this->request->isPost){
            if($model->load($this->request->post())){
				
				// Type local / overseas save ke tabel customer + customer_alias
				if($_POST['Customer']['customer_type'] == 'local' || $_POST['Customer']['customer_type'] == 'overseas'){
					
					if(empty($_POST['Customer']['telp1'])){
						$cust_telp1 = 0;
					}else{
						$cust_telp1 = $_POST['Customer']['telp1'];
					}
					
					if(empty($_POST['Customer']['telp2'])){
						$cust_telp2 = 0;
					}else{
						$cust_telp2 = $_POST['Customer']['telp2'];
					}
					
					if(empty($_POST['Customer']['telp3'])){
						$cust_telp3 = 0;
					}else{
						$cust_telp3 = $_POST['Customer']['telp3'];
					}
					
					$cust_telp = $cust_telp1.' '.$cust_telp2.' '.$cust_telp3;
					
					if($_POST['Customer']['customer_type'] == 'local'){
						$cust_type = 1;	// local
					}else{
						$cust_type = 2;	// overseas
					}
					
					if($_POST['Customer']['status'] == 'agent'){
						$cust_status = 1;	// agent
					}else{
						$cust_status = 0;	// non-agent
					}
					
					// Upload npwp customer
					$npwp_file = UploadedFile::getInstance($model, 'customer_npwp_file');
					
					$last_cust = Customer::find()->orderBy(['customer_id'=>SORT_DESC])->one();
					
					if(!empty($npwp_file)){
						$path = Yii::getAlias('@app').'/web/upload/customer/'.((int) ($last_cust->customer_id)+1).'/npwp';
						if(!file_exists($path)){
							mkdir($path, 0777, true);
						}
						$npwp_file->saveAs($path.'/'.$npwp_file->name);
						
						$filename = $npwp_file->name;
					}else{
						$filename = '';
					}
					
					// Customer Address
					$address1 = $_POST['Customer']['customer_address1'];
					$address2 = $_POST['Customer']['customer_address2'];
					$address3 = $_POST['Customer']['customer_address3'];
					$address4 = $_POST['Customer']['customer_address4'];
					$address5 = $_POST['Customer']['customer_address5'];
					$address6 = $_POST['Customer']['customer_address6'];
					
					if(empty($address1) && empty($address2) && empty($address3) && empty($address4) && empty($address5) && empty($address6)){
						$customer_address = '-';
					}else{
						// $textArray = [$address1, $address2, $address3, $address4, $address5, $address6];
						// $customer_address = implode('\n', $textArray);
						$customer_address = $address1."\r\n".$address2."\r\n".$address3."\r\n".$address4."\r\n".$address5."\r\n".$address6; 
					}
					
					$cust = new Customer();
					$cust->customer_nickname = empty($_POST['Customer']['customer_nickname']) ? '-' : $_POST['Customer']['customer_nickname'];
					$cust->customer_companyname = empty($_POST['Customer']['customer_companyname']) ? '-' : $_POST['Customer']['customer_companyname'];
					// $cust->customer_address = empty($_POST['Customer']['customer_address']) ? '-' : $_POST['Customer']['customer_address'];
					$cust->customer_address = $customer_address;
					$cust->customer_email_1 = empty($_POST['Customer']['customer_email_1']) ? '-' : $_POST['Customer']['customer_email_1'];
					$cust->customer_email_2 = empty($_POST['Customer']['customer_email_2']) ? '-' : $_POST['Customer']['customer_email_2'];
					$cust->customer_email_3 = empty($_POST['Customer']['customer_email_3']) ? '-' : $_POST['Customer']['customer_email_3'];
					$cust->customer_email_4 = empty($_POST['Customer']['customer_email_4']) ? '-' : $_POST['Customer']['customer_email_4'];
					$cust->customer_telephone = $cust_telp;
					$cust->customer_contact_person = empty($_POST['Customer']['customer_contact_person']) ? '-' : $_POST['Customer']['customer_contact_person'];
					$cust->customer_npwp = empty($_POST['Customer']['customer_npwp']) ? '-' : $_POST['Customer']['customer_npwp'];
					$cust->customer_npwp_file = $filename;
					$cust->is_active = 1;
					$cust->customer_type = $cust_type; 
					$cust->status = $cust_status; 
					$cust->is_vendor = isset($_POST['Customer']['is_vendor']) ? 1 : 0; 
					$cust->save();
					
					// Alias 1 auto sama dgn customer
					$cust_alias = new CustomerAlias;
					$cust_alias->customer_id = $cust->customer_id;
					$cust_alias->customer_name = '';
					$cust_alias->customer_alias = $cust->customer_companyname."\r\n".$cust->customer_address;
					$cust_alias->is_active = 1;
					$cust_alias->save();
					
					if(isset($_POST['Customer']['alias'])){
						foreach($_POST['Customer']['alias'] as $row){
							$cust_alias = new CustomerAlias;
							
							// Customer Address Alias
							$alias1 = $row['customer_alias1'];
							$alias2 = $row['customer_alias2'];
							$alias3 = $row['customer_alias3'];
							$alias4 = $row['customer_alias4'];
							$alias5 = $row['customer_alias5'];
							$alias6 = $row['customer_alias6'];
							
							if(empty($alias1) && empty($alias2) && empty($alias3) && empty($alias4) && empty($alias5) && empty($alias6)){
								$customer_alias = '-';
							}else{
								// $textArray = [$alias1, $alias2, $alias3, $alias4, $alias5, $alias6];
								// $customer_alias = implode('\n', $textArray); 
								$customer_alias = $alias1."\r\n".$alias2."\r\n".$alias3."\r\n".$alias4."\r\n".$alias5."\r\n".$alias6; 
							}
							
							$cust_alias->customer_id = $cust->customer_id;
							$cust_alias->customer_name = empty($row['customer_name']) ? '-' : $row['customer_name'];
							// $cust_alias->customer_alias = empty($row['customer_alias']) ? '-' : $row['customer_alias'];
							$cust_alias->customer_alias = $customer_alias;
							$cust_alias->is_active = 1;
							$cust_alias->save();
						}
					}
				}
				
				// Type carrier save ke tabel carrier
				if($_POST['Customer']['customer_type'] == 'carrier'){
					$carrier = new Carrier();
					$carrier->carrier_code = empty($_POST['Carrier']['carrier_code']) ? '-' : $_POST['Carrier']['carrier_code'];
					$carrier->name1 = empty($_POST['Carrier']['name1']) ? '-' : $_POST['Carrier']['name1'];
					$carrier->detail1 = empty($_POST['Carrier']['detail1']) ? '-' : $_POST['Carrier']['detail1'];
					$carrier->scac = empty($_POST['Carrier']['scac']) ? '-' : $_POST['Carrier']['scac'];
					$carrier->is_vendor = isset($_POST['Customer']['is_vendor']) ? 1 : 0; 
					$carrier->is_active = 1;
					
					if(isset($_POST['Carrier']['alias'][2])){
						if(empty($_POST['Carrier']['alias'][2]['name'])){
							$name2 = '-';
						}else{
							$name2 = $_POST['Carrier']['alias'][2]['name'];
						}
						if(empty($_POST['Carrier']['alias'][2]['detail'])){
							$detail2 = '-';
						}else{
							$detail2 = $_POST['Carrier']['alias'][2]['detail'];
						}
					}else{
						$name2 = '-';
						$detail2 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][3])){
						if(empty($_POST['Carrier']['alias'][3]['name'])){
							$name3 = '-';
						}else{
							$name3 = $_POST['Carrier']['alias'][3]['name'];
						}
						if(empty($_POST['Carrier']['alias'][3]['detail'])){
							$detail3 = '-';
						}else{
							$detail3 = $_POST['Carrier']['alias'][3]['detail'];
						}
					}else{
						$name3 = '-';
						$detail3 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][4])){
						if(empty($_POST['Carrier']['alias'][4]['name'])){
							$name4 = '-';
						}else{
							$name4 = $_POST['Carrier']['alias'][4]['name'];
						}
						if(empty($_POST['Carrier']['alias'][4]['detail'])){
							$detail4 = '-';
						}else{
							$detail4 = $_POST['Carrier']['alias'][4]['detail'];
						}
					}else{
						$name4 = '-';
						$detail4 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][5])){
						if(empty($_POST['Carrier']['alias'][5]['name'])){
							$name5 = '-';
						}else{
							$name5 = $_POST['Carrier']['alias'][5]['name'];
						}
						if(empty($_POST['Carrier']['alias'][5]['detail'])){
							$detail5 = '-';
						}else{
							$detail5 = $_POST['Carrier']['alias'][5]['detail'];
						}
					}else{
						$name5 = '-';
						$detail5 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][6])){
						if(empty($_POST['Carrier']['alias'][6]['name'])){
							$name6 = '-';
						}else{
							$name6 = $_POST['Carrier']['alias'][6]['name'];
						}
						if(empty($_POST['Carrier']['alias'][6]['detail'])){
							$detail6 = '-';
						}else{
							$detail6 = $_POST['Carrier']['alias'][6]['detail'];
						}
					}else{
						$name6 = '-';
						$detail6 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][7])){
						if(empty($_POST['Carrier']['alias'][7]['name'])){
							$name7 = '-';
						}else{
							$name7 = $_POST['Carrier']['alias'][7]['name'];
						}
						if(empty($_POST['Carrier']['alias'][7]['detail'])){
							$detail7 = '-';
						}else{
							$detail7 = $_POST['Carrier']['alias'][7]['detail'];
						}
					}else{
						$name7 = '-';
						$detail7 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][8])){
						if(empty($_POST['Carrier']['alias'][8]['name'])){
							$name8 = '-';
						}else{
							$name8 = $_POST['Carrier']['alias'][8]['name'];
						}
						if(empty($_POST['Carrier']['alias'][8]['detail'])){
							$detail8 = '-';
						}else{
							$detail8 = $_POST['Carrier']['alias'][8]['detail'];
						}
					}else{
						$name8 = '-';
						$detail8 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][9])){
						if(empty($_POST['Carrier']['alias'][9]['name'])){
							$name9 = '-';
						}else{
							$name9 = $_POST['Carrier']['alias'][9]['name'];
						}
						if(empty($_POST['Carrier']['alias'][9]['detail'])){
							$detail9 = '-';
						}else{
							$detail9 = $_POST['Carrier']['alias'][9]['detail'];
						}
					}else{
						$name9 = '-';
						$detail9 = '-';
					}
					
					if(isset($_POST['Carrier']['alias'][10])){
						if(empty($_POST['Carrier']['alias'][10]['name'])){
							$name10 = '-';
						}else{
							$name10 = $_POST['Carrier']['alias'][10]['name'];
						}
						if(empty($_POST['Carrier']['alias'][10]['detail'])){
							$detail10 = '-';
						}else{
							$detail10 = $_POST['Carrier']['alias'][10]['detail'];
						}
					}else{
						$name10 = '-';
						$detail10 = '-';
					}
					
					$carrier->name2 = $name2;
					$carrier->detail2 = $detail2;
					$carrier->name3 = $name3;
					$carrier->detail3 = $detail3;
					$carrier->name4 = $name4;
					$carrier->detail4 = $detail4;
					$carrier->name5 = $name5;
					$carrier->detail5 = $detail5;
					$carrier->name6 = $name6;
					$carrier->detail6 = $detail6;
					$carrier->name7 = $name7;
					$carrier->detail7 = $detail7;
					$carrier->name8 = $name8;
					$carrier->detail8 = $detail8;
					$carrier->name9 = $name9;
					$carrier->detail9 = $detail9;
					$carrier->name10 = $name10;
					$carrier->detail10 = $detail10;
					$carrier->save();
				}
				
				// Type carrier save ke tabel carrier
				if($_POST['Customer']['customer_type'] == 'vendor'){
					$vendor = new MasterVendor();
					$vendor->kode = empty($_POST['Vendor']['code']) ? '-' : $_POST['Vendor']['code'];
					$vendor->nama = empty($_POST['Vendor']['name']) ? '-' : $_POST['Vendor']['name'];
					$vendor->alamat = empty($_POST['Vendor']['address']) ? '-' : $_POST['Vendor']['address'];
					$vendor->flag = 1; 
					$vendor->save(); 
				}
					
                return $this->redirect(['index']);
            }
        }else{
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	public function actionEditCustomer($id)
    {
		$model = Customer::findOne(['customer_id' => $id]);
		$alias = CustomerAlias::find()->where(['customer_id' => $model->customer_id])->all();
		
		// VarDumper::dump($this->request->post(),10,true);die();
		
		if($this->request->isPost){
			if($model->load($this->request->post())){
				if(empty($_POST['Customer']['telp1'])){
					$cust_telp1 = 0;
				}else{
					$cust_telp1 = $_POST['Customer']['telp1'];
				}
				
				if(empty($_POST['Customer']['telp2'])){
					$cust_telp2 = 0;
				}else{
					$cust_telp2 = $_POST['Customer']['telp2'];
				}
				
				if(empty($_POST['Customer']['telp3'])){
					$cust_telp3 = 0;
				}else{
					$cust_telp3 = $_POST['Customer']['telp3'];
				}
				
				$cust_telp = $cust_telp1.' '.$cust_telp2.' '.$cust_telp3;
				
				if($_POST['Customer']['customer_type'] == 'local'){
					$cust_type = 1;	// local
				}else{
					$cust_type = 2;	// overseas
				}
				
				if($_POST['Customer']['status'] == 'agent'){
					$cust_status = 1;	// agent
				}else{
					$cust_status = 0;	// non-agent
				}
				
				// Customer Address
				$address1 = $_POST['Customer']['customer_address1'];
				$address2 = $_POST['Customer']['customer_address2'];
				$address3 = $_POST['Customer']['customer_address3'];
				$address4 = $_POST['Customer']['customer_address4'];
				$address5 = $_POST['Customer']['customer_address5'];
				$address6 = $_POST['Customer']['customer_address6'];
				
				if(empty($address1) && empty($address2) && empty($address3) && empty($address4) && empty($address5) && empty($address6)){
					$customer_address = '-';
				}else{
					// $textArray = [$address1, $address2, $address3, $address4, $address5, $address6];
					// $customer_address = implode('\n', $textArray);
					$customer_address = $address1."\r\n".$address2."\r\n".$address3."\r\n".$address4."\r\n".$address5."\r\n".$address6; 
				}
				
				$model->customer_nickname = empty($_POST['Customer']['customer_nickname']) ? '-' : $_POST['Customer']['customer_nickname'];
				$model->customer_companyname = empty($_POST['Customer']['customer_companyname']) ? '-' : $_POST['Customer']['customer_companyname'];
				// $model->customer_address = empty($_POST['Customer']['customer_address']) ? '-' : $_POST['Customer']['customer_address'];
				$model->customer_address = $customer_address;
				$model->customer_email_1 = empty($_POST['Customer']['customer_email_1']) ? '-' : $_POST['Customer']['customer_email_1'];
				$model->customer_email_2 = empty($_POST['Customer']['customer_email_2']) ? '-' : $_POST['Customer']['customer_email_2'];
				$model->customer_email_3 = empty($_POST['Customer']['customer_email_3']) ? '-' : $_POST['Customer']['customer_email_3'];
				$model->customer_email_4 = empty($_POST['Customer']['customer_email_4']) ? '-' : $_POST['Customer']['customer_email_4'];
				$model->customer_telephone = $cust_telp;
				$model->customer_contact_person = empty($_POST['Customer']['customer_contact_person']) ? '-' : $_POST['Customer']['customer_contact_person'];
				$model->customer_npwp = empty($_POST['Customer']['customer_npwp']) ? '-' : $_POST['Customer']['customer_npwp'];
				$model->is_active = 1;
				$model->customer_type = $cust_type; 
				$model->status = $cust_status; 
				$model->is_vendor = isset($_POST['Customer']['is_vendor']) ? 1 : 0; 
				
				if($model->save()){
					if(isset($_POST['Customer']['alias'])){
						foreach($_POST['Customer']['alias'] as $row){
							if(isset($row['customer_alias_id'])){
								$model2 = CustomerAlias::find()->where(['customer_alias_id' => $row['customer_alias_id']])->one();
							}else{
								$model2 = new CustomerAlias();
							}
							
							// Customer Address Alias
							$alias1 = $row['customer_alias1'];
							$alias2 = $row['customer_alias2'];
							$alias3 = $row['customer_alias3'];
							$alias4 = $row['customer_alias4'];
							$alias5 = $row['customer_alias5'];
							$alias6 = $row['customer_alias6'];
							
							if(empty($alias1) && empty($alias2) && empty($alias3) && empty($alias4) && empty($alias5) && empty($alias6)){
								$customer_alias = '-';
							}else{
								// $textArray = [$alias1, $alias2, $alias3, $alias4, $alias5, $alias6];
								// $customer_alias = implode('\n', $textArray); 
								$customer_alias = $alias1."\r\n".$alias2."\r\n".$alias3."\r\n".$alias4."\r\n".$alias5."\r\n".$alias6; 
							}
							
							$model2->customer_id = $model->customer_id;
							$model2->customer_name = empty($row['customer_name']) ? '' : $row['customer_name'];
							$model2->customer_alias = $customer_alias;
							$model2->is_active = 1;
							$model2->save();
						}
					}
				}
				
				return $this->redirect(['index']);
			}
		}else{
            $model->loadDefaultValues();
        }
		
		return $this->render('update', [
            'type' => 'customer',
            'model' => $model,
            'alias' => $alias,
        ]);
	}
	
    public function actionUpdate($customer_id)
    {
        $model = $this->findModel($customer_id);
		
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'customer_id' => $model->customer_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
    public function actionDelete($customer_id)
    {
        $this->findModel($customer_id)->delete();

        return $this->redirect(['index']);
    }
	
    protected function findModel($customer_id)
    {
        if (($model = Customer::findOne(['customer_id' => $customer_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
