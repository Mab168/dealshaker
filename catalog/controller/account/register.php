<?php
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		//method to call function
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));

		$this -> document -> addScript('catalog/view/javascript/register/register.js');

		
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;

		
		//end load country model

		//data render website
		$data['self'] = $this;

		//error validate
		$data['error'] = $this -> error;
		$data['p_binary'] = false;
		$data['has_register'] = false;

		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			$this -> load -> model('customize/register');
			$this -> load -> model('account/auto');
			$this -> load -> model('account/customer');
			$tmp = $this -> model_customize_register -> addCustomer_auto($this->request->post);
			$data['has_register'] = true;
			$cus_id= $tmp;
			$amount = 0;
	
			$checkC_Wallet = $this -> model_account_customer -> checkR_Wallet($cus_id);
			if(intval($checkC_Wallet['number'])  === 0){
				if(!$this -> model_account_customer -> insertR_WalletR($amount, $cus_id)){
					die();
				}
			}
			$this -> response -> redirect($this -> url -> link('account/register', '#success', 'SSL'));
			
		}

		$data['actionWallet'] = $this -> url -> link('account/personal/checkwallet', '', 'SSL');

		
		
		$data['actionCheckUser'] = $this -> url -> link('account/registers/checkuser', '', 'SSL');
		$data['actionCheckEmail'] = $this -> url -> link('account/registers/checkemail', '', 'SSL');
		$data['actionCheckPhone'] = $this -> url -> link('account/registers/checkphone', '', 'SSL');
		$data['actionCheckCmnd'] = $this -> url -> link('account/registers/checkcmnd', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/register.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/register.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/register.tpl', $data));
		}

	}

	public function checkuser() {
		if ($this -> request -> get['username']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitUserName($this -> request -> get['username'])) === 1 ? 1 : 0;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function checkemail() {
		if ($this -> request -> get['email']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitEmail($this -> request -> get['email'])) < 1 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}
	public function checkphone() {
		if ($this -> request -> get['phone']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitPhone($this -> request -> get['phone'])) < 1 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function checkcmnd() {
		if ($this -> request -> get['cmnd']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitCMND($this -> request -> get['cmnd'])) < 1 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function active(){
		$this -> load -> model('customize/register');
		$this->request->get['token'];
		$this->model_customize_register->update_code_active($this->request->get['token']);
		$this -> response -> redirect(HTTPS_SERVER . 'login.html#success');
	}
	public function signup_success(){
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$data['base'] = $server;

		if (isset($this -> session -> data['register_mail'])) {
			$data['register_mail'] = $this -> session -> data['register_mail'];

			unset($this -> session -> data['register_mail']);
		} else {
			$data['register_mail'] = '';
		}

		//end load country model

		//data render website
		$data['self'] = $this;


		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/signup_success.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/signup_success.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/signup_success.tpl', $data));
		}
	}

}
