<?php
class ControllerAccountDashboard extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
			$self -> load -> model('account/customer');

		};

		
		$this -> document -> addScript('catalog/view/javascript/home/richmarker-compiled.js');
		$this -> document -> addScript('catalog/view/javascript/home/markerclusterer_packed.js');
		$this -> document -> addScript('catalog/view/javascript/home/markerwithlabel.js');
		$this -> document -> addScript('catalog/view/javascript/home/home.js');
		$this -> document -> addScript('catalog/view/javascript/home/dashboard.js');
		
		//!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		
		$data['self'] = $this;

		$data['getproduct_desc'] = $this -> model_account_customer -> getproduct_desc();

		$data['shop'] = $this -> model_account_customer -> getproductshop_dashboard(20,0);

		$data['products'] = $this -> model_account_customer -> getproduct_all(20,0);
		
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/dashboard.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/dashboard.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/login.tpl', $data));
		}
	}
	
	public function get_images_product($product_id)
	{
		$this -> load -> model('account/customer');
		return $this-> model_account_customer -> get_images_product($product_id);
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

	public function load_product(){

		$this -> load -> model('account/customer');
		if ($this -> request -> post)
		{
			$start = intval($this -> request -> post['start']);
			//$category = $this -> request -> post['category'];
			$products = $this -> model_account_customer -> getproduct_all(4,$start+4);
			foreach ($products as  $product) { ?>
                <li class="col-lg-3 col-md-4 col-sm-6 col-xs-12 home-list-item" itemprop="itemListElement">
         <figure class="thumbnail clearfix list-items-deals">
            <div class="img-box-list">
               <a href="<?php echo $product['alias']?>" class="text-center">
              
               <?php $img = $this-> get_images_product($product['product_id']) ?>
               <img src="<?php echo $img['image'] ?>" alt="img"
                  class="img-responsive center-block">
               </a>
            </div>
            <figcaption class="caption">
               <div class="clearfix pt-10 pb-10">
                  <div class="col-sm-12">
                     <h4 class="hs-c" itemprop="name">
                        <?php echo $product['name_product'] ?>
                     </h4>
                  </div>
               </div>
               <!-- <div class="text-uppercase text-center redeam-text ">
                  <p>
                     Redeem at Location
                  </p>
               </div> -->
               <div class="clearfix  pt-10 pb-10">
                  <div class="col-sm-12">
                     <div class="price-item box-spacer-tb price-l-2 clearfix">
                        <div class="wrap-price fr">
                           <p class="number"><?php echo ($product['price_gdg']) ?> GDG</p>
                           <p class="plus text-center">+</p>
                           <p class="number"><?php echo ($product['price_BTC']) ?> BTC</p>
                        </div>
                        <span class="text-price">GIÁ:</span>
                     </div>
                  </div>
               </div>
            </figcaption>
         </figure>
         <div>
            <a href="" data-product_id="<?php echo $product['product_id'] ?>" class="add_wishlist btn btn-outline-danger btn-block">
            <i class="fa fa-heart"></i> Thêm vào yêu thích
            </a>
            <a href="<?php echo $product['alias']?>"
               class="btn btn-warning btn-block tetx-uppercase" role="button">
            <i class="fa fa-eye"></i>
            Chi tiết
            </a>
         </div>
      </li>
           <?php } 
		}
		
	}
}
