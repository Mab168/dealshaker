<?php
class ControllerAccountGd extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
			$self -> document -> addScript('catalog/view/javascript/gd/gd.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));


		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/gd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		$data['getTotalPD'] = $this-> model_account_customer -> getTotalPD($this->session->data['customer_id']);

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		$data['get_all_amount'] = $this -> model_account_customer -> get_all_amount($this->session->data['customer_id']);
		$data['get_cn_amount_payment'] = $this -> model_account_customer -> get_cn_amount_payment($this->session->data['customer_id']);

		$data['getCustomer'] = $this -> model_account_customer -> getCustomer($this->session->data['customer_id']);
		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$data['language'] = $getLanguage;
		$language = new Language($getLanguage);
		$language -> load('account/gd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		
		$data['balanced'] = $this->url->link('account/gd/balanced', '', 'SSL');
		$data['weak_team_commission'] = $this->url->link('account/gd/weak_team_commission', '', 'SSL');
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/gd.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/gd.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/gd.tpl', $data));
		}
	}

	public function balanced(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');
		};
		$this -> load -> model('account/customer');
		$getCustomer = $this -> model_account_customer -> getCustomer($this->session->data['customer_id']);
		$getTotalPD = $this -> model_account_customer ->getTotalPD($this->session->data['customer_id']);
		
		
		if (doubleval($getCustomer['total_pd_left']) > doubleval($getCustomer['total_pd_right'])){
			 $balanced = doubleval($getCustomer['total_pd_right']);
			$this -> model_account_customer -> update_total_pd_left(doubleval($getCustomer['total_pd_left']) - doubleval($getCustomer['total_pd_right']), $this->session->data['customer_id']);
			$this -> model_account_customer -> update_total_pd_right(0, $this->session->data['customer_id']);
		}
		else
		{
			$balanced = doubleval($getCustomer['total_pd_left']);
			$this -> model_account_customer -> update_total_pd_right(doubleval($getCustomer['total_pd_right']) - doubleval($getCustomer['total_pd_left']), $this->session->data['customer_id']);
			$this -> model_account_customer -> update_total_pd_left(0, $this->session->data['customer_id']);
		}
		
		if (doubleval($balanced) <= 1000000000){
			$precent = 3;
		}
		if ($balanced >= 2000000000){
			$precent = 7;
		}
		if ($balanced >= 5000000000){
			$precent = 15;
		}
		$amount = ($balanced*$precent)/100;
		if (doubleval($amount) > (doubleval($getTotalPD['number'])*3))
		{
			$amount = (doubleval($getTotalPD['number']))*3;
		}
		//echo $amount;
		$this -> model_account_customer ->update_cn_Wallet($amount*0.5, $this->session->data['customer_id'], $add = true);
		$this -> model_account_customer ->update_M_Wallet($amount*0.5, $this->session->data['customer_id'], $add = true);
		$this -> model_account_customer -> inser_history('- '.(($amount*0.5)/100000000).' BTC','Balanced branch','50% commission withdrew weak team, 50% reinvestment',$this->session->data['customer_id']);
		$this ->session->data['complete'] = "complete";
		
		$this -> response -> redirect($this -> url -> link('account/gd', '', 'SSL'));
		
			
		
	}

	public function static_rate(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');
		};
		$this -> load -> model('account/customer');
	
		$results = $this -> model_account_customer -> getPD60Before();

		if (count($results) > 0){
			foreach ($results as $value) {
				$amount = ((float)$value['filled'])*0.02;
				$this -> model_account_customer -> update_wallet_r($value['customer_id'],$amount);
				$this -> model_account_customer -> update_max_profit($value['id'],$amount);
				//lưu lịch sử
				$this -> model_account_customer -> inser_history('+ '.($amount/100000000).' BTC','Daily rates',' 2% daily earnings from investment package  ('.($value['filled']/100000000).' BTC)',$value['customer_id']);
			}
		}
	}

	public function static_withdrawal_rate(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');
		};
		$this -> load -> model('account/customer');

		$results = $this -> model_account_customer -> static_withdrawal_rate($this->session->data['customer_id']);
		if (count($results) > 0)
		{
			$this -> model_account_customer ->update_wallet_m_50(doubleval($results['amount'])*0.5,$results['customer_id']);
			$this -> model_account_customer ->update_wallet_r_payment(doubleval($results['amount'])*0.5,$results['customer_id'],$results['wallet']);
			$this-> model_account_customer -> update_wallet_r0(0,$results['customer_id']);
				// lưu lịch sử
			$this -> model_account_customer -> inser_history('- '.(($results['amount'])*0.5/100000000).' BTC','Static withdrawal rate','50% direct Wallet for R ('.($results['amount']/10000000).' BTC)',$results['customer_id']);
		}	
	}
	public function weak_team_commission(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');
		};
		$this -> load -> model('account/customer');

		/*TÍNH HOA HỒNG NHÁNH YẾU*/
		$getCustomer = $this -> model_account_customer -> getCustomer($this->session->data['customer_id']);
		$getTotalPD = $this -> model_account_customer ->getTotalPD($this->session->data['customer_id']);
		if ((doubleval($getCustomer['total_pd_left']) > 0 && doubleval($getCustomer['total_pd_right'])) > 0)
		{
			if (doubleval($getCustomer['total_pd_left']) > doubleval($getCustomer['total_pd_right'])){
				 $balanced = doubleval($getCustomer['total_pd_right']);
				$this -> model_account_customer -> update_total_pd_left(doubleval($getCustomer['total_pd_left']) - doubleval($getCustomer['total_pd_right']), $this->session->data['customer_id']);
				$this -> model_account_customer -> update_total_pd_right(0, $this->session->data['customer_id']);
			}
			else
			{
				$balanced = doubleval($getCustomer['total_pd_left']);
				$this -> model_account_customer -> update_total_pd_right(doubleval($getCustomer['total_pd_right']) - doubleval($getCustomer['total_pd_left']), $this->session->data['customer_id']);
				$this -> model_account_customer -> update_total_pd_left(0, $this->session->data['customer_id']);
			}
			
			if (doubleval($balanced) <= 1000000000){
				$precent = 8;
			}
			if ($balanced >= 2000000000){
				$precent = 10;
			}
			if ($balanced >= 5000000000){
				$precent = 12;
			}
			$getTotalPD = $this-> model_account_customer -> getTotalPD($this->session->data['customer_id']);
			$getCustomer = $this-> model_account_customer -> getCustomer($this->session->data['customer_id']);
			$amount = ($balanced*$precent)/100;
			if (doubleval($amount) > (doubleval($getTotalPD['number'])*4))
			{
				$amount = (doubleval($getTotalPD['number']))*4;
			}
			$this -> model_account_customer ->update_cn_Wallet_payment($amount,$this->session->data['customer_id'],$getCustomer['wallet']);
			$this -> model_account_customer -> inser_history('- '.(($amount)/100000000).' BTC','Rose pulled weak team','direct Wallet for CN ('.($amount/10000000).' BTC)',$this->session->data['customer_id']);
			$this ->session->data['complete'] = "complete";
			echo "complete";
		}
		else
		{
			$this ->session->data['complete'] = "no_complete";
			echo "no_complete";
		}
		
		//$this -> response -> redirect($this -> url -> link('account/gd', '', 'SSL'));
	}
	public function direct_commission(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');
		};
		$this -> load -> model('account/customer');

		$results = $this -> model_account_customer -> direct_commission($this->session->data['customer_id']);
		//print_r($results);die;
		if (count($results) > 0)
		{
			$this -> model_account_customer ->update_wallet_m_50(doubleval($results['amount'])*0.5,$results['customer_id']);
			$this -> model_account_customer ->update_c_Wallet_payment(doubleval($results['amount'])*0.5,$results['customer_id'],$results['wallet']);
			$this-> model_account_customer -> update_wallet_c0(0,$results['customer_id']);
				// lưu lịch sử
			$this -> model_account_customer -> inser_history('- '.(($results['amount'])*0.5/100000000).' BTC','Direct commission','50% direct Wallet for C ('.($results['amount']/10000000).' BTC)',$results['customer_id']);
		}	
	}

	public function create() {
	
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/gd/create.js');
			$self -> load -> model('account/customer');
		};

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/gd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//get r_wallet AND c_wallet USER
		 $customer = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
        
        $data['wallet'] = $customer['wallet'] !== '';

		$data['r_wallet'] = $this -> model_account_customer -> getR_Wallet($this -> session -> data['customer_id']);
		$data['r_wallet'] = count($data['r_wallet']) > 0 ? $data['r_wallet']['amount'] : 0.0;

		$data['c_wallet'] = $this -> model_account_customer -> getC_Wallet($this -> session -> data['customer_id']);
		$data['c_wallet'] = count($data['c_wallet']) > 0 ? $data['c_wallet']['amount'] : 0.0;

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/gd_create.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/gd_create.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/gd_create.tpl', $data));
		}
	}

	public function submit() {


		if ($this -> customer -> isLogged() && $this -> request -> get['Password2']) {
			$json['login'] = $this -> customer -> isLogged() ? 1 : -1;
			$this -> load -> model('account/customer');

				

			$variablePasswd = $this -> model_account_customer -> getPasswdTransaction($this -> request -> get['Password2']);
			
			$json['password'] = $variablePasswd['number'] === '0' ? -1 : 1;
			if($json['password'] === -1){
				$json['ok'] = -1;
				$this -> response -> setOutput(json_encode($json));
			}else{
				$customer = $this -> model_account_customer ->getCustomer($this -> session -> data['customer_id']);
				
				if(intval($this -> request -> get['FromWallet']) === 2){
					$amount_R = $this -> model_account_customer -> getR_Wallet($this -> session -> data['customer_id']);
					$checkConfirmPD = $this->model_account_customer->getConfirmTransaction();

					$json['checkConfirmPD'] = count($checkConfirmPD) == 0 ? -1 : 1;
					intval($amount_R['amount']) === 0 && die();
				}else{
					$amount_C = $this -> model_account_customer -> getC_Wallet($this -> session -> data['customer_id']);
					intval($amount_C['amount']) === 0 && die();
					$json['checkConfirmPD'] = 1;
				}
				
				$amount = $this -> request -> get['amount'];
				
				
				if($amount <= 50000000){
					$amountPin = 1;
				}
				if($amount >= 100000000 && $amount <= 450000000){
					$amountPin = 2;
				}

				if($amount >= 500000000){
					$amountPin = 5;
				}

				if(intval($customer['ping']) <= $amountPin){
					// /$this -> response -> redirect($this -> url -> link('account/token/order', 'token='.$pd['id'].'', 'SSL'));
					$json['pin'] = -1;
				}else{
					$json['pin'] = 1;
				}

				

				if($json['pin'] === -1 || $json['checkConfirmPD'] == -1){
					
					$json['ok'] = -1;
					$this -> response -> setOutput(json_encode($json));
				}else{
				
					$this -> model_account_customer ->updatePin($this -> session -> data['customer_id'], intval($customer['ping']) - intval($amountPin) );
					
					//==================
					if(intval($this -> request -> get['FromWallet']) === 2){
					
					$amontGD = $this -> request -> get['amount'];
				
				}else{
					
					//UPdate M-Wallet
					$checkM_Wallet = $this -> model_account_customer -> checkM_Wallet($this -> session -> data['customer_id']);

					if (intval($checkM_Wallet['number']) === 0) {
						if (!$this -> model_account_customer -> insert_M_Wallet($this -> session -> data['customer_id'])) {
							die();
						}
					}
					$getM_GD = $this -> model_account_customer -> get_M_Wallet_GD($this -> session -> data['customer_id']);
					
					$amontGD = $this -> request -> get['amount'];
					$amount20Percent = ($amontGD*0.2);
					if (intval($getM_GD['number']) === 1) {
						
						$this -> model_account_customer -> update_M_Wallet($amount20Percent,$this -> session -> data['customer_id'], $date = true);
					}
					else{
						
						$this -> model_account_customer -> update_M_Wallet($amount20Percent,$this -> session -> data['customer_id']);
					}
					$this -> model_account_customer -> saveTranstionHistory($this -> session -> data['customer_id'], 'M-Wallet', '+ ' . ($amount20Percent/100000000) . ' BTC', "20% withdrew from C - Wallet");
					$amontGD = $amontGD - $amount20Percent;
				}
					//==============

					
					$returnDate = $this -> model_account_customer -> createGD($amontGD);
					$id_history = $this->model_account_customer->saveHistoryPin(
						$this -> session -> data['customer_id'],  
						'-'.intval($amountPin) ,
						'Used pin for GD'.$returnDate['gd_number'],
						'GD',
						'Used pin for GD'.$returnDate['gd_number']
					);
					//update r_wallet or c_wallet
					if($returnDate['query'] === true){
						$returnDate = false;
						if(intval($this -> request -> get['FromWallet']) === 2){
							//get R-wallet
							$returnDate = $this -> model_account_customer -> update_R_Wallet($this -> request -> get['amount'], $this -> session -> data['customer_id']);
							$this->model_account_customer->update_check_withdrawal();
						}

						if(intval($this -> request -> get['FromWallet']) === 1){
							$returnDate = $this -> model_account_customer -> update_C_Wallet($this -> request -> get['amount'], $this -> session -> data['customer_id']);
						}
					}
					
					$json['ok'] = $returnDate === true && $json['password'] === 1 ? 1 : -1;
					
					$this -> response -> setOutput(json_encode($json));
				}
				
			}
			
		}
	}


	public function transfer(){

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');

		};

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/gd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		!$this -> request -> get['token']  && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;
		

		$getGDCustomer = $this -> model_account_customer -> getGDByCustomerIDAndToken($this -> session -> data['customer_id'], $this -> request -> get['token']);
		
		intval($getGDCustomer['number']) === 0 && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		$getGDCustomer = null;

		$data['transferList'] = $this -> model_account_customer -> getGdFromTransferList($this -> request -> get['token']);
		// print_r($data['transferList']);
		// die();
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/gd_transfer.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/gd_transfer.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/gd_transfer.tpl', $data));
		}
	}

	public function confirm(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/confirm/confirm.js');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');

		};

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/gd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;

		!$this -> request -> get['token']  && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));
		

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		$data['transferConfirm'] = $this -> model_account_customer -> getGDTranferByID($this -> request -> get['token']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/gd_confirm.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/gd_confirm.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/gd_confirm.tpl', $data));
		}
	}

}
