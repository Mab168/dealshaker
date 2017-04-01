<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="c-layout-page">
  <div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
      <div class="container">
          <div class="c-page-title c-pull-left">
              <h3 class="c-font-uppercase c-font-sbold">Information Shop </h3>
              <h4 class=""><?php echo $getCustomerbyCode['username'] ?></h4>
          </div>
          <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
              <li>
                  <a href="shop-customer-account.html">Home</a>
              </li>
              <li>/</li>
              <li class="c-state_active"><?php echo $getCustomerbyCode['username'] ?></li>
          </ul>
      </div>
  </div>
</div>
<div class="">
    <div class="c-content-box c-size-md">
        <div class="container">
          <div class="c-layout-sidebar-menu c-theme ">
             <ul class="c-sidebar-menu c-option-2 collapse infomation_shop" id="sidebar-menu-1">
                <li class="c-dropdown c-open" style="padding: 0px !important">
                    <a href="javascript:;">Thông tin cửa hàng</a>
                    <ul class="c-dropdown-menu">
                        <li class="text-center">
                          <img style="width: 70px;" src="<?php echo ($get_shop_customer['logo']) ?>">
                          <div class="clearfix"></div>
                          <p class="text-center rating">
                                <?php if ($rating_customer_id == 0 ) { ?>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 0 && $rating_customer_id <= 0.5) { ?>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 0.5 && $rating_customer_id <= 1) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 1 && $rating_customer_id <= 1.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 1.5 && $rating_customer_id <= 2) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 2 && $rating_customer_id <= 2.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    
                                <?php } ?>
                                <?php if ($rating_customer_id > 2.5 && $rating_customer_id <= 3) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 3 && $rating_customer_id <= 3.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    
                                <?php } ?>
                                <?php if ($rating_customer_id > 3.5 && $rating_customer_id <= 4) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($rating_customer_id > 4 && $rating_customer_id <= 4.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    
                                <?php } ?>
                                <?php if ($rating_customer_id > 4.5 && $rating_customer_id <= 5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                <?php } ?>
                                
                            </p>
                        </li>
                        <li class="c-onepage-link">
                            Username: <?php echo $getCustomerbyCode['username'] ?>
                        </li>
                        <li>
                            Email: <?php echo $getCustomerbyCode['email'] ?>
                        </li>
                        <li>
                            Số điện thoại: <?php echo $getCustomerbyCode['telephone'] ?>
                        </li>
                        <li>
                            Tên cửa hàng: <?php echo ($get_shop_customer['name']) ?>
                        </li>
                        <li>
                            Địa chỉ: <?php echo ($get_shop_customer['address']) ?>
                        </li>
                        <li>
                        Ngày tạo : <?php echo (date('d/m/Y' ,strtotime($get_shop_customer['date_added']))) ?>
                        </li>
                    </ul>
                </li>
              </ul>
          </div>
            

          <div class="c-layout-sidebar-content ">
            <div class="c-content-title-2">

              <?php foreach ($get_category_customer as $value) { ?>
                <h3 class="c-center c-font-uppercase"><?php echo $value['title'] ?></h3>
                <div class="c-line c-dot c-theme-bg c-theme-bg-after" style="margin-bottom: 20px;"></div>
                <div class="clearfix"></div>
                <div class="c-bs-grid-small-space">
                  <div class="row">
                <?php foreach ($self->get_product_category($value['category_id']) as $product) { ?>
                  <div class="col-md-3 col-sm-6 c-margin-b-20">
                        <div class="c-content-product-2 c-bg-white c-border">
                            <div class="c-content-overlay">
                                <div class="username_post pull-right">
                                    <i class="fa fa-user" aria-hidden="true"></i> <?php echo $product['username'] ?>
                                </div>
                                <!-- <div class="c-label c-bg-red c-font-uppercase c-font-white c-font-13 c-font-bold">Sale</div> -->
                            <?php  $date_added = date('d/m/Y',strtotime($product['date_added'])); 
                                if (date('d/m/Y') == $date_added) {
                            ?>
                                <div class="c-label c-label-right c-theme-bg c-font-uppercase c-font-white c-font-13 c-font-bold">New</div>
                            <?php } ?>
                                <div class="c-overlay-wrapper">
                                    <div class="c-overlay-content">
                                        <a href="<?php echo $product['alias']?>" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">Chi tiết</a>
                                    </div>
                                </div>
                                <div class="c-bg-img-center c-overlay-object text-center" data-height="height" >
                                <?php $img = $self-> get_images_product($product['product_id']) ?>
                                    <img style="height: 160px;" src="<?php echo $img['image'] ?>">
                                </div>
                            </div>

                            <div class="c-info">
                                <p class="c-title c-font-16 c-font-slim"><?php echo $product['name_product'] ?></p>
                                <p class="text-center rating">
                                <?php if ($product['rating'] == 0 ) { ?>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 0 && $product['rating'] <= 0.5) { ?>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 0.5 && $product['rating'] <= 1) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 1 && $product['rating'] <= 1.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 1.5 && $product['rating'] <= 2) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 2 && $product['rating'] <= 2.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    
                                <?php } ?>
                                <?php if ($product['rating'] > 2.5 && $product['rating'] <= 3) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 3 && $product['rating'] <= 3.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                    
                                <?php } ?>
                                <?php if ($product['rating'] > 3.5 && $product['rating'] <= 4) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-o"></i>
                                <?php } ?>
                                <?php if ($product['rating'] > 4 && $product['rating'] <= 4.5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star-half-o c-font-red"></i>
                                    
                                <?php } ?>
                                <?php if ($product['rating'] > 4.5 && $product['rating'] <= 5) { ?>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                    <i class="fa fa-star c-font-red"></i>
                                <?php } ?>
                                
                            </p>
                                <p class="c-price c-font-14 c-font-slim"><?php echo number_format($product['price']) ?> VNĐ
                                    
                                </p>
                            </div>

                            <div class="btn-group btn-group-justified" role="group">
                                <div class="btn-group c-border-top" role="group">
                                    <a href="<?php echo $product['alias']?>" class="btn btn-sm c-btn-white c-btn-uppercase c-btn-square c-font-grey-3 c-font-white-hover c-bg-red-2-hover c-btn-product">Chi tiết</a>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                <?php } ?>
                  <div class="clearfix"></div>
                  </div>
                </div>
              <?php } ?>
                
                
            </div>
          </div>
        </div>
    </div>
</div>


<?php echo $self->load->controller('common/footer') ?>