<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div id="content" class="container">
   <!-- <div class="counter-holder mt-25">
      <div class="row">
         <div class="col-md-9">
            <div class="row">
               <div class="col-sm-5 mt-10 mb-10">
                  <div class="row">
                     <div class="col-lg-4 font-black text-uppercase text-right mb-5">
                        Registered Businesses:
                     </div>
                     <div class="col-lg-8 color-blue-light font-black fs-35 lh-1">
                        <span class="counter-up"  data-value="21228"></span>
                     </div>
                  </div>
               </div>
               <div class="col-sm-7 mt-10 mb-10">
                  <div class="row">
                     <div class="col-lg-4 font-black text-uppercase text-right mb-5">
                        Individual Logged in users:
                     </div>
                     <div class="col-lg-8 color-blue-light font-black fs-35 lh-1">
                        <span class="counter-up"  data-value="141346"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3 hidden-sm hidden-xs">
            <a href="index.html">
            <img alt="Logo"
               src="catalog/view/theme/default/bundles/merchantsonedealsopen/img/logo-img-text-600dc25.png?201703131257"
               class="img-responsive center-block" width="165" />
            </a>
         </div>
      </div>
   </div> -->
<div class="row margin-top-20">
               <div class="col-xs-12 col-md-3 nav-0">
                  <nav class="home-sidebar badge-row icons-layout">
                     <div class="navbar navbar-default" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                           <span class="navbar-brand uppercase" data-toggle="collapse"
                              data-target="#bs-home-left-menu-collapse" aria-expanded="false">
                           categories
                           </span>
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                              data-target="#bs-home-left-menu-collapse" aria-expanded="false">
                           <span class="sr-only">
                           Toggle navigation
                           </span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           </button>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-home-left-menu-collapse">
                           <ul class="nav navbar-nav">
                                <?php $getCategories = $self -> getCategories(1);
                                $i = 0;
                                foreach ($getCategories as $value) {

                                $i++;
                                if ($i < 9) {
                            ?>
                                    <li>
                                     <a href="?route=account/product/product_category&categories=<?php echo $value['simple_blog_category_id'] ?>" itemprop="url">
                                     <i class="fa fa-tachometer" aria-hidden="true"></i>
                                     <!-- <i class="imoon categ-handmade-and-customized-items"></i> -->
                                        <?php echo $value['name'] ?> 
                                     <span class="badge"><?php echo $self -> count_product($value['simple_blog_category_id'])  ?></span>
                                     </a>
                                    </li>  
                                <?php 
                                    } }
                                ?>
                           </ul>
                        </div>
                     </div>
                  </nav>
               </div>
               <div class="col-xs-12 col-md-9">
                  <div class="row item-best">
                     <div class="col-lg-8">
                        <div class="owl-carousel">
                            <div class="item">
                               <img src="catalog/view/theme/default/images/thiet-ke-banner-quang-cao.jpg">
                            </div>
                            <div class="item">
                               <img src="catalog/view/theme/default/images/Top-banner_Tea-tree-1.jpg">
                            </div>
                            <div class="item">
                               <img src="catalog/view/theme/default/images/215.jpg">
                            </div>
                            <div class="item">
                               <img src="catalog/view/theme/default/images/banner-bosung-dinh-duong-1.jpg">
                            </div>
                            <div class="item">
                               <img src="catalog/view/theme/default/images/HIABELL-2-1.jpg">
                            </div>
                        </div>
                        <script type="text/javascript">
                           $('.owl-carousel').owlCarousel({
                            loop:true,
                            margin:10,
                            nav:true,
                            dots: false,
                            autoplay : true,
                            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                            responsive:{
                                0:{
                                    items:1
                                },
                                600:{
                                    items:1
                                },
                                1000:{
                                    items:1
                                }
                            }
                        })
                        </script>

                        
                     </div>
                     <?php if(count($getproduct_desc) > 0) { ?>
                     <div class="col-lg-4 info">
                        <?php $imgss = $self-> get_images_product($getproduct_desc['product_id']) ?>
                        <p class="">
                           <img alt="img-best-deal" style="max-height: 140px" class="img-responsive"
                           src="<?php echo $imgss['image']; ?>">
                        </p>
                        <h3 class="item-best-info-title">
                           <?php echo $getproduct_desc['name_product'] ?>
                        </h3>
                        <div class="price-item box-spacer-tb price-l-2 clearfix">
                           <div class="wrap-price fr">
                              <p class="number"><?php echo ($getproduct_desc['price_gdg']) ?> GDG</p>
                              <p class="plus text-center">+</p>
                              <p class="number"><?php echo ($getproduct_desc['price_btc']) ?> BTC</p>
                           </div>
                           <span class="text-price">GIÁ:</span>
                        </div>
                        <div class="">
                           <a href="" data-product_id="<?php echo $getproduct_desc['product_id'] ?>" class="add_wishlist btn btn-outline-danger btn-block">
                           <i class="fa fa-heart"></i> Thêm vào yêu thích
                           </a>
                           <a href="<?php echo $getproduct_desc['alias'] ?>"
                              class="btn btn-warning btn-block tetx-uppercase">
                           <i class="fa fa-eye"></i>
                           Chi tiết
                           </a>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
            <hr class="style-4"/>
<main>
   <ul class="row home-list category-list" itemscope="" itemtype="http://schema.org/ItemList">
      <?php foreach ($products as  $product) { ?>
      <li class="col-lg-3 col-md-4 col-sm-6 col-xs-12 home-list-item" itemprop="itemListElement">
         <figure class="thumbnail clearfix list-items-deals">
            <div class="img-box-list">
               <a href="<?php echo $product['alias']?>" class="text-center">
              
               <?php $img = $self-> get_images_product($product['product_id']) ?>
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
                           <p class="number"><?php echo ($product['price_btc']) ?> BTC</p>
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
      <?php } ?>
      <div class="product_append"></div>
</ul>
<?php if (count($products)>=16) { ?>
<input type="hidden" id="start_query" name="" value="20">
   <div id="loadMore-container" class="cbp-l-loadMore-button c-margin-t-60">
        <div style="    background-color: #14aad1; border-color: #14aad1; width: 100%; height: 42px; line-height: 30px; color: #fff" class="cbp-l-loadMore-link btn c-btn-square c-btn-border-2x c-btn-dark c-btn-bold c-btn-uppercase">
            <span id="load_panigation_ajax" class="cbp-l-loadMore-defaultText" >XEM THÊM</span>
            <span class="cbp-l-loadMore-loadingText" style="display: none;">ĐANG TẢI...</span>
        </div>
    </div>
<?php } ?>
</main>

<?php echo $self->load->controller('common/footer') ?>