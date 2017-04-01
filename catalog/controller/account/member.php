<?php
class ControllerAccountMember extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/shop_update.js');
		
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		
		$data['self'] = $this;
		$data['getCustomerbyCode'] = $this -> model_account_customer -> getCustomerbyCode(doubleval($this->request->get['member_id']));
		count($data['getCustomerbyCode']) === 0 && $this -> response -> redirect("/home.html");

		$data['get_shop_customer'] = $this -> model_account_customer -> get_shop_customer(doubleval($data['getCustomerbyCode']['customer_id']));

		$data['get_category_customer'] = $this -> model_account_customer -> get_category_customer(doubleval($data['getCustomerbyCode']['customer_id']));

		$data['rating_customer_id'] = $this -> model_account_customer -> get_rating_product_customer_id(doubleval($data['getCustomerbyCode']['customer_id']))['tbc_rating'];
		
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/member_shop.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/member_shop.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/member_shop.tpl', $data));
		}
	}
	
	public function get_product_category($category_id)
	{
		return $this -> model_account_customer ->get_product_category($category_id);
	}
	public function get_images_product($product_id)
	{
		$this -> load -> model('account/customer');
		return $this-> model_account_customer -> get_images_product($product_id);
	}


}
