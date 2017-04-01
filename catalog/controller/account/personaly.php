<?php
class ControllerAccountPersonaly extends Controller {
	private $error = array();

	public function index() {
		if (!$this -> customer -> isLogged()) {
			$this -> session -> data['redirect'] = HTTPS_SERVER . 'personal';

			$this -> response -> redirect(HTTPS_SERVER . 'login');
		}
$this->document->addScript('catalog/view/javascript/personal/tree.min.js');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['base'] = $server;

		$this -> load -> language('account/personal');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/personal');
		$data['lang'] = $language -> data;

		$this -> document -> setTitle($data['lang']['heading_title']);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home'));

		$data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('account/personal', '', 'SSL'));

		$data['heading_title'] = $this -> language -> get('heading_title');

		$data['column_left'] = $this -> load -> controller('common/column_left');
		$data['column_right'] = $this -> load -> controller('common/column_right');
		$data['content_top'] = $this -> load -> controller('common/content_top');
		$data['content_bottom'] = $this -> load -> controller('common/content_bottom');
		$data['footer'] = $this -> load -> controller('common/footer');
		$data['header'] = $this -> load -> controller('common/header');
		$data['idCustomer'] = $this -> customer -> getId();

		$this -> load -> model('account/customer');
		$id_user = $data['idCustomer'];
		$user = $this -> model_account_customer -> getCustomer($id_user);

		$data['nameCustomer'] = $this -> customer -> getFirstname();
		$data['telephone'] = $this -> customer -> getTelephone();
		$data['total_left'] = $this -> model_account_customer -> getSumLeft($id_user);
		$data['total_right'] = $this -> model_account_customer -> getSumRight($id_user);
		$data['floor'] = $this -> model_account_customer -> getSumFloor($id_user);
		$data['total'] = $data['total_left'] + $data['total_right'];
		$data['self'] = $this ;
		$data['register_link'] = HTTPS_SERVER.'register';
		//=============================Refferal=======================
		$customer = $this -> model_account_customer-> getCustomer($this -> session -> data['customer_id']);

		$Hash = $customer['customer_code'];	
		
		$data['customer_code'] = $Hash;

		$customer = $customer['username'];	
		$data['username'] = $customer;

		
		$customer = null;

		$data['customerChild'] = $this -> model_account_customer-> getParentByIdCustomer($this -> session -> data['customer_id']);
		
		$total = $this -> model_account_customer-> getCountTreeCustom($this -> session -> data['customer_id']);

		$data['trees'] =  HTTPS_SERVER . 'index.php?route=account/personal/get_BinaryTree';
		//==============================================================

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/personaly.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/personaly.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/personaly.tpl', $data));
		}
	}
	public function get_BinaryTree(){

		$this -> load -> model('account/customer');
		
		// $id = $this->request->get['id_user'];
		$id = $this->session->data['customer_id'];

		$user = $this -> model_account_customer -> getInfoUsers_binary($id);



		$node = new stdClass();


		$node->id = $id;
		
		// $node->text = $user['username'] ;

		$node->username = $user['username'] ;
		// $node -> email = $user['email'];
		// $node -> telephone = $user['telephone'];
		// $node -> date_added = $user['date_added'];
		$node -> level = $user['level'];
		// $node-> level_user = $user["level_member"];
		switch (intval($user['level'])) {
			case '1':
				$type = 'darkturquoise';
				break;
			
			case '2':
				$type = 'red';
				break;
			default:
				$type = 'blue';
				break;
			
		}
		$node-> type = $type;
		// $node -> status_ml = $user['status_ml'];
		

		$date = strtotime(date('Y-m-d'));
		$monthNow = date('m',$date);
		$yearNow = date('Y',$date);
		$date_added = strtotime($user['date_added']);
		$month = date('m',$date_added);
		$year = date('Y',$date_added);
		
		// if($user['status'] == 0){
		// 	$node->iconCls = "level4";
		// }else if($monthNow == $month && $yearNow == $year){
		// 	$node->iconCls = "level2";
		// }else{
		// 	$node->iconCls = "level3";
		// }

		$node->fl = 1;

		$this->get_BinaryChildTree($node);

		$node = array($node);

	//	ob_clean();
		echo json_encode($node[0]);

		exit();

	}
	public function get_BinaryChildTree(&$node){

		$date = strtotime(date('Y-m-d'));
		$monthNow = date('m',$date);
		$yearNow = date('Y',$date);
		
		$this -> load -> model('account/customer');
		$left_row = $this -> model_account_customer ->getLeftO($node->id);
		
		// print_r($left_row);
		// die();
			$left = new stdClass();
		
		    foreach ($left_row as $key => $value) {
		        $left->$key = $value;
		    } 
			
			$node->children = array();

			if(isset($left_row["id"])){

				$left->fl = $node->fl +1;
				$left -> position ='left';
				$lv = $node->level;
// switch (intval($lv)) {
// 			case '1':
// 				$type = 'darkturquoise';
// 				break;
			
// 			case '2':
// 				$type = 'red';
// 				break;
// 			default:
// 				$type = 'blue';
// 				break;
			
// 		}
		$left-> type = 'blue';
				$left -> empty = false;
				
					$this->get_BinaryChildTree($left);
				
				
				array_push($node->children , $left);			

			}
		

		$right_row = $this -> model_account_customer ->getRightO($node->id);
		$right = new stdClass();
	    foreach ($right_row as $key => $value) {
	        $right->$key = $value;
	    } 
		
		if(isset($right_row["id"])){

			$right->fl = $node->fl +1;
			$right -> position ='right';
$lv = $node->level;
// switch (intval($lv)) {
// 			case '1':
// 				$type = 'darkturquoise';
// 				break;
			
// 			case '2':
// 				$type = 'red';
// 				break;
// 			default:
// 				$type = 'blue';
// 				break;
			
// 		}
		$right-> type = 'darkturquoise';

			$right -> empty = false;
			
				$this->get_BinaryChildTree($right);

			

			array_push($node->children , $right);
		}
		

		if(count($node->children) ==0) $node->children = 0;

		return;

	}

	public function checkBinaryLeft($p_binary, $postion){

		$this -> load -> model('account/customer');
		if ($postion=='left') {
			$Binary = $this -> model_account_customer -> checkBinaryLeft($p_binary);

			if (!empty($Binary)) {
				$checkLeft = intval($Binary['left']);

				return $checkLeft === 0 ? 1 : 2;
				
			}
			else{
				return 1;
			}
				
				//return $checkLeft = 1;			
		}
		if ($postion=='right') {
			$Binary = $this -> model_account_customer -> checkBinaryRight($p_binary);	
			if (!empty($Binary)) {
				$checkRight = intval($Binary['right']);

			 	return $checkRight === 0 ? 1 : 2;
			} else {
				return 1;
			}
		}
		
	}
	public function checkBinaryRight($p_binary){
		$this -> load -> model('account/customer');
		$Binary = $this -> model_account_customer -> checkBinaryRight($p_binary);
		$CountBinary = count($Binary);
		if ($CountBinary > 0) {
			$checkRight = intval($Binary['right']);
		return $checkRight === 0 ? 1 : 2;
		}
		
	}
