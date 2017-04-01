<?php
class ControllerAccountSetting extends Controller {
	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//data render website
		//start load country model
		$this -> load -> model('customize/country');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}
		$this -> load -> language('account/setting');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		
		$language -> load('account/setting');
		$data['lang'] = $language -> data;

		$data['base'] = $server;
		$data['self'] = $this;
		$data['banks'] = $this -> model_account_customer -> getCustomerBank($this -> session -> data['customer_id']);
		$data['customer'] = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);				

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/setting.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/setting.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/setting.tpl', $data));
		}

	}
	public function password_login() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//data render website
		//start load country model
		$this -> load -> model('customize/country');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}
		$this -> load -> language('account/setting');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		
		$language -> load('account/setting');
		$data['lang'] = $language -> data;

		$data['base'] = $server;
		$data['self'] = $this;
		$data['banks'] = $this -> model_account_customer -> getCustomerBank($this -> session -> data['customer_id']);
		$data['customer'] = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);				

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/password_login.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/password_login.tpl', $data));
		} else {

			$this -> response -> setOutput($this -> load -> view('default/template/account/password_login.tpl', $data));
		}

	}
	public function password_transaction() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//data render website
		//start load country model
		$this -> load -> model('customize/country');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}
		$this -> load -> language('account/setting');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		
		$language -> load('account/setting');
		$data['lang'] = $language -> data;

		$data['base'] = $server;
		$data['self'] = $this;
		$data['banks'] = $this -> model_account_customer -> getCustomerBank($this -> session -> data['customer_id']);
		$data['customer'] = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);				

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/password_transaction.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/password_transaction.tpl', $data));
		} else {
			
			$this -> response -> setOutput($this -> load -> view('default/template/account/password_transaction.tpl', $data));
		}

	}
	public function wallet() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//data render website
		//start load country model
		$this -> load -> model('customize/country');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}
		$this -> load -> language('account/setting');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		
		$language -> load('account/setting');
		$data['lang'] = $language -> data;

		$data['base'] = $server;
		$data['self'] = $this;
		$data['banks'] = $this -> model_account_customer -> getCustomerBank($this -> session -> data['customer_id']);
		$data['customer'] = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);				

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/wallet.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/wallet.tpl', $data));
		} else {
			
			$this -> response -> setOutput($this -> load -> view('default/template/account/wallet.tpl', $data));
		}

	}

	public function editpasswd() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
			$this -> load -> model('account/customer');

			$this -> model_account_customer -> editPasswordCustom($this -> request -> post['password']);

			$variableLink = $this -> url -> link('account/setting/password_login', '#success', 'SSL');

			$this -> response -> redirect($variableLink);
		}
	}

	public function edittransactionpasswd() {
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));
		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
			$this -> load -> model('account/customer');

			$this -> model_account_customer -> editPasswordTransactionCustom($this -> request -> post['transaction_password']);
			$variableLink = 'change-login-password.html#success';
			$this -> response -> redirect($variableLink);
		}
	}

	public function edit() {
		//not run for this function
		die();
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/setting/setting.js');
		};
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
			$this -> load -> model('account/customer');
			$this -> model_account_customer -> editCustomerCusotm($this -> request -> post);
			$variableLink = $this -> url -> link('account/setting', '', 'SSL') . '&success=account';
			$this -> response -> redirect($variableLink);
		}
	}

	public function account() {
		if ($this -> customer -> isLogged() && $this -> request -> get['id']) {
			$this -> load -> model('account/customer');
			$this -> response -> setOutput(json_encode($this -> model_account_customer -> getCustomerCustomFormSetting($this -> request -> get['id'])));
		}
	}

	public function banks() {
		if ($this -> customer -> isLogged() && $this -> request -> get['id']) {
			$this -> load -> model('account/customer');
			$this -> response -> setOutput(json_encode($this -> model_account_customer -> getCustomerBank($this -> request -> get['id'])));
		}
	}


	public function checkpasswdtransaction() {
		if ($this -> customer -> isLogged() && $this -> request -> get['pwtranction']) {
			$this -> load -> model('account/customer');
			$variable = $this -> model_account_customer -> getPasswdTransaction($this -> request -> get['pwtranction']);
			array_key_exists('number', $variable) && $this -> response -> setOutput(json_encode($variable['number']));
		}
	}

	public function checkpasswd() {
		if ($this -> customer -> isLogged() && $this -> request -> get['passwd']) {
			$this -> load -> model('account/customer');
			$variable = $this -> model_account_customer -> checkpasswd($this -> request -> get['passwd']);
			array_key_exists('number', $variable) && $this -> response -> setOutput(json_encode($variable['number']));
		}
	}

	public function updatewallet() {
		die();
		if ($this -> customer -> isLogged() && $this -> request -> get['wallet'] && $this -> request -> get['transaction_password']) {
			$json['login'] = $this -> customer -> isLogged() ? 1 : -1;
			$this -> load -> model('account/customer');
			$validate_address = $this -> check_address_btc($this -> request -> get['wallet']);
			if (intval($validate_address) === 1) {
				$json['wallet'] = 1;
			} else {
				$json['wallet'] = -1;
			}
			$variablePasswd = $this -> model_account_customer -> getPasswdTransaction($this -> request -> get['transaction_password']);
			$json['password'] = $variablePasswd['number'] === '0' ? -1 : 1;

			$json['ok'] = $json['login'] === 1 && $json['password'] === 1 && $json['wallet'] === 1 ? 1 : -1;
			$json['link'] = HTTPS_SERVER . 'index.php?route=account/setting#success';
			
			$json['login'] === 1 && $json['password'] === 1 && $json['wallet'] === 1 && $this -> model_account_customer -> editCustomerWallet($this -> request -> get['wallet']);
			$this -> response -> setOutput(json_encode($json));
		}
	}
	public function updatebanks() {
		$this -> load -> model('account/customer');
		$banks = $this -> model_account_customer -> getCustomerBank($this -> session -> data['customer_id']);

		if($banks['account_holder'] || $banks['bank_name'] || $banks['account_number'] || $banks['branch_bank'] ) {
			die();
		}

		if ($this -> customer -> isLogged() && $this -> request -> get['account_holder'] && $this -> request -> get['bank_name'] && $this -> request -> get['account_number'] && $this -> request -> get['branch_bank']) {
			$json['login'] = $this -> customer -> isLogged() ? 1 : -1;
			
			
			$json['ok'] = $json['login'] === 1 ? 1 : -1;
			$data = array(
					'account_holder' => $this -> request -> get['account_holder'],
					'bank_name' => $this -> request -> get['bank_name'],
					'account_number' => $this -> request -> get['account_number'],
					'branch_bank' => $this -> request -> get['branch_bank'],
				);
			$json['login'] === 1 && $this -> model_account_customer -> editCustomerBanks($data);
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function update_profile(){
		$this -> load -> model('account/customer');
		if ($this -> customer -> isLogged() && $this -> request -> get['username'] && $this -> request -> get['email'] && $this -> request -> get['telephone']) {
			$json['login'] = $this -> customer -> isLogged() ? 1 : -1;
			$json['ok'] = $json['login'] === 1 ? 1 : -1;
			$data = array(
					'username' => $this -> request -> get['username'],
					'email' => $this -> request -> get['email'],
					'telephone' => $this -> request -> get['telephone']
				);
			$json['login'] === 1 && $this -> model_account_customer -> editCustomerProfile($data);
			$json['link'] = HTTPS_SERVER . 'index.php?route=account/setting#success';
			
			$this -> response -> setOutput(json_encode($json));
			
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
			$json['success'] = intval($this -> model_customize_register -> checkExitEmail($this -> request -> get['email'])) < 11 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}
	public function checkphone() {
		if ($this -> request -> get['phone']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitPhone($this -> request -> get['phone'])) < 11 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}
			public function validate($address)
    {
        $decoded = $this->decodeBase58($address);
        $d1      = hash("sha256", substr($decoded, 0, 21), true);
        $d2      = hash("sha256", $d1, true);
        if (substr_compare($decoded, $d2, 21, 4)) {
            throw new Exception("bad digest");
        }
        
        return true;
    }
    
    public function decodeBase58($input)
    {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $out      = array_fill(0, 25, 0);
        for ($i = 0; $i < strlen($input); $i++) {
            if (($p = strpos($alphabet, $input[$i])) === false) {
                throw new Exception("invalid character found");
            }
            
            $c = $p;
            for ($j = 25; $j--;) {
                $c += (int) (58 * $out[$j]);
                $out[$j] = (int) ($c % 256);
                $c /= 256;
                $c = (int) $c;
            }
            
            if ($c != 0) {
                throw new Exception("address too long");
            }
        }
        
        $result = "";
        foreach ($out as $val) {
            $result .= chr($val);
        }
        
        return $result;
    }
    
    public function check_address_btc($address_btc)
    {
        $address         = $address_btc;
        $message = 1;
        try {
            $abc = $this->validate($address);
        }
        
        catch (Exception $e) {
            $message = -1;
            
            // $json['message'] = $e->getMessage();
            
        }
        
        // $this->response->setOutput(json_encode($json));
        return $message;

    }
}
