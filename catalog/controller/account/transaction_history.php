<?php
class ControllerAccountTransactionHistory extends Controller {
	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/pd/pd.js');
		};
		
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }
		$data['base'] = $server;
        $data['self'] = $this;
        $this -> load -> language('account/personal');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$data['language']= $getLanguage;
		$language = new Language($getLanguage);
		$language -> load('account/transaction');

		$data['lang'] = $language -> data;


        $page = isset($this -> request -> get['p']) ? $this -> request -> get['p'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalHistory($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . 'transaction_history.html&p={page}';
		$data['histotys'] = $this -> model_account_customer -> getTransctionHistory($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/transaction_history.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/transaction_history.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/transaction_history.tpl', $data));
        }
	}
	public function referal() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			$self -> document -> addScript('catalog/view/javascript/pd/pd.js');
		};
		
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }
		$data['base'] = $server;
        $data['self'] = $this;
        $this -> load -> language('account/personal');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$data['language']= $getLanguage;
		$language = new Language($getLanguage);
		$language -> load('account/transaction');

		$data['lang'] = $language -> data;


        $page = isset($this -> request -> get['p']) ? $this -> request -> get['p'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalHistory_referal($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . 'referal_history.html&p={page}';
		$data['histotys'] = $this -> model_account_customer -> getTransctionHistory_referal($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/transaction_history_referal.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/transaction_history_referal.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/transaction_history_referal.tpl', $data));
        }
	}
}