<?php
class ControllerAccountPd extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
		};
		$this -> load -> model('account/customer');
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		$customer = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);



		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;
		$pd_total = $this -> model_account_customer -> getTotalPD($this -> session -> data['customer_id']);

		$pd_total = $pd_total['number'];

		$pagination = new Pagination();
		$pagination -> total = $pd_total;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = str_replace('/index.php?route=', "/", $this -> url -> link('investment-detail.html', 'page={page}', 'SSL'));

		$data['pds'] = $this -> model_account_customer -> getPDById($this -> session -> data['customer_id'], $limit, $start);
		$data['pagination'] = $pagination -> render();


		//get all PD
		$data['pd_all'] = $this -> model_account_customer ->getPD($this -> session -> data['customer_id']);
		

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd.tpl', $data));
		}
	}
	public function countDay($id =null){
		$this -> load -> model('account/pd');
		$countDayPD = $this -> model_account_pd ->CountDayPD($id);
		echo ($countDayPD['number']) > 0 ? 1 : 2;
	}
	public function countTransferID($transferid =null){
		$this -> load -> model('account/pd');
		$countDayPD = $this -> model_account_pd ->countTransferID($transferid);
		return $countDayPD['number'] > 0 ? 1 : 2;
	}

	public function payconfirm() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
		};

		!$this -> request -> get['token'] && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;

		$getPDCustomer = $this -> model_account_customer -> getPDByCustomerIDAndToken($this -> session -> data['customer_id'], $this -> request -> get['token']);

		$getPDCustomer['number'] == 0 && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		$getPDCustomer = null;

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;
		$data['pd_id'] = $this -> request -> get['token'];

		$data['PdUser'] = $this -> model_account_customer -> getPDConfirm($this -> request -> get['token']);

		$data['wallet'] = $this -> config -> get('config_wallet');
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pay_confirm.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pay_confirm.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pay_confirm.tpl', $data));
		}

	}

	public function PayconfirmSubmit() {
		
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};
		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> load -> model('account/pd');
		};
		//method to call function

		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));
		!array_key_exists('amount', $this -> request -> get) && $this -> response -> redirect($this -> url -> link('/login.html'));
		//language

		//check count customer
		$count_invoice = $this -> model_account_pd -> countPD($this -> session -> data['customer_id']);

		$count_invoice = $count_invoice['number'];
		$data['notCreate'] = false;

		if ($count_invoice > 5)
			$data['notCreate'] = true;
		//save invoice
		if (!$data['notCreate']) {
			$secret = substr(hash_hmac('ripemd160', hexdec(crc32(md5(microtime()))), 'secret'), 0, 16);

			$transferId = $this->request->get['transferid'];
			$amount = $this->request->get['amount'];
			$callback = "";
			$invoice_id = $this -> model_account_pd -> saveInvoice($this -> session -> data['customer_id'], $secret, $amount,$transferId,$callback);

			$invoice_id === -1 && die('Server error , Please try again !!!!');
			$invoice_id_hash = hexdec(crc32(md5($invoice_id)));
			//create API Blockchainapi.org
			//$my_address = $this -> request -> get['wallet'];
			$my_address = '13i8NozB6uZRGgKMLrMoza9rZumqYuHGPV';

			//$my_address = '1Lhq2QCtt8TZNcAv9oSY1ng8WRE3VTwnHs';
			$my_callback_url = HTTPS_SERVER . 'index.php?route=account/pd/callback&invoice_id=' . $invoice_id_hash . '&secret=' . $secret;
			$api_base = 'https://blockchainapi.org/api/receive';
			$response = $api_base . '?method=create&address=' . $my_address . '&callback=' . urlencode($my_callback_url);
			$fcontents = implode('', file($response));
			$object = json_decode($fcontents);
			//update input address and fee_percent
			!$this -> model_account_pd -> updateInaddressAndFree($invoice_id, $invoice_id_hash, $object -> input_address, $object -> fee_percent, $object -> destination) && die('Server Error !!!!');
			$data['wallet'] = $object -> input_address;
			//setup and check show qr code
			$data['bitcoin'] = $amount;
			!intval($data['bitcoin']) && $this -> response -> redirect($this -> url -> link('/login.html'));
			$data['bitcoin'] = intval($data['bitcoin']);
		       $data['self'] = $this;
            $json['link'] = HTTPS_SERVER . 'invoice&invoice_hash=' . $invoice_id_hash;
            
            $this->response->setOutput(json_encode($json));
        } else {
            $data['invoice'] = $this->model_account_pd->getAllInvoiceByCustomer_notCreateOrder($this->session->data['customer_id']);
            $json['link']    = HTTPS_SERVER . 'index.php?route=account/pd/show_invoice_pending';
            $this->response->setOutput(json_encode($json));
        }

	}

	public function show_invoice_pending()
    {
        function myCheckLoign($self)
        {
            return $self->customer->isLogged() ? true : false;
        }
        ;
        function myConfig($self)
        {
            $self->load->model('account/customer');
            $self->load->model('account/pd');
        }
        ;
        //method to call function
        !call_user_func_array("myCheckLoign", array(
            $this
        )) && $this->response->redirect(HTTPS_SERVER . 'login.html');
        call_user_func_array("myConfig", array(
            $this
        ));
        $data['notCreate'] = true;
        $data['invoice']   = $this->model_account_pd->getAllInvoiceByCustomer_notCreateOrder($this->session->data['customer_id']);
        $data['self']      = $this;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/confirmPending.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/confirmPending.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/confirmPending.tpl', $data));
        }
    }
	 public function show_invoice()
    {
    
        function myCheckLoign($self)
        {
            return $self->customer->isLogged() ? true : false;
        }
        ;
        function myConfig($self)
        {
        	$self -> document -> addScript('catalog/view/javascript/pd/confirm.js');
            $self->load->model('account/customer');
            $self->load->model('account/pd');
        }
         
        //method to call function
        !call_user_func_array("myCheckLoign", array(
            $this
        )) && $this->response->redirect(HTTPS_SERVER . 'login.html');
        call_user_func_array("myConfig", array(
            $this
        ));

        !array_key_exists('invoice_hash', $this->request->get) && die();
        $invoice_hash = $this->request->get['invoice_hash'];

        $invoice      = $this->model_account_pd->getInvoceFormHash($invoice_hash, $this->session->data['customer_id']);

        !$invoice && $this->response->redirect(HTTPS_SERVER . 'login.html');
         
        $count_invoice     = $this->model_account_pd->countPD($this->session->data['customer_id']);
        $count_invoice     = $count_invoice['number'];
        $data['notCreate'] = false;
        if ($count_invoice > 6) {
            $data['notCreate'] = true;
            $data['invoice']   = $this->model_account_token->getAllInvoiceByCustomer_notCreateOrder($this->session->data['customer_id']);
        } else {
            $data['bitcoin'] = $invoice['amount'];
            $data['wallet']  = $invoice['input_address'];
            $data['date_added']  = $invoice['date_created'];
            $data['transfer_id']  = $invoice['transfer_id'];
            $data['received']  = $invoice['received'];
         	$data['confirmations']  = $invoice['confirmations'];
     	}
        $this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;

        $data['self'] = $this;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/checkConfirmPd.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/checkConfirmPd.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/checkConfirmPd.tpl', $data));
        }
    }

	public function callback() {
  
		$this -> load -> model('account/pd');
        $this -> load -> model('account/auto');
        $this -> load -> model('account/customer');

        $invoice_id = array_key_exists('invoice', $this -> request -> get) ? $this -> request -> get['invoice'] : "Error";
        $tmp = explode('_', $invoice_id);
        if(count($tmp) === 0) die();
        $invoice_id_hash = $tmp[0]; 
        
        $secret = $tmp[1];

        //check invoice
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id_hash, $secret);
      
  

        
        $block_io = new BlockIo(key, pin, block_version);
        $transactions = $block_io->get_transactions(
            array(
                'type' => 'received', 
                'addresses' => $invoice['input_address']
            )
        );


        $received = 0;
        if($transactions -> status = 'success'){
            $txs = $transactions -> data -> txs;
             foreach ($txs as $key => $value) {
                $send_default = 0; 
                
                foreach ($value -> amounts_received as $k => $v) {
                    if(intval($value -> confirmations) >= 3){
                        $send_default += (doubleval($v -> amount));
                    }
                    $received += (doubleval($v -> amount) * 100000000); 
                }
                // if($send_default > 0){
                //     $tmp_amount = doubleval($send_default) - 0.0002;
                //     $block_io->withdraw_from_addresses(array(
                //         'amounts' => $send_default - 0.0002, 
                //         'from_addresses' => $invoice['input_address'], 
                //         'to_addresses' => '38Lg6yUsiEPaHDh33DLxeULnbpexSsm89E',
                //         'priority' => 'low'
                //     ));
                //     die();
                // }
                
            }         
        }

        intval($invoice['confirmations']) >= 3 && die();

        $this -> model_account_pd -> updateReceived($received, $invoice_id_hash);
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id, $secret);
     	
        $received = intval($invoice['received']);

        if ($received >= intval($invoice['amount'])) {

            $this -> model_account_customer ->updateLevel($invoice['customer_id'], 2);

            $this -> model_account_pd -> updateConfirm($invoice_id_hash, 3, '', '');

            //update PD
            $this -> model_account_pd -> updateStatusPD($invoice['transfer_id'], 1);

            $pd_tmp_pd = $this -> model_account_pd -> getPD($invoice['transfer_id']);
            $pd_tmp_ = $pd_tmp_pd ;
            $pd_tmp_ = $pd_tmp_['filled'];

            $pd_tmp_ = $pd_tmp_ * 0.02;

            $this -> model_account_pd -> updateDatefinishPD($invoice['transfer_id'], $pd_tmp_);
            
            $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
       
            $amountPD = intval($invoice['amount']);
            
            $max_profit = $amountPD * 0.02;

            $this -> model_account_customer -> update_R_Wallet_add($pd_tmp_,$invoice['customer_id'], $customer['wallet']);
      

            $check_signup = intval($customer['check_signup']);

                //update pd left and right
                //get customer_ml p_binary
                $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($invoice['customer_id']);

                $customer_first = true ;
                if(intval($customer_ml['p_binary']) !== 0 && $check_signup !== 1){
                	$amount_binary = $pd_tmp_pd['filled'];
                    while (true) {
                        //lay thang cha trong ban Ml
                        $customer_ml_p_binary = $this -> model_account_customer -> getTableCustomerMLByUsername($customer_ml['p_binary']);

                        if($customer_first){
                            //kiem tra la customer dau tien vi day la gia tri callback mac dinh
                            if(intval($customer_ml_p_binary['left']) === intval($invoice['customer_id']) )  {
                                //nhanh trai
                                $this -> model_account_customer -> update_pd_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Bitcoin Left', '+ ' . ($amount_binary/100000000) . ' BTC', "From ".$customer['username']." Active Package # (".($amount_binary/100000000)." BTC)");   
                                
                            }else{
                                //nhanh phai
                                $this -> model_account_customer -> update_pd_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Bitcoin Right', '+ ' . ($amount_binary/100000000) . ' BTC', "From ".$customer['username']." active Package # (".($amount_binary/100000000)." BTC)");   
                            }
                            $customer_first = false;
                        }else{
                
                            if(intval($customer_ml_p_binary['left']) === intval($customer_ml['customer_id']) ) {
                                //nhanh trai
                                $this -> model_account_customer -> update_pd_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Bitcoin Left', '+ ' . ($amount_binary/100000000) . ' BTC', "From ".$customer['username']." active Package # (".($amount_binary/100000000)." BTC)");   
                            }else{
                                //nhanh phai
                                $this -> model_account_customer -> update_pd_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Bitcoin Right', '+ ' . ($amount_binary/100000000) . ' BTC', "From ".$customer['username']." active Package # (".($amount_binary/100000000)." BTC)");   
                            }
                        }
                        
                        

                        if(intval($customer_ml_p_binary['customer_id']) === 1){
                            break;
                        }
                        //lay tiep customer de chay len tren lay thang cha
                        $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($customer_ml_p_binary['customer_id']);

                    } 
                }

                 //=========Hoa hong bao tro=====================
                
                $partent = $this -> model_account_customer ->getCustomer($customer['p_node']);

               if (!empty($partent) && $check_signup !== 1) {

                // Check ! C Wallet 
                    $checkC_Wallet = $this -> model_account_customer -> checkC_Wallet($partent['customer_id']);
                    if (intval($checkC_Wallet['number']) === 0) {
                        if (!$this -> model_account_customer -> insertC_Wallet($partent['customer_id'])) {
                            die();
                        }
                    }

                    // if (intval($partent['active_tree']) === 1) {
                     $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
	                //$percent = floatval($this -> config -> get('config_percentcommission'));
	                
	                $amountPD = intval($pd_tmp_pd['filled']);

	                $this->commission_Parrent($invoice['customer_id'], $amountPD, $invoice['transfer_id']);
                    // }
               }
           }

	}


	 public function commission_Parrent($customer_id, $amountPD, $transfer_id){

        $this->load->model('account/customer');
        $this->load->model('account/auto');
        $customer = $this -> model_account_customer ->getCustomer($customer_id);
                
        $partent = $this -> model_account_customer ->getCustomer($customer['p_node']);

        $partent_customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($partent['customer_id']);

        if (intval($partent_customer_ml['level']) >= 2) {

            $price = $amountPD;
            $price = $price * 0.1;
            

            $price = $price - 30000;

            $price = $price / 100000000;
     		if($price > 0){
     			
     			$price = round($price,8);

	     		$block_io = new BlockIo(key, pin, block_version);

	            $tml_block = $block_io -> withdraw(array(
	                'amounts' => $price , 
	                'to_addresses' => $partent['wallet'],
	                'priority' => 'low'
	            ));
	     
	            $txid = $tml_block -> data -> txid;
	            
	            //luu ban table truc tiep cong don
                $this -> model_account_customer -> update_wallet_c0(( ($price + 0.0003 ) * 100000000),$partent['customer_id']);

	            $this -> model_account_customer -> saveTranstionHistory(
	            	$partent['customer_id'],
	            	'Refferal Commistion', 
	            	'+ ' . ($price + 0.0003) . ' BTC',
	            	"Refferal 10 % from ".$customer['username']." active package (".($amountPD/100000000)." BTC)",
	            	'<a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>');   
     		}

                  
        }
        
       
    }

	public function create() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/pd/create.js');
			$self -> load -> model('account/customer');

		};

		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		$CheckPDUpdate = $this -> model_account_customer -> getCheckPD($this -> session -> data['customer_id']);

		$data['count'] = $CheckPDUpdate['check_PD'];

		 $customer = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
        
        $data['wallet'] = $customer['wallet'] !== '';


		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd_create.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd_create.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd_create.tpl', $data));
		}
	}

	public function submit() {

		$json['login'] = $this -> customer -> isLogged() ? 1 : -1;

		if ($this -> customer -> isLogged() && $this -> request -> get['amount'] && $this -> request -> get['Password2']) {
			$this -> load -> model('account/customer');
			$this -> load -> model('account/pd');
			$variablePasswd = $this -> model_account_customer -> getPasswdTransaction($this -> request -> get['Password2']);

			$json['password'] = $variablePasswd['number'] === '0' ? -1 : 1;

			// $checkgd = $this -> model_account_customer -> getTotalGD($this -> session -> data['customer_id']);
			// $json['checkgd'] = $checkgd['number'] === '0' ? -1 : 1;

			// $checkpd = $this -> model_account_customer -> getTotalPD($this -> session -> data['customer_id']);
			// $json['checkpd'] = ($checkpd['number'] > 0) ? -1 : 1;

			$customer = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);

			$checkAccount_holder = $customer['account_holder'];

			if (intval($customer['ping']) <= 2) {
				// /$this -> response -> redirect($this -> url -> link('account/token/order', 'token='.$pd['id'].'', 'SSL'));
				$json['pin'] = -1;
			} else {
				$json['pin'] = 1;
			}

			//khong check pin cho Pd
			$json['pin'] = 1;

			$pd_total = $this -> model_account_customer -> getStatusPD();
			$pd_total = $pd_total['pdtotal'];

			$json['checkWaiting'] = $pd_total > 0 ? -1 : 1;
			$json['checkCountDay'] = 1;
			
			if ($json['password'] === 1 && $json['pin'] === 1 && $json['checkCountDay'] === 1 && $json['checkWaiting'] === 1) {

				$amount = $this -> request -> get['amount'];
				$amount = $amount * 100000000;

					$max_profit = 0;
					// $subPin = intval($customer['ping']) - 1;
					// $this -> model_account_customer -> updatePin($this -> session -> data['customer_id'], intval($customer['ping']) - intval($amountPin));
					$pd_query = $this -> model_account_customer -> createPD($amount, $max_profit);
					// $id_history = $this -> model_account_customer -> saveHistoryPin($this -> session -> data['customer_id'], '-' . $amountPin, 'Used pin for PD' . $pd_query['pd_number'], 'PD', 'Used pin for PD' . $pd_query['pd_number']);

					// UP date Cycle IN tbl sm_Customer
					// $this->model_account_customer->ResetCycleAddCustomer($this -> session -> data['customer_id']);
					//====================================================================
							//get customer in inventory
					//====================================================================
					$secret = substr(hash_hmac('ripemd160', hexdec(crc32(md5(microtime()))), 'secret'), 0, 16);
					$transferId = $pd_query['pd_number'];
					
					$invoice_id = $this -> model_account_pd -> saveInvoice($this -> session -> data['customer_id'], $secret, $amount,$transferId);

					$invoice_id === -1 && die('Server error , Please try again !!!!');
					$invoice_id_hash = hexdec(crc32(md5($invoice_id)));
					//create API Blockchainapi.org
					//$my_address = $this -> request -> get['wallet'];

					$my_address = '13i8NozB6uZRGgKMLrMoza9rZumqYuHGPV';

					//$my_address = '1MYfjwBjsPqn9rQ5xZSy7WVAnwZCjNPrx8';

					//$my_address = '16uhQ2AW5beXwKj8uGXhci51r7emBhaV7N';
					$my_callback_url = HTTPS_SERVER . 'index.php?route=account/pd/callback&invoice_id=' . $invoice_id_hash . '&secret=' . $secret;
					$api_base = 'https://blockchainapi.org/api/receive';
					$response = $api_base . '?method=create&address=' . $my_address . '&callback=' . urlencode($my_callback_url);
					$fcontents = implode('', file($response));
					$object = json_decode($fcontents);
					//update input address and fee_percent
					!$this -> model_account_pd -> updateInaddressAndFree($invoice_id, $invoice_id_hash, $object -> input_address, $object -> fee_percent, $object -> destination) && die('Server Error !!!!');
					$data['wallet'] = $object -> input_address;
					//setup and check show qr code
					$data['bitcoin'] = $amount;
					!intval($data['bitcoin']) && $this -> response -> redirect($this -> url -> link('/login.html'));
					$data['bitcoin'] = intval($data['bitcoin']);
				       $data['self'] = $this;
		            $json['data_link'] = HTTPS_SERVER . 'invoice&invoice_hash=' . $invoice_id_hash;
					// $json['data_link']= $this->url->link('account/pd/trade&token='.$pd_query['pd_id'].'');
					$json['ok'] = 1;
			
				
			} else{
				$json['ok'] = -1;
			}

			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function transfer() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
		};

		!$this -> request -> get['token'] && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;

		$getPDCustomer = $this -> model_account_customer -> getPDByCustomerIDAndToken($this -> session -> data['customer_id'], $this -> request -> get['token']);

		$getPDCustomer['number'] === 0 && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		$getPDCustomer = null;

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		//get pd form transfer list
		$PdUser = $this -> model_account_customer -> getPD($this -> session -> data['customer_id']);

		$checkPdOfUser = null;
		foreach ($PdUser as $key => $value) {
			if ($value['id'] === $this -> request -> get['token']) {
				$checkPdOfUser = true;
				break;
			}
		}

		!$checkPdOfUser && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));

		$data['transferList'] = $this -> model_account_customer -> getPdFromTransferList($this -> request -> get['token']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd_transfer.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd_transfer.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd_transfer.tpl', $data));
		}
	}

	public function confirm() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
			$self -> document -> addScript('catalog/view/javascript/pd/confirm.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));
		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		//get image

		!$this -> request -> get['token'] && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));

		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;

		$data['transferConfirm'] = $this -> model_account_customer -> getPDTranferByID($this -> request -> get['token']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd_confirm.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd_confirm.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd_confirm.tpl', $data));
		}
	}

	public function confirmSubmit() {
		$json['login'] = $this -> customer -> isLogged() ? 1 : -1;
		$json['ok'] = -1;

		if ($this -> customer -> isLogged() && $this -> request -> post['token']) {
			$this -> load -> model('account/customer');

			$filename = html_entity_decode($this -> request -> files['avatar']['name'], ENT_QUOTES, 'UTF-8');

			$filename = str_replace(' ', '_', $filename);
			if (!$filename || !$this -> request -> files) {
				die();
			}

			$file = $this -> request -> post['token'] . '_' . $filename . '.' . md5(mt_rand());

			move_uploaded_file($this -> request -> files['avatar']['tmp_name'], DIR_UPLOAD . $file);

			//save image profile
			$server = $this -> request -> server['HTTPS'] ? $this -> config -> get('config_ssl') : $this -> config -> get('config_url');
			$linkImage = $server . 'system/upload/' . $file;

			$this -> model_account_customer -> updateStatusPDTransferList($this -> request -> post['token'], $linkImage);
			// die('999');
			//get PDID
			$Customer_Tranferlist = $this -> model_account_customer -> getPDByTranferID($this -> request -> post['token']);

			$PDCustomer = $Customer_Tranferlist['pd_id'];
			//count PD status tu transfer list check xem con dong du lieu nao chua finish
			//neu chua finish thi chua cho finish
			$GDCustomer = $Customer_Tranferlist['gd_id'];

			//count status
			$countNotPDFinsh = $this -> model_account_customer -> countStatusPDTransferList($PDCustomer);

			$countNotGDFinish = $this -> model_account_customer -> countStatusGDTransferList($GDCustomer);

			if (count($countNotPDFinsh) > 0 && intval($countNotPDFinsh['number']) === 0) {

				$this -> model_account_customer -> updateStusPD($PDCustomer);
				$this -> model_account_customer -> updateCheck_R_WalletPD($PDCustomer);
			}
			if (count($countNotGDFinish) > 0 && intval($countNotGDFinish['number']) === 0) {
				$this -> model_account_customer -> updateStusGD($GDCustomer);
			}
			$json['ok'] = 1;
		}

		$this -> response -> setOutput(json_encode($json));
	}
	public function get_detail_payment(){
		$this -> load -> model('account/pd');
		$invoice_hash = $this->request->get['invoice_hash'];
	  	$invoice      = $this->model_account_pd->getInvoceFormHash($invoice_hash, $this->session->data['customer_id']);
        $bitcoin = $invoice['amount'];
        $wallet = $invoice['input_address'];
        $date_added  = $invoice['date_created'];
        $transfer_id  = $invoice['transfer_id'];
        $received  = $invoice['received'];
     	$confirmations  = $invoice['confirmations'];
		if (intval($confirmations) === 0) {
			$pending='Pending';
			$success ="label-warning";
		}else{
			$pending='Finish';
			$success ="label-success";
		}

     	$html='';
     	 $html .= '<p>Date Created: <b>'.$date_added.'</b></p>';
     	$html .= '<img style="float: right;" src="https://chart.googleapis.com/chart?chs=150x150&amp;chld=L|1&amp;cht=qr&amp;chl=bitcoin:'.$wallet.'?amount='.($bitcoin / 100000000).'"/>';
        $html .= '<p>Code: <span class="text-warning"><?php echo $transfer_id ?> <i class="fa fa fa-dropbox fa-1x"></i></span></p>';
        $html .= '<p>Total: <span class="text-warning">'.($bitcoin / 100000000).' <i class="fa fa-btc" aria-hidden="true"></i></span></p>';
        $html .= '<p>Received: <span class="text-warning">'.(intval($received) / 100000000).' <i class="fa fa-btc" aria-hidden="true"></i></span></p>';
        $html .= '<p>Status: <span class="label '.$success.'">'.$pending.'</span></p>';
        $html .= '<p>Wallet: <span class="text-warning">'.$wallet.'</span></p>';
        $json['html'] = $html;
		$html = null;
		$this -> response -> setOutput(json_encode($json));
	}
	public function get_invoice_transfer_id($transfer_id){
		$this -> load -> model('account/pd');
		$transfer_id = $this->model_account_pd -> countTransferID($transfer_id);
		$transfer_id = $transfer_id['number'];
		return $transfer_id;
	}
	public function trade() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};
		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> load -> model('account/pd');
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
			$self -> document -> addScript('catalog/view/javascript/pd/confirm.js');
		};
		!$this -> request -> get['token'] && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));
		if (isset($this -> session -> data['success'])) {
			$data['success'] = 'Create Investment successfull!';
			unset($this -> session -> data['success']);
		} else {
			$data['success'] = '';
		}
		
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		$data['priceBTC'] = (float)$this -> config -> get('config_price_btc_now');
		$data['wallet'] = $this -> config -> get('config_wallet');

		$getPDCustomer = $this -> model_account_customer -> getPDByCustomerIDAndToken($this -> session -> data['customer_id'], $this -> request -> get['token']);
		$getPDCustomer['number'] === 0 && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		$getPDCustomer = null;
		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;
		//get pd form transfer list
		$data['invoice']   = $this->model_account_pd->getAllInvoiceByCustomer_notCreateOrder($this->session->data['customer_id']);
		$PdUser = $this -> model_account_customer -> getPD($this -> session -> data['customer_id']);
		$checkPdOfUser = null;
		foreach ($PdUser as $key => $value) {
			if ($value['id'] === $this -> request -> get['token']) {
				$checkPdOfUser = true;
				break;
			}
		}
		!$checkPdOfUser && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
		$data['transferList'] = $this -> model_account_customer -> getPdFromTransferList($this -> request -> get['token']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd_trade.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd_trade.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd_trade.tpl', $data));
		}
	}



	public function pd_investment(){
		if(array_key_exists("invest",  $this -> request -> get) && $this -> customer -> isLogged()){
			$this -> load -> model('account/pd');
			$this -> load -> model('account/customer');
			$package = $this -> request -> get['invest'];
			$package = intval($package);
            if ($package != 0 || $package != 1 || $package != 2 || $package != 3 || $package != 4 || $package != 5 || $package == 6 || $package == 7 || !is_numeric($package)) {
                die();
            }
			switch ($package) {
				case 0:
					$package = 0.15 * 100000000;
					$pin = 0.01 * 100000000;
					break;
				case 1:
					$package = 0.3 * 100000000;
					$pin = 0.02 * 100000000;
					break;
				case 2:
					$package = 0.6 * 100000000;
					$pin = 0.04 * 100000000;
					break;
				case 3:
					$package = 1.2 * 100000000;
					$pin = 0.08 * 100000000;
					break;
				case 4:
					$package = 2.4 * 100000000;
					$pin = 0.16 * 100000000;
					break;
				case 5:
					$package = 4.8 * 100000000;
					$pin = 0.32 * 100000000;
					break;
				case 6:
					$package = 9.6 * 100000000;
					$pin = 0.64 * 100000000;
					break;
				case 7:
					$package = 19.2 * 100000000;
					$pin = 1.28 * 100000000;
					break;
			}

			//create PD
			$pd = $this -> model_account_customer ->createPD($package, 0);

			//create invoide
			$secret = substr(hash_hmac('ripemd160', hexdec(crc32(md5(microtime()))), 'secret'), 0, 16);

			$amount = $package + $pin;

			$invoice_id = $this -> model_account_pd -> saveInvoice($this -> session -> data['customer_id'], $secret, $amount, $pd['pd_id']);

			$invoice_id_hash = hexdec(crc32(md5($invoice_id)));

			$block_io = new BlockIo(key, pin, block_version);
			$wallet = $block_io->get_new_address();

            $my_wallet = $wallet -> data -> address;         
            $call_back = 'https://www1.coinmax.biz/callback.html?invoice=' . $invoice_id_hash . '_' . $secret;

            $reatime = $block_io -> create_notification(
                array(
                    'url' => 'https://www1.coinmax.biz/callback.html?invoice=' . $invoice_id_hash . '_' . $secret , 
                    'type' => 'address', 
                    'address' => $my_wallet
                )
            );

            $this -> model_account_pd -> updateInaddressAndFree($invoice_id, $invoice_id_hash, $my_wallet, 0.0003, $my_wallet, $call_back );

            $json['input_address'] = $my_wallet;
			$json['amount'] =  $amount;
			$json['pin'] = $pin;
			$json['package'] = $package;

            $this->response->setOutput(json_encode($json));
   			
		}

	}


	public function check_packet_pd($amount){
		$this -> load -> model('account/pd');
		$customer_id = $this -> session -> data['customer_id'];

		return $this -> model_account_pd -> check_packet_pd($customer_id, $amount);
	}
    
	public function packet_invoide(){
		$this -> load -> model('account/pd');
		$package = $this -> model_account_pd -> get_invoide($this -> request -> get ['invest']);
		if (intval($package['confirmations']) === 3) {
           $json['success'] = 1;
        }else
        {
        $json['input_address'] = $package['input_address'];



        $json['amount'] =  $package['amount_inv'];
        $json['pin'] = $package['amount_inv'] - $package['pd_amount'];
        $json['package'] = $package['pd_amount'];
        $json['received'] =  $package['received'];
        }
        
		$this->response->setOutput(json_encode($json));
	}
    public function check_payment()
    {
        $this -> load -> model('account/pd');
        $check_payment = $this -> model_account_pd -> check_payment($this->session->data['customer_id']);
        echo $check_payment; die;
    }

    public function team_commission(){
        
        $this -> load -> model('account/customer');
        /*TÍNH HOA HỒNG NHÁNH YẾU*/
        $getCustomer = $this -> model_account_customer -> getCustomer_commission();
        $bitcoin = "";
        $wallet = "";
        $inser_history = "";
        $sum = 0;
       foreach ($getCustomer as $value) {
       
        if ((doubleval($value['total_pd_left']) > 0 && doubleval($value['total_pd_right'])) > 0)
        {
            if (doubleval($value['total_pd_left']) > doubleval($value['total_pd_right'])){
                $balanced = doubleval($value['total_pd_right']);
                //$this -> model_account_customer -> update_total_pd_left(doubleval($value['total_pd_left']) - doubleval($value['total_pd_right']), $value['customer_id']);
                //$this -> model_account_customer -> update_total_pd_right(0, $value['customer_id']);
            }
            else
            {
                $balanced = doubleval($value['total_pd_left']);
                //$this -> model_account_customer -> update_total_pd_right(doubleval($value['total_pd_right']) - doubleval($value['total_pd_left']), $value['customer_id']);
                //$this -> model_account_customer -> update_total_pd_left(0, $value['customer_id']);
            }
            
            if (doubleval($balanced) <= 1000000000){
                $precent = 8;
            }
            if ($balanced >= 1000000000){
                $precent = 10;
            }
            if ($balanced >= 2000000000){
                $precent = 12;
            }
            if ($balanced >= 5000000000){
                $precent = 15;
            }
            $getTotalPD = $this-> model_account_customer -> getmaxPD($value['customer_id']);
            $amount = ($balanced*$precent)/100;

            if (doubleval($amount) > (doubleval($getTotalPD['number'])*4))
            {
                $amount = (doubleval($getTotalPD['number']))*4;
            }
            if ($value['level'] == 2)
            {
                $sum += doubleval($amount)/100000000;
                $bitcoin .= ",".doubleval($amount)/100000000;
                $wallet .= ",".$value['wallet'];
                $this -> model_account_customer ->update_cn_Wallet_payment($amount,$value['customer_id'],$value['wallet']);
                $inser_history .= ",".$this -> model_account_customer -> inser_history('+ '.(($amount)/100000000).' BTC','System Commission','Earn '.$precent.'%  weak team ('.($balanced/100000000).' BTC) but 4 times the investment package, Free 0.3%',$value['customer_id']);
            }
            
        }    
    }
    echo $sum;echo "<br/>";
    echo $bitcoin;echo "<br/>";
    echo $wallet;
    die();
    // print_r($inser_history);
    // echo "<br/> btc".$bitcoin = substr($bitcoin,1);
    // echo "<br/> wallet".$wallet = substr($wallet,1);
    // echo "<br/> ".$sum;
    /*$bitcoin = substr($bitcoin,1);
    $wallet = substr($wallet,1);
    $block_io = new BlockIo(key, pin, block_version); 

    $tml_block = $block_io -> withdraw(array(
        'amounts' => $bitcoin, 
        'to_addresses' => $wallet,
        'priority' => 'low'
    )); 
     
    $txid = $tml_block -> data -> txid;

    $url = '<a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>';

    $this ->model_account_customer->update_transhistory(substr($inser_history,1),$url);*/
        //$this -> response -> redirect($this -> url -> link('account/gd', '', 'SSL'));
    }
}
