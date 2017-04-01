<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
    <div class="container">
       <div class="left">
          
       </div>
    </div>
 </div>
<div id="content" class="container wrap-content">
            <div class="row">
               <div class="col-xs-12 col-md-3">
                  <nav class="home-sidebar badge-row icons-layout">
                     <div class=" navbar navbar-default">
                        <div class="navbar-header">
                           <span class="navbar-brand uppercase" data-toggle="collapse"
                              data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                           categories
                           </span>
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                              data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                           <span class="sr-only">
                           Toggle navigation
                           </span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           </button>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                           <ul class="nav navbar-nav">
                            <?php 
                           // $parent_id = $self -> get_parent_child(0);
                            //var_dump($parent_id); die;
                            //print_r($parent_id);die;
                            $getCategories = $self -> getCategories(0);
                                $i = 0;
                                foreach ($getCategories as $value) {

                                $i++;
                                
                            ?>
                                    <li>
                                     <a href="?route=account/product/product_category&categories=<?php echo $value['simple_blog_category_id'] ?>" itemprop="url">
                                     <i class="fa fa-tachometer" aria-hidden="true"></i>
                                        <?php echo $value['name'] ?> 
                                     <span class="badge"><?php echo $self -> count_product($value['simple_blog_category_id'])  ?></span>
                                     </a>
                                    </li>  
                                <?php 
                                     }
                                ?>

                           </ul>
                        </div>
                     </div>
                  </nav>
                  <div class="filter-sidebar"
                     data-xhr-target="                        /xhr/listing/products/handmade-and-customized-items
                     ">
                     <div class="wrap-filter-title">
                        <h4>
                           Filters:
                        </h4>
                     </div>
                     <div id='active-filters-title' class="title hidden">
                        <span>Enabled Filters</span>
                     </div>
                     <ul class="list-unstyled" id="active-filters">
                     </ul>
                  </div>
                  <div class="filter-sidebar"
                     data-min-price-eur="0"
                     data-max-price-eur="990000"
                     data-min-price-one="0"
                     data-max-price-one="205129">
                     <div class="title"><span>Price Range</span></div>
                     <div class="slide-item">
                        <div>
                           Range: EUR:
                           <span data-min-price="min-price-eur"></span> EUR -
                           <span data-max-price="max-price-eur"></span> EUR
                        </div>
                        <div class="price-range mt-15 mb-20">
                           <div data-price-slider="price-eur"
                              data-price-start-min="0"
                              data-price-start-max="990000">
                           </div>
                        </div>
                     </div>
                     <div class="slide-item">
                        <div>
                           Range: ONE:
                           <span data-min-price="min-price-one"></span> ONE -
                           <span data-max-price="max-price-one">
                           </span> ONE
                        </div>
                        <div class="price-range mt-15">
                           <div data-price-slider="price-one"
                              data-price-start-min="0"
                              data-price-start-max="205129">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="filter-sidebar">
                     <div class="title">
                        <span>Delivery method</span>
                     </div>
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="styled"
                           data-filter="deal_delivery_method[]"
                           data-value="SOTNdBn6ESPsXm17lAqxBPOJLQLRmvXLqsC96Nz-O4k~">
                        <span>Self Organized Shipping</span>
                        </label>
                     </div>
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="styled"
                           data-filter="deal_delivery_method[]"
                           data-value="GjmRuDE6N-MUCdxtB*DFeOlAVLjXAROwTdMbf849zQU~">
                        <span>Redeem at Location</span>
                        </label>
                     </div>
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="styled"
                           data-filter="deal_delivery_method[]"
                           data-value="BDMMHWAQvBNlPm5KmMu*ys9CbNeebLZFEdi15GwjTXQ~">
                        <span>Online Service</span>
                        </label>
                     </div>
                  </div>
                  <div class="filter-sidebar">
                     <div class="title"><span>Type of business</span></div>
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="styled"
                           data-filter="deal_business_type[]"
                           data-value="FylvGt6Yyb6n*zTXcJHwjBawOY-w3QSZxF7rdUJLqhA~">
                        <span>Individual Re-Seller</span>
                        </label>
                     </div>
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="styled"
                           data-filter="deal_business_type[]"
                           data-value="W9kzudNdF*YLQujrnf53XMEL02a16-ES3qi1GRNQzGU~">
                        <span>Registered Business</span>
                        </label>
                     </div>
                  </div>
                 <!--  <script src="catalog/view/theme/default/bundles/merchantsonedealsopen/js/Listing/categoryFilterdc25.js?201703131257"></script>
                  <script>
                     Store.Listing.categoryFilter.init();
                  </script>       -->          
               </div>
               <div class="col-xs-12 col-md-9" id="results">
                  
                  <?php $self -> get_all_child(1); ?>
                  <ul class="row category-list" itemscope="" itemtype="">
                    <?php foreach ($product as $value) { 
                      //print_r($value);
                    ?>
                   
                     <li class="col-sm-6" itemprop="itemListElement">
                        <figure class="thumbnail clearfix list-items-deals">
                           <div class="img-box-list">
                            <?php $img = $self-> get_images_product($value['product_id']) ?>
                              <a href="<?php echo $value['alias'] ?>"
                                 class="text-center">
                              <!-- <span class="triangle red"></span>
                              <span class="badge-num">- 25%</span> -->
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
                              <!-- <div class="redeam-text text-center uppercase self-organized-shipping">
                                 Self Organized Shipping
                              </div> -->
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
                     <?php } ?>
                     
                    
                  </ul>
                 
               </div>
            </div>
         </div>
<?php echo $self->load->controller('common/footer') ?>