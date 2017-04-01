<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
   <div class="container">
      <div class="left">
         <ol class="breadcrumb">
            <li class="first">        <a href="">Trang chủ</a>        
            </li>
            <li>        <a href="">Sản phẩm</a>        
            </li>
           
            <li class="active last">        <span><?php echo $get_product_id['name_product'] ?></span>        
            </li>
         </ol>
      </div>
   </div>
</div>
<div id="content" class="container wrap-content">
            <!-- Product Details -->
            <div itemscope itemtype="http://schema.org/IndividualProduct">
               <div class="row">
                  <div class="col-xs-12 col-md-6 mb-25">
                     <div class="wrap-slide-view">
                       <!--  <span class="triangle red"></span>
                        <span class="badge-num">- 20%</span> -->
                        <div class="owl-destination mb-25 owl-carousel owl-theme  owl-theme-custom">


                            <?php 
                                $array_img = $self-> get_images_products($get_product_id['product_id']);
                                foreach ($array_img as $value) { ?>
                                <div class="deal-img item">
                                    <img src="<?php echo $value['image'] ?>"> 
                                </div>
                            <?php } ?>
                           
                        </div>
                     </div>
                     <div class="owl-navigation owl-carousel owl-theme">

                        <?php 
                            $array_img = $self-> get_images_products($get_product_id['product_id']);
                            foreach ($array_img as $value) { ?>
                             <div class="deal-img item">
                               <img src="<?php echo $value['image'] ?>" />
                            </div>
                        <?php } ?>
                       
                     </div>
                     <script>
                        var owl = $('.owl-destination');
                        var owl2 = $('.owl-navigation');
                        
                        /*
                         * Destination carousel
                         */
                        owl.owlCarousel({
                            nav: true,
                            navText: ['&#10092;', '&#10093;'],
                            dots: false,
                            autoHeight: false,
                            items: 1
                        }).on('changed.owl.carousel', function (event) {
                            owl2.trigger('to.owl.carousel', [event.item.index, 300, true]);
                            // (Optional) Remove .current class from all items
                            owl2.find('.current').removeClass('current');
                            // (Optional) Add .current class to current active item
                            owl2.find('.owl-item .item').eq(event.item.index).addClass('current');
                        });
                        
                        /*
                         * Navigation carousel
                         */
                        owl2.owlCarousel({
                            nav: false,
                            dots: false,
                            margin: 10,
                            items: 5
                        })
                                .on('click', '.owl-item', function (event) {
                                    owl.trigger('to.owl.carousel', [$(event.target).parents('.owl-item').index(), 0, true]);
                                });
                     </script>
                  </div>

                  <!-- End Product Details -->
                  <div class="col-xs-12 col-md-6">
                     <div class="deal-table-custom">
                        <h3 class="header"
                           itemprop="name"><?php echo $get_product_id['name_product'] ?></h3>
                        <!-- <div class="">
                           <p class="name-usr">
                              <span class="name-bs name-usr-item">
                              威克凯丽家纺2
                              </span>
                              <span class="color-blue name-usr-item">
                              xgyjh1215
                              </span>
                              <span class="name-usr-item">
                              </span>
                           </p>
                        </div> -->
                        <div class="">
                            <?php echo $get_product_id['descript_ngan'] ?>
                        </div>
                       <!--  <div class="">
                           <p class="name-usr table-item-overflow">
                              <span class="name-bs name-usr-item">
                              Individual business
                              </span>
                           </p>
                        </div> -->
                        <!-- <div class="category-list">
                           <div class="text-uppercase text-center redeam-text mb-10 mt-10 bg-dark "
                              itemprop="category">
                              Redeem at Location
                           </div>
                        </div> -->
                        <div class="border-top-lg box-spacer-tb">
                           <!-- <div class="wrap-table-row">
                              <div class="item-concrete-width">
                                 <span class="">Full Price/Value</span>
                              </div>
                              <div class="price-old">
                                 880.00 EUR
                              </div>
                           </div> -->
                           <div class="wrap-table-row">
                              <div class="item-concrete-width">
                                 <span class="">Giá bán</span>
                              </div>
                              <div class="price-new">
                                 <span class="color-red"><?php echo ($get_product_id['price_gdg']) ?> GDG</span><br>
                                 <span class="color-red"><?php echo ($get_product_id['price_btc']) ?> BTC</span>
                                 
                              </div>
                           </div>
                        </div>
                        <div class=" box-spacer-tb" itemprop="offers" itemscope
                           itemtype="http://schema.org/Offer">
                           <div class="wrap-carousel">
                            <div class="owl-carousel owl-theme carousel-location">
                               <div class="item-location">
                                  <h4 class="item-location-title">Thông tin người bán</h4>
                                  <address class="">
                                     <p>
                                        <i class="fa fa-map-marker"></i>
                                        Username: <b ><a style="color: #32c5d2" href="index.php?route=account/member&member_id=<?php echo $get_product_id['customer_code'] ?>"><?php echo $get_product_id['username'] ?></b></a>
                                     </p>
                                     <p>
                                        <i class="fa fa-globe"></i>
                                        Địa chỉ: <b><?php echo $get_product_id['address_cus'] ?></b>
                                        
                                     </p>
                                     <p>
                                        <i class="fa fa-phone"></i>
                                        
                                        Số điện thoại: <b><?php echo $get_product_id['telephone'] ?></b>
                                       
                                     </p>
                                     <p>
                                        <i class="fa fa-envelope"></i>
                                        
                                        Email: <b><?php echo $get_product_id['email'] ?></b>
                                        
                                     </p>
                                     <p>
                                        <i class="fa fa-btc"></i>
                                        
                                        Địa chỉ ví: <b><?php echo $get_product_id['wallet'] ?></b>
                                        
                                     </p>
                                     <p>
                                        <i class="fa fa-glide"></i>
                                        
                                        Username GDG: <b><?php echo $get_product_id['username_gdg'] ?></b>
                                        
                                     </p>
                                    
                                  </address>
                               </div>
                            </div>
                            <script>
                               var carousel_location = $(".carousel-location");
                               carousel_location.owlCarousel({
                                   loop: false,
                                   margin: 10,
                                   responsiveClass: true,
                                   pagination: false,
                                   navigation: false,
                                   dots :false,
                                   responsive: {
                                       0: {
                                           items: 1
                                       },
                                       600: {
                                           items: 1
                                       },
                                       1000: {
                                           items: 1,
                                           loop: false,
                                           margin: 19
                                       }
                                   }
                               });
                            </script>
                         </div>

                           
                        </div>
                        <!-- <div class="text-center">
                            <button style="margin: 0 auto; margin-bottom: 10px; height: 41px; font-size: 15px; width: 100%; background: #60af62; border: navajowhite;" type="submit" data-id="<?php echo $get_product_id['product_id'] ?>" class="add_to_card btn btn-danger btn-sm">Thêm vào giỏ hàng</button>
                        </div> -->
                        <div class="border-top-sm wrap-buy">
                          <form method="POST" action="?route=account/card/buy_now" style="width: 100%">
                             <div class="item-buy-qnt" style="float: left;">
                                <p class="inline-block">
                                   Số lượng
                                </p>
                                <input style="height: 33px;" type="number" value="1" 
                                   name="quantity"
                                   data-change-qty="true"
                                   max="200"
                                   data-price-quantity-limit="200"
                                   min="1"/>
                             </div>
                             <input type="hidden" name="product_id" value="<?php echo $get_product_id['product_id'] ?>">
                             <div class="item-buy-btn btn-coming-soon" style="float: left;">
                                <button type="submit" class="btn btn-danger btn-sm">Đặt mua ngay</button>
                                </a>
                             </div>
                           </form>
                        </div>
                        <div class="border-top-sm box-spacer-tb flex-space-between-center">
                           <div class="">
                              <a style="cursor: pointer;" class="add_wishlist btn-text red" data-product_id="<?php echo $get_product_id['product_id'] ?>" >
                              <i class="fa fa-heart"></i>
                              Thêm vào yêu thích
                              </a>
                              
                           </div>
                           <div class="social-links">
                           <?php $actual_link = HTTPS_SERVER.$_SERVER['REQUEST_URI'];

                            ?>
                              <span class="">Chia sẽ:</span>
                              <iframe
                                 src="https://www.facebook.com/plugins/share_button.php?href=<?php echo $actual_link?>"
                                 width="90"
                                 height="20"
                                 style="margin-bottom: -5px; border:none;overflow:hidden"
                                 scrolling="no"
                                 frameborder="0"
                                 allowTransparency="true">
                              </iframe>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12 col-md-12">
                     <div class="title text-center">
                        <span>Mô tả sản phẩm</span>
                     </div>
                  </div>
                  <div class="col-xs-12">
                     <div class="tab-content">
                        <div id="descriptionen"
                           <?php echo $get_product_id['description'] ?>
                        </div>
                     </div>
                  </div>
               </div>
               
              
            </div>
           
         </div>




<?php echo $self->load->controller('common/footer') ?>