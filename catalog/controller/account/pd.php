<?php
class ControllerAccountPd extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/pd/pd.js');
		};
		$this -> load -> model('account/customer');
        $this -> load -> model('account/pd');
		//method to call function
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

	   $get_all_type_lottery = $this -> model_account_customer -> get_all_type_lottery();
        foreach ($get_all_type_lottery as $key => $value) {
            $check_transfer_lottery = $this -> model_account_customer -> check_transfer_lottery($value['id']);
            if ($check_transfer_lottery['number'] == 0) $this -> model_account_customer -> in_transfer_lottery($value['type'],$value['rate'],$value['id']);
        }
		$data['get_date_lottery'] = $this -> model_account_customer -> get_thu_lottery();
       $data['self'] = $this;

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

	public function load_dai_lottery(){
        $mien_lottery = $this -> request -> post['mien_lottery'];
        $this->load->model('account/customer');
        $get_thu_lottery = $this -> model_account_customer -> get_thu_lottery();
        
        $get_domain_lottery = $this -> model_account_customer -> get_domain_lottery($get_thu_lottery['weekday'],$mien_lottery);
        foreach ($get_domain_lottery as $key => $value) {
        ?>
            <option value="<?php echo $value['id'] ?>"><?php echo  $value['name_lottery'] ?></option>
        <?php
        }

    }
    public function load_name_dai_lottery(){
        $id = $this -> request -> post['id'];
        $this->load->model('account/customer');
        $get_name_dai_lottery = $this -> model_account_customer -> get_name_dai_lottery($id);
        $this -> response -> setOutput(json_encode($get_name_dai_lottery));
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
        
        function myConfig($self)
        {
        	
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

        !array_key_exists('invoice_id_hash', $this->request->post) && die();
        $invoice_hash = $this->request->post['invoice_id_hash'];

        $invoice      = $this->model_account_pd->getInvoceFormHash($invoice_hash, $this->session->data['customer_id']);
        $getPD_lottery = $this -> model_account_pd -> getPD_lottery($invoice['transfer_id']);
       
          switch ($getPD_lottery['type_lottery']) {
              case 'baolo2':
                  $type_lottery = "Bao lô 2 con";
                  break;
              case 'baolo3':
                  $type_lottery = "Bao lô 3 con";
                  break;
              case 'dau2':
                  $type_lottery = "Đầu 2 con";
                  break;
              case 'dau3':
                  $type_lottery = "Đầu 3 con";
                  break;
              case 'duoi2':
                  $type_lottery = "Đuôi 2 con";
                  break;
              case 'duoi3':
                  $type_lottery = "Đuôi 3 con";
                  break;
              case 'cap2':
                  $type_lottery = "Cặp 2 con";
                  break;
              case 'cap3':
                  $type_lottery = "Cặp 3 con";
                  break;
          }
                                                           
        $json['input_address'] = $invoice['my_address'];            
        $json['package'] = $getPD_lottery['total_btc_danh'];
        $json['bet_numbers'] = $getPD_lottery['bet_numbers'];
        $json['type_lottery'] = $type_lottery;
        $json['ngay_danh'] = date('d/m/Y', strtotime($getPD_lottery['date_danh']));
        $json['domain_id'] = $this-> model_account_customer-> get_name_dai_lottery($getPD_lottery['domain_id'])['name_lottery'];
        $json['trung_1_con'] = $getPD_lottery['win_btc_number'];
        $json['danh_1_con'] = $getPD_lottery['btc_tren_number'];
        $json['token'] = $getPD_lottery['id'];
        $this->response->setOutput(json_encode($json));
    }

	public function callback() {
       
        $invoice_id = array_key_exists('invoice', $this -> request -> post) ? $this -> request -> post['invoice'] : "Error";
        $payment_code = array_key_exists('code', $this -> request -> post) ? $this -> request -> post['code'] : "Error";
        $tx_hash = array_key_exists('tx_hash', $this -> request -> post) ? $this -> request -> post['tx_hash'] : "Error";
        $payout_tx_hash = array_key_exists('payout_tx_hash', $this -> request -> post) ? $this -> request -> post['payout_tx_hash'] : "Error";
        $payout_service_fee = array_key_exists('payout_service_fee', $this -> request -> post) ? $this -> request -> post['payout_service_fee'] : "Error";
        $payout_miner_fee = array_key_exists('payout_miner_fee', $this -> request -> post) ? $this -> request -> post['payout_miner_fee'] : "Error";
        $this -> load -> model('account/pd');
        $this -> load -> model('account/auto');
        $this -> load -> model('account/customer');
        
        $invoice = $this -> model_account_customer -> getInvoiceByIdAndSecret($invoice_id, $payment_code);
        
        (count($invoice) === 0) && die;

        intval($invoice['confirmations']) >= 3 && die();

        $data = file_get_contents("https://bitaps.com/api/address/". $invoice['input_address']);
        $respond = json_decode($data); // Response array
        $received = doubleval($respond->received);
     /* echo $received; die;
$received = 11111001111;*/
        $this -> model_account_customer -> updateReceived($received, $payment_code);
        $this -> model_account_customer -> updateConfirm($payment_code,0,$tx_hash,$payout_tx_hash,$payout_service_fee,$payout_miner_fee);
        $invoice = $this -> model_account_customer -> getInvoiceByIdAndSecret($invoice_id, $payment_code);

        $received = intval($invoice['received']);
$received = 11111111111111;
        if ($received >= intval($invoice['amount'])) {
          $this -> model_account_customer -> updateConfirm($payment_code, 3,$tx_hash,$payout_tx_hash,$payout_service_fee,$payout_miner_fee);
            //$txt = $txs[0]->txid;
            
            //update PD
            $this -> model_account_pd -> updateStatusPD($invoice['transfer_id'], 1,$tx_hash);
        }

	}

	
	public function get_invoice_transfer_id($transfer_id){
		$this -> load -> model('account/pd');
		$transfer_id = $this->model_account_pd -> countTransferID($transfer_id);
		$transfer_id = $transfer_id['number'];
		return $transfer_id;
	}
	
	public function pd_investment(){
        if ($this -> customer -> isLogged())
        {  
            $this -> load -> model('account/pd');
            $this -> load -> model('account/customer');
            $check_pd_customer = $this -> model_account_customer -> check_pd_customer($this -> session -> data['customer_id']);
            if (intval($check_pd_customer) >=5)
            {
                $json['check_pd_customer'] = 1;
                $this->response->setOutput(json_encode($json));
                //die;
            }

            
            //if (intval($_POST['bet_rate']) != 50) if (intval($_POST['bet_rate']) != 400) die("22");

            if ($_POST['type_lottery'] == "baolo2" || $_POST['type_lottery'] == "baolo3" || $_POST['type_lottery'] == "dau2" || $_POST['type_lottery'] == "dau3" || $_POST['type_lottery'] == "duoi2" || $_POST['type_lottery'] == "duoi3" || $_POST['type_lottery'] == "cap2" )
            {

            } 
            else
            {
                die($_POST['type_lottery']);
            }

            $package = doubleval($this -> request ->post['total_btc_danh'])*100000000;
            $bet_rate = $this -> model_account_customer -> get_all_type_lottery_buy_type($_POST['type_lottery'])['rate'];
            if (intval($bet_rate) != intval($_POST['bet_rate'])) die();
            
            $amount = $package;
            
            $payout_address = "1EtyfHf6jLwH9exV97qPoMR7PMxZsttECV";
            $confirmations = 0;
            $fee_level = "low";
            $callback = urlencode("https://fundbtc.net/index.php?route=account/account/test_bitaps");
            $data = file_get_contents("https://bitaps.com/api/create/payment/". $payout_address. "/" . $callback . "?confirmations=" . $confirmations. "&fee_level=" . $fee_level);
            $respond = json_decode($data,true);
            $my_wallet = $respond["address"]; 
            $secret = $respond["payment_code"]; 
            $invoice_id_hash = $respond["invoice"];

            $_POST['id_tranfer'] = $this -> model_account_customer -> get_transfet_lottery($_POST['type_lottery'])['id'];
            $pd = $this -> model_account_customer ->createPD($_POST);

            $invoice_id = $this -> model_account_pd -> saveInvoice($this -> session -> data['customer_id'], $secret,$invoice_id_hash, $amount, $pd['pd_id'],$my_wallet,$callback);

            switch ($_POST['type_lottery']) {
                case 'baolo2':
                  $type_lottery = "Bao lô 2 con";
                  break;
              case 'baolo3':
                  $type_lottery = "Bao lô 3 con";
                  break;
              case 'dau2':
                  $type_lottery = "Đầu 2 con";
                  break;
              case 'dau3':
                  $type_lottery = "Đầu 3 con";
                  break;
              case 'duoi2':
                  $type_lottery = "Đuôi 2 con";
                  break;
              case 'duoi3':
                  $type_lottery = "Đuôi 3 con";
                  break;
              case 'cap2':
                  $type_lottery = "Cặp 2 con";
                  break;
              case 'cap3':
                  $type_lottery = "Cặp 3 con";
                  break;
            }
            $count_num =count(explode("-", $_POST['bet_numbers']));
            $this -> model_account_customer ->  saveHistory_lottery($this -> session -> data['customer_id'], 
              "Mua số đề", 
              "".($amount/100000000). " BTC", 
              "Mua ".$count_num." số ".$_POST['bet_numbers']." Với giá ".(round($amount/100000000/$count_num,8)). " BTC/con",
              $pd['pd_id'],
              $invoice_id,
              $type_lottery,
              $_POST['id_tranfer'], 
                '');

            $json['input_address'] = $my_wallet;            
            $json['package'] = $package;
            $json['bet_numbers'] = $_POST['bet_numbers'];
            $json['type_lottery'] = $type_lottery;
            $json['ngay_danh'] = date('d/m/Y', strtotime($_POST['ngay_danh']));
            $json['domain_id'] = $this-> model_account_customer-> get_name_dai_lottery($_POST['domain_id'])['name_lottery'];
            $json['danh_1_con'] = $_POST['btc_tren_number'];
            $json['trung_1_con'] = $_POST['win_btc_number'];
            $json['token'] = $pd['pd_id'];
        }
        else
        {
            $json['login'] = 1;
        }

		$this->response->setOutput(json_encode($json));
   
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
        $json['type_pd'] = $package['type_pd'];
        $json['amount_usd'] = $package['amount_usd'];
        $json['amount'] =  $package['amount_inv'];
        $json['package'] = $package['pd_amount'];
        $json['received'] =  $package['received'];
        }
        
		$this->response->setOutput(json_encode($json));
	}
    public function check_payment()
    {
        $this -> load -> model('account/pd');
        $check_payment = $this -> model_account_pd -> check_payment($this->session->data['customer_id']);
        $json['confirmations'] = $check_payment;
        $this->response->setOutput(json_encode($json));
    }

    public function check_confirm_btc(){
        $this -> load -> model('account/pd');
        $check_payment = $this -> model_account_pd -> check_confirm_btc(doubleval($_POST['token']));
        $this->response->setOutput(json_encode($check_payment));
    }
   
}