public function checkBinary($p_binary){
		$this -> load -> model('account/customer');
		$binary = $this -> model_account_customer -> checkBinary($p_binary);
		$checkbinary = count($binary);
		return $checkbinary === 0 ? 2 : 1;
	}
	public function add_customer (){

			$this -> load -> model('account/customer');
			$this -> document -> addScript('catalog/view/javascript/register/register.js');
		//language
		
	
		//method to call function
		
		! array_key_exists('p_binary', $this -> request -> get) && $this -> response -> redirect($this -> url -> link('/login.html'));
		! array_key_exists('token', $this -> request -> get) && $this -> response -> redirect($this -> url -> link('/login.html'));
		! array_key_exists('postion', $this -> request -> get) && $this -> response -> redirect($this -> url -> link('/login.html'));
		$p_binary = $this -> request -> get['p_binary'];
		$postion = $this -> request -> get['postion'];
		$code= $this->request->get['token'];
		if($postion === 'right' || $postion === 'left'){

		}else{
			$this -> response -> redirect(HTTPS_SERVER . 'login');
		}
		try {	
			$customer = $this -> model_account_customer -> getCustomer($p_binary);
			!$customer && $this -> response -> redirect(HTTPS_SERVER . 'login');
			
			$customercode = $this -> model_account_customer -> getCustomerbyCode($code);
			!$customercode && $this -> response -> redirect(HTTPS_SERVER . 'login');
			
		} catch (Exception $e) {
			$this -> response -> redirect(HTTPS_SERVER . 'login');
		}


		//start load country model
		$this -> load -> model('customize/country');
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;

		$data['country'] = $this -> model_customize_country -> getCountry();
		//end load country model

		//data render website
		$data['self'] = $this;

		//error validate
		$data['error'] = $this -> error;
		$data['p_binary'] = $p_binary;
		$data['postion'] = $this -> request -> get['postion'];
		$data['country'] = $this -> model_customize_country -> getCountry();
		$data['action'] = $this -> url -> link('account/registers/confirmSubmit', 'token=' . $this -> request -> get['token'], 'SSL');
		$data['actionCheckUser'] = $this -> url -> link('account/registers/checkuser', '', 'SSL');
		$data['actionCheckEmail'] = $this -> url -> link('account/registers/checkemail', '', 'SSL');
		$data['actionCheckPhone'] = $this -> url -> link('account/registers/checkphone', '', 'SSL');
		$data['actionCheckCmnd'] = $this -> url -> link('account/registers/checkcmnd', '', 'SSL');
		// $data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this -> load -> controller('common/footer');
		$data['header'] = $this -> load -> controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/registers.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/registers.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/registers.tpl', $data));
		}

	}

	public function register_submit(){
		
		//method to call function
		// !call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));

		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			$this -> load -> model('customize/register');
			$this -> load -> model('account/auto');
			$this -> load -> model('account/customer');

			$check_p_binary = $this -> model_account_customer -> check_p_binary($this->request->post['p_binary']);
			
			if (intval($check_p_binary['number']) === 2) {
				die('Error');
			}else{
				$tmp = $this -> model_customize_register -> addCustomer_custom($this->request->post);

				$cus_id= $tmp;
				$amount = 0;
				
				$checkC_Wallet = $this -> model_account_customer -> checkR_Wallet($cus_id);
				if(intval($checkC_Wallet['number'])  === 0){
					if(!$this -> model_account_customer -> insertR_WalletR($amount, $cus_id)){
						die();
					}
				}
				$data['has_register'] = true;
				//$this -> response -> redirect($this -> url -> link('account/', '#success', 'SSL'));
				$this -> response -> redirect(HTTPS_SERVER . 'login#success');
			}
			
		}

	}

	public function getInfoUser(){

		$id = $this->request->get['id'];
		
		$this -> load -> model('account/customer');

		$user = $this -> model_account_customer -> getInfoUsers_binary($id);

		$user['total_left'] =  $this -> model_account_customer ->  getSumLeft($id);	

		$user['total_right'] =  $this -> model_account_customer ->  getSumRight($id);
		
		$user['floor'] =  $this -> model_account_customer -> getSumFloor($id);
		
		$user['total'] = $user['total_left'] + $user['total_right'];

		echo json_encode($user);

		exit();

	}

	public function getInfoCustomer() {
		$id_user = $this -> request -> get['id_user'];

		$this -> load -> model('account/customer');

		$user = $this -> model_account_customer -> getCustomer($id_user);
		$json = array();
		$json['nameCustomer'] = $user['firstname'];
		$json['telephone'] = $user['telephone'];
		$json['total_left'] = $this -> model_account_customer -> getSumLeft($id_user);
		$json['total_right'] = $this -> model_account_customer -> getSumRight($id_user);
		$json['floor'] = $this -> model_account_customer -> getSumFloor($id_user);
		$json['total'] = $json['total_left'] + $json['total_right'];
		$this -> response -> addHeader('Content-Type: application/json');
		$this -> response -> setOutput(json_encode($json));
		
	}

	public function getJsonBinaryTree_Admin($id=0){

		$this -> load -> model('account/customer');
		
		$id = $this->request->get['id_user'];

		$user = $this -> model_account_customer -> getInfoUsers_binary($id);



		$node = new stdClass();


		$node->id = $id;
		
		$node->text = $user['username'] ;

		$node->username = $user['username'] ;
		$node -> email = $user['email'];
		$node -> telephone = $user['telephone'];
		$node -> date_added = $user['date_added'];
		$node -> level = $user['level'];
		$node -> level_user = $user["level_member"];

		$node -> leftPD = $this -> total_pd_left($id);
		$node -> rightPD = $this -> total_pd_right($id);

		$node -> empty = false;
		
		$date = strtotime(date('Y-m-d'));
		$monthNow = date('m',$date);
		$yearNow = date('Y',$date);
		$date_added = strtotime($user['date_added']);
		$month = date('m',$date_added);
		$year = date('Y',$date_added);
		
		if($user['status'] == 0){
			$node->iconCls = "level4";
		}else if($monthNow == $month && $yearNow == $year){
			$node->iconCls = "level2";
		}else{
			$node->iconCls = "level3";
		}

		$node->fl = 1;

		$this->getBinaryChild_binary($node);

		$node = array($node);

	//	ob_clean();
		echo json_encode($node);

		exit();

	}

	function total_pd_left($customer_id){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer ->  getCustomer($customer_id);
		$count = $count['total_pd_left'] / 100000000;

		return $count;
		// $left_id = $count['left'];
		// if(intval($count['left']) === 0){
		// 	$total = 0;
		// }else{
		// 	$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['left']);

		// 	$count = substr($count, 1);
		// 	$total = $this -> model_account_customer -> countPDLeft_Right($count);
		// 	$total = doubleval($total['total']);

		// 	$customer = $this -> model_account_customer -> getCustomer($left_id);
		// 	$total += doubleval($customer['total_pd']);

		// 	$total = $total / 100000000;
		// }

		// return $total;

	}

	public function total_pd_right($customer_id){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer ->  getCustomer($customer_id);

		$count = $count['total_pd_right'] / 100000000;
		return $count;
		// $left_id = $count['right'];
		// if(intval($count['right']) === 0){
		// 	$total = 0;
		// }else{
		// 	$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['right']);

		// 	$count = substr($count, 1);

		// 	$total = $this -> model_account_customer -> countPDLeft_Right($count);
		// 	$total = doubleval($total['total']);

		// 	$customer = $this -> model_account_customer -> getCustomer($left_id);
		// 	$total += doubleval($customer['total_pd']);
			
		// 	$total = $total / 100000000;

		// }

		// return $total;

	}

	public function getBinaryChild_binary(&$node){

		$date = strtotime(date('Y-m-d'));
		$monthNow = date('m',$date);
		$yearNow = date('Y',$date);
		
		$this -> load -> model('account/customer');
		$left_row = $this -> model_account_customer ->getLeftO($node->id);
		
		// print_r($left_row);
		// die();
			$left = new stdClass();
		
		    foreach ($left_row as $key => $value) {
		        $left->$key = $value;
		    } 
			

			$node->children = array();

			if(isset($left_row["id"])){

				$left->fl = $node->fl +1;
				$left -> empty = false;

				

				if($left->fl<5){
					$left -> leftPD = $this -> total_pd_left($left->id);
					$left -> rightPD = $this -> total_pd_right($left->id);
					$this->getBinaryChild_binary($left);
				}


				else $left->children = 1;
				
				array_push($node->children , $left);			

			}else{
				$left->fl = $node->fl +1;
				$left -> p_binary = $node -> id;
				$left -> empty = true;
				$left -> iconCls = 'level1 left';
				$left -> id =  "-1";
				array_push($node->children , $left);
			}
		

		$right_row = $this -> model_account_customer ->getRightO($node->id);
		$right = new stdClass();
	    foreach ($right_row as $key => $value) {
	        $right->$key = $value;
	    } 
		
		if(isset($right_row["id"])){

			$right->fl = $node->fl +1;

			$right -> empty = false;
			if($right->fl<5){
				$right -> leftPD = $this -> total_pd_left($right->id);
				$right -> rightPD = $this -> total_pd_right($right->id);
				$this->getBinaryChild_binary($right);
			}
			else $right->children = 1;

			array_push($node->children , $right);
		}else{
			$right->fl = $node->fl +1;
			$right -> empty = true;
			$right -> p_binary = $node -> id;
			$right -> iconCls = 'level1 right';
			$right -> id =  -1;
			array_push($node->children , $right);
		}
		

		if(count($node->children) ==0) $node->children = 0;

		return;

	}

	public function getJsonBinaryTree() {

		$id_user = $this -> request -> get['id_user'];

		$this -> load -> model('account/customer');

		$user = $this -> model_account_customer -> getCustomerCustom($id_user);

		$node = new stdClass();

		$node -> id = $user['customer_id'];

		$node -> text = $user['username'] ;

		$node -> iconCls = intval($user['level']) === 1 ? "level1" : "level2";
		

		$this -> getBinaryChild($node);

		$node = array($node);


		echo json_encode($node);

		exit();

	}

	public function getBinaryChild(&$node) {

		$this -> load -> model('account/customer');

		$listChild = $this -> model_account_customer -> getListChild($node -> id);

		$node -> children = array();

		foreach ($listChild as $child) {
			$childNode = new stdClass();

			$childNode -> id = $child['customer_id'];

			$childNode -> text = $child['username'];

			$childNode -> iconCls = intval($child['level']) === 1 ? "level1" : "level2";
			array_push($node -> children, $childNode);

			$this -> getBinaryChild($childNode);

		}
		if (count($node -> children) === 0)
			$node -> children = 0;
		return;

	}

}
