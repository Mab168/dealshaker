<?php
class ControllerAccountCard extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};

		$this -> document -> addScript('catalog/view/javascript/card/card.js');
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		if (isset($_SESSION['card']) > 0 )
		{
			$data['card'] = $_SESSION['card'];
		}

		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
	

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/card.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/card.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/card.tpl', $data));
		}
	}

	public function get_product_id($product_id)
	{
		$this -> load -> model('account/customer');
		return $get_product_id = $this -> model_account_customer -> get_product_id(intval($product_id));
	}

	public function buy_now(){
		if ($this -> request -> post){
			if (empty($_SESSION['card']))
			{
				$_SESSION['card'][0]['product_id'] = $this -> request -> post['product_id'];
				$_SESSION['card'][0]['qty'] = $this -> request -> post['quantity']; 
			}
			else
			{
				$kq = 0;
				foreach ($_SESSION['card'] as $key => $value) {
					if ($value['product_id'] == $this -> request -> post['product_id'])
					{
						$_SESSION['card'][$key]['qty'] = $_SESSION['card'][$key]['qty'] + $this -> request -> post['quantity']; 
						$kq = 1;
						break;
					}
				}
				if ($kq == 0)
				{
					$key =count($_SESSION['card']);
					$_SESSION['card'][$key]['product_id'] = $this -> request -> post['product_id'];
					$_SESSION['card'][$key]['qty'] = $this -> request -> post['quantity']; 
				}
			}
			$this->response->redirect('index.php?route=account/card'); 

		}
	}

	public function add_to_card(){
		if ($this -> request -> get){
			if (empty($_SESSION['card']))
			{
				$_SESSION['card'][0]['product_id'] = $this -> request -> get['product_id'];
				$_SESSION['card'][0]['qty'] = 1; 
			}
			else
			{
				$kq = 0;
				foreach ($_SESSION['card'] as $key => $value) {
					if ($value['product_id'] == $this -> request -> get['product_id'])
					{
						$_SESSION['card'][$key]['qty'] = $_SESSION['card'][$key]['qty'] + 1; 
						$kq = 1;
						break;
					}
				}
				if ($kq == 0)
				{
					$key =count($_SESSION['card']);
					$_SESSION['card'][$key]['product_id'] = $this -> request -> get['product_id'];
					$_SESSION['card'][$key]['qty'] = 1; 
				}
			}
			//$this->response->redirect('index.php?route=account/card'); 

		}
	}


	public function remove_product()
	{
		if ($this -> request -> get){
			foreach ($_SESSION['card'] as $key => $value) {
				if ($value['product_id'] == $this -> request -> get['product_id'])
				{
					unset($_SESSION['card'][$key]);
				}
			}
		}
	}

	public function get_images_products($product_id){
		$this -> load -> model('account/customer');
		return $get_shop_id = $this -> model_account_customer -> get_images_products(intval($product_id));
	}

	
	
    public function get_images_product($product_id)
	{
		$this -> load -> model('account/customer');
		return $this-> model_account_customer -> get_images_product($product_id);
	}

	public function update_card()
	{
		if ($this -> request -> get){
			foreach ($_SESSION['card'] as $key => $value) {

					if ($value['product_id'] == $this -> request -> get['product_id'])
					{
						if ($this -> request -> get['number_product'] == 0)
						{
							unset($_SESSION['card'][$key]);
						}
						else
						{
							$_SESSION['card'][$key]['qty'] = $this -> request -> get['number_product']; 
						}
						
						break;
					}
				}
		}
	}

}
