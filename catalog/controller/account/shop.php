<?php
class ControllerAccountShop extends Controller {

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
		$data['get_category_all'] = $this -> model_account_customer -> get_category_all();
		$data['get_shop_customer'] = $this -> model_account_customer -> get_shop_customer($this-> session ->data['customer_id']);
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/shop_setting.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/shop_setting.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/shop_setting.tpl', $data));
		}
	}
	
	public function shop_product() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/create_product.js');
			
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
		$data['get_category_all'] = $this -> model_account_customer -> get_category_all();
		$data['get_shop_customer'] = $this -> model_account_customer -> get_shop_customer($this-> session ->data['customer_id']);

		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalproduct_shop($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . '?route=account/shop/shop_product&page={page}';
		$data['product'] = $this -> model_account_customer -> getproductshop($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();


		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/shop_product.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/shop_product.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/shop_product.tpl', $data));
		}
	}

	public function shop_active() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
	

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/shop_active.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/shop_active.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/shop_active.tpl', $data));
		}
	}

	public function update_shop()
	{
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> post)
		{
			$this -> model_account_customer -> u_infomation_shop($this -> request -> post);
			$json['complete'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function add_product(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> post)
		{
			//print_r($this -> request -> post);die;
			/*$get_shop_customer = $this -> model_account_customer -> get_shop_customer($this-> session ->data['customer_id']);
			$shop_id = $get_shop_customer['id'];*/
			$this -> model_account_customer -> i_product_customer($this -> request -> post,$this-> session ->data['customer_id']);
			$json['complete'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function get_images_product($product_id)
	{
		$this -> load -> model('account/customer');
		return $this-> model_account_customer -> get_images_product($product_id);
	}

	public function get_product_id()
	{
		$this -> load -> model('account/customer');
		$json =  $this-> model_account_customer -> get_product_id(intval($this -> request-> post['product_id']));
		$images = $this-> model_account_customer -> get_images_products($this -> request-> post['product_id']);
		foreach ($images as $value) {
			$imgage['images'][] = $value['image'];
		}
		$array = array_merge($json,$imgage);
		$this -> response -> setOutput(json_encode($array));
	}

	public function edit_product(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> post)
		{
			//print_r($this -> request -> post);die;
			
			$this -> model_account_customer -> u_product_customer($this -> request -> post,$this-> session ->data['customer_id'],intval($this -> request -> post['product_id']));
			$json['complete'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function delete_product()
	{
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));

		if ($this -> request -> post)
		{
			$this -> model_account_customer -> de_product_customer($this-> session ->data['customer_id'],intval($this -> request -> post['product_id']));
			$json['complete'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function getCategories($parent_id)
	{
		$this -> load -> model('account/customer');
		return  $this -> model_account_customer -> getCategories($parent_id);
	}
	public function getSubcategory($parent_id)
    {

        $getSubcategory =  $this -> getCategories($parent_id);
        if (count($getSubcategory) > 0)
        {
        	
        	?> 
		     <?php
           foreach ($getSubcategory as $values) {
           	 $count_sub = $this -> getCategories($values['simple_blog_category_id']);
               ?>
                <option>
                    --<?php echo $values['name'] ?>
                    <?php $this -> getSubcategory($values['simple_blog_category_id']); ?>
                </option>
               <?php


            } 
            $gach .= "-";
            ?> <?php
        }
        
    }

}
