<?php
class ControllerAccountProduct extends Controller {

	public function index() {

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
	

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/product_all.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/product_all.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/product_all.tpl', $data));
		}
	}
	
	public function product_category() {

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
		$data['categories'] = $this -> model_account_customer -> breadcrumb(intval($this -> request -> get['categories']));
		count($data['categories']) === 0 && $this -> response -> redirect("/login.html");

		$category = $this -> get_all_child($this -> request -> get['categories']);
		//echo $category;die;
		$data['product'] = $this -> model_account_customer-> getproduct_all_category(20, 0,$category);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/product_category.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/product_category.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/product_category.tpl', $data));
		}
	}

	public function product_search() {


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
		
		$name_product = $this -> request -> get['q'];
		
		//echo $category;die;
		$data['product'] = $this -> model_account_customer-> getproduct_all_namesearch(20, 0,$name_product);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/product_search.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/product_search.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/product_search.tpl', $data));
		}
	}


	public function product_details() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		$this -> document -> addScript('catalog/view/javascript/card/card.js');
		$this -> document -> addScript('catalog/view/javascript/product/product_details.js');
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
		}
		$part = explode('-', $parts[0]);
		$product_id = $part[count($part)-1];
		
		$get_product_id = $this -> model_account_customer -> get_product_id(intval($product_id));

		count($get_product_id) === 0 && die();

		$data['get_product_id'] = $get_product_id;

		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['self'] = $this;
	

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/shop_active.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/product_details.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/product_details.tpl', $data));
		}
	}
	public function get_shop_id($shop_id){
		$this -> load -> model('account/customer');
		return $get_shop_id = $this -> model_account_customer -> get_shop_id(intval($shop_id));
	}

	public function get_images_products($product_id){
		$this -> load -> model('account/customer');
		return $get_shop_id = $this -> model_account_customer -> get_images_products(intval($product_id));
	}

	public function comment_product(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};
		
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		if ($this -> request-> post){
			$num_start = intval($this -> request-> post['num_start']);
			$content = $this -> request-> post['content'];
			$product_id = intval($this -> request-> post['product_id']);
			$this -> model_account_customer -> i_comment_product($this -> session -> data['customer_id'],$product_id,$num_start,$content);

			$this -> model_account_customer -> set_rating_product_id($product_id);
			$json['complete'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}

	}

	public function get_rating_product_id($product_id){
		$this -> load -> model('account/customer');
		return $this -> model_account_customer -> get_rating_product_id($product_id);

	}

	public function breadcrumb($child_id)
	{
		$this -> load -> model('account/customer');
		$breadcrumb = $this -> model_account_customer -> breadcrumb($child_id);
		if ($breadcrumb['parent_id'] == 0)
		{
			
		}
		else
		{
			$this -> breadcrumb($breadcrumb['parent_id']);
		}
		?>
		<li><a href="?route=account/product/product_category&categories=<?php echo $breadcrumb['simple_blog_category_id'] ?>"><?php echo $breadcrumb['name']; ?></a></li>
		<?php
		//print_r($breadcrumb);
	}

	public function get_parent_child($child_id)
	{
		$parent = "";
		$this -> load -> model('account/customer');
		$breadcrumb = $this -> model_account_customer -> breadcrumb($child_id);
		
		/*if ($breadcrumb['parent_id'] != 0)
		{
			$parent = $this -> get_parent_child($breadcrumb['parent_id']);
			
		}
		else
		{
			return $breadcrumb['simple_blog_category_id'];

		}*/
		return $breadcrumb['simple_blog_category_id'];

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
        	?> <ul class="dropdown-menu drop-on-hover"> <?php
           foreach ($getSubcategory as $values) {
           	 $count_sub = $this -> getCategories($values['simple_blog_category_id']);
               ?>
               		
                <li class="dropdown  dropdown-submenu">

                    <a href="listing/products/handmade-and-customized-items/art.html" itemprop="url" class="overflow-hidden-nowrap">
                    
                    <?php echo $values['name'] ?>
	                    <?php if (count($count_sub) > 0) { ?>
	                    	<i class="fa fa-angle-right  fr fs-20 hidden-sm hidden-xs"></i>
	                    <?php } ?>
                    </a>

                    <?php $this -> getSubcategory($values['simple_blog_category_id']); ?>

                </li>
               
               <?php
            } 
            ?> </ul> <?php
        }
        
    }

    public function count_product($category_id)
    {
    	$category = $this -> get_all_child($category_id);
    	$this -> load -> model('account/customer');
		return  $this -> model_account_customer -> count_product($category);
    }

    public function get_images_product($product_id)
	{
		$this -> load -> model('account/customer');
		return $this-> model_account_customer -> get_images_product($product_id);
	}

	public function get_all_child($parent_id)
	{
		 
		$this -> load -> model('account/customer');
		$getCategories =  $this -> model_account_customer -> getCategories($parent_id);
		$category = $parent_id;
		foreach ($getCategories as $value) {
			//$category.= ",".$value['simple_blog_category_id'];
			$category.= ",".$this -> get_all_child($value['simple_blog_category_id']);
		}
		return $category;
	}

	public function add_product_wishlist()
	{
		$this -> load -> model('account/customer');
		
		if (!$this -> customer -> isLogged())
		{
			$json['login'] = -1;
			return $this -> response -> setOutput(json_encode($json));
		}
		else
		{
			$check_product_wishlist = $this -> model_account_customer -> check_product_wishlist(intval($this -> request -> post['product_id']));
			if ($check_product_wishlist == 0)
			{
				$this -> model_account_customer -> add_product_wishlist(intval($this -> request -> post['product_id']));	
			}
			
			$json['complete'] = 1;
			return $this -> response -> setOutput(json_encode($json));
		}
		
	}

	public function filter_product()
	{
		$products = array();
		$this -> load -> model('account/customer');
		

		//min max GDG
		$price_min_gdg = $this -> request -> get['deal_min_price_gdg'];
		$price_max_gdg = $this -> request -> get['deal_max_price_gdg'];
		if ($price_min_gdg && $price_max_gdg)
		{
			$products = $this -> model_account_customer -> getproduct_price_gdg(20,0,$price_min_gdg,$price_max_gdg);
		}
		
		// min max BTC
		$price_min_btc = $this -> request -> get['deal_min_price_btc'];
		$price_min_btc = $this -> request -> get['deal_max_price_btc'];
		if ($price_min_btc && $price_min_btc)
		{
			$products = $this -> model_account_customer -> getproduct_price_btc(20,0,$price_min_gdg,$price_max_gdg);
		}

		// order by
		
		$sort_order = $this -> request -> get['sort_order'];
		if ($sort_order){
			$products = $this -> model_account_customer -> getproduct_sort_order(20,0,$sort_order);
		}
		
		if (count($products) > 0) {
		foreach ($products as $value) { 
                     
            ?>
           
             <li class="col-sm-6" itemprop="itemListElement">
                <figure class="thumbnail clearfix list-items-deals">
                   <div class="img-box-list">
                    <?php $img = $this-> get_images_product($value['product_id']) ?>
                      <a href="<?php echo $value['alias'] ?>"
                         class="text-center">
                      <img src="<?php echo $img['image'] ?>" alt="img"
                         class="img-responsive center-block">

                         
                      </a>
                   </div>
                   <figcaption class="caption">
                      <div class="clearfix pt-10 pb-10">
                         <div class="col-sm-12">
                            <div class="wrap-title">
                               <h4 class="hs-c">
                                  <?php echo $value['name_product'] ?>
                               </h4>
                            </div>
                         </div>
                      </div>
                     
                      <div class="clearfix  pt-15 pb-15">
                         <div class="col-sm-12">
                            <div class="price-item">
                               <p class="fs-20 text-uppercase">
                                  Giá:
                               </p>
                               <p class="font-black">
                                  <span class="fs-20"><?php echo ($value['price_gdg']) ?> GDG</span>
                                  +
                                  <span class="fs-20"><?php echo ($value['price_btc']) ?> BTC</span>
                               </p>
                            </div>
                         </div>
                      </div>
                      
                   </figcaption>
                </figure>
                <div class="row">
                   <div class="col-sm-6 mb-5">
                      <a href="" data-product_id="<?php echo $value['product_id'] ?>" class="add_wishlist btn btn-outline-danger btn-block">
                     <i class="fa fa-heart"></i> Thêm vào yêu thích
                   </a>
                   </div>
                   <div class="col-sm-6 mb-5">
                      <a href="<?php echo $value['alias'] ?>"
                         class="btn btn-warning btn-block text-uppercase" role="button">
                      <i class="fa fa-eye fa-lg"></i>
                      Chi tiết
                      </a>
                   </div>
                </div>
             </li>
         <?php } } else
         { ?>

         	<h3 class="text-center">Không có sản phẩm</h3>

         	
        <?php }

	}



}
