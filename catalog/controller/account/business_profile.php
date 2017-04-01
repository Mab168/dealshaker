<?php
class ControllerAccountBusinessprofile extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/create_product.js');
		$this -> document -> addScript('catalog/view/javascript/profile/profile.js');
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("login.html");
		call_user_func_array("myConfig", array($this));
		
			
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
		
		$data['customer'] = $this -> model_account_customer -> getCustomer($this ->session ->data['customer_id']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/business_profile.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/business_profile.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/business_profile.tpl', $data));
		}
	}

	public function update_profile()
	{
		if ($this -> request ->post){
			$this->load->model('account/customer');
			$this -> model_account_customer -> update_profile($this -> request ->post);
			$file = $this -> avatar($this -> request -> files);
		}
	}


	public function avatar($file){
		$this->load->model('account/customer');
		

		$imagename = $_FILES['avatar']['name'];
		$size = $_FILES['avatar']['size'];
		
		$ext = strtolower($this->getExtension($imagename));
		
		
		$actual_image_name = time().".".$ext;
		$uploadedfile = $_FILES['avatar']['tmp_name'];
		$path = "system/upload/";
		$newwidth = 200;
		$filename = $this -> compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth);
		

		$server = $this -> request -> server['HTTPS'] ? $this -> config -> get('config_ssl') :  $this -> config -> get('config_url');
		
		$linkImage = $server.$filename;
		echo $linkImage;
		$this -> model_account_customer -> update_avatar($linkImage);

		
	}
	public function getExtension($str)
	{
		$i = strrpos($str,".");
		if (!$i)
		{
		return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}

	public function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
	{

		if($ext=="jpg" || $ext=="jpeg" )
		{
		$src = imagecreatefromjpeg($uploadedfile);
		}
		else if($ext=="png")
		{
		$src = imagecreatefrompng($uploadedfile);
		}
		else if($ext=="gif")
		{
		$src = imagecreatefromgif($uploadedfile);
		}
		else
		{
		$src = imagecreatefrombmp($uploadedfile);
		}

		list($width,$height)=getimagesize($uploadedfile);
		$newheight=($height/$width)*$newwidth;
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		$filename = $path.$newwidth.'_'.$actual_image_name.md5(mt_rand()); //PixelSize_TimeStamp.jpg
		imagejpeg($tmp,$filename,100);
		imagedestroy($tmp);
		return $filename;
		}
	
	public function shop() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/create_product.js');
			
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
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
		$pagination -> url = HTTPS_SERVER . '?route=account/business_profile/shop&page={page}';
		$data['product'] = $this -> model_account_customer -> getproductshop($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();


		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/profile_shop.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/profile_shop.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/profile_shop.tpl', $data));
		}
	}


	public function order() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/create_product.js');
			
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
		
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalorder_sell($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . '?route=account/business_profile/order&page={page}';
		$data['product'] = $this -> model_account_customer -> getproductorder_sell($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();


		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/profile_order.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/profile_order.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/profile_order.tpl', $data));
		}
	}

	public function orderbuy() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/shop/create_product.js');
			
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
		
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalorder_buy($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . '?route=account/business_profile/orderbuy&page={page}';
		$data['product'] = $this -> model_account_customer -> getproductorder_buy($this -> session -> data['customer_id'], $limit, $start);
		
		$data['pagination'] = $pagination -> render();


		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/profile_orderbuy.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/profile_orderbuy.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/profile_orderbuy.tpl', $data));
		}
	}


	public function shop_active() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
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
			$get_shop_customer = $this -> model_account_customer -> get_shop_customer($this-> session ->data['customer_id']);
			$shop_id = $get_shop_customer['id'];
			$this -> model_account_customer -> i_product_customer($this -> request -> post,$this-> session ->data['customer_id'],$shop_id);
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
    	$gach = "";
        $getSubcategory =  $this -> getCategories($parent_id);
        if (count($getSubcategory) > 0)
        {
        	
        	?> 
		     <?php
           foreach ($getSubcategory as $values) {
           	 $count_sub = $this -> getCategories($values['simple_blog_category_id']);
               ?>
                <option value="<?php echo $values['simple_blog_category_id'] ?>">
                    --<?php echo $values['name'] ?>
                    <?php $this -> getSubcategory($values['simple_blog_category_id']); ?>
                </option>
               <?php


            } 
            $gach .= "-";
            ?> <?php
        }
        
    }

    public function getCustomer($customer_id){
    	$this -> load -> model('account/customer');
    	return $this -> model_account_customer -> getCustomer($customer_id);
    }
}
