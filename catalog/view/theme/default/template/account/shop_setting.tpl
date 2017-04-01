<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="c-layout-page">
  <div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
      <div class="container">
          <div class="c-page-title c-pull-left">
              <h3 class="c-font-uppercase c-font-sbold">Update Information Shop</h3>
              <h4 class="">Setting shop</h4>
          </div>
          <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
              <li>
                  <a href="shop-customer-account.html">Home</a>
              </li>
              <li>/</li>
              <li class="c-state_active">Update Information Shop</li>
          </ul>
      </div>
  </div>
</div>
<div class="">
    <div class="c-content-box c-size-md">
        <div class="container">
            <form id="fr_update_shop" role="form" action="index.php?route=account/shop/update_shop" enctype="multipart/form-data">
                <div class="row">
                     <div class="col-md-12 text-center form-group">
                        <label for="exampleInputEmail1" >Logo Shop</label>
                        <div class="clearfix"></div>
                          <input type="text" value="<?php echo $get_shop_customer['logo'] ?>" class="form-control" style="display:none"  c-square c-theme" id="fieldID" name="logo" required minlenght="3" placeholder="Đường dẫn hình ảnh...">
                          <img style="margin-top: 10px; margin-bottom: 18px;" id="thumb_image" class="fancybox_image" src="<?php echo ($get_shop_customer['logo'] == "") ? "catalog/view/theme/default/images/notFound.png" : $get_shop_customer['logo']; ?>"> 
                          <span class="input-group-btn"> 
                              <a href="catalog/view/theme/default/kcfinder/browse.php?type=image" class="iframe-btn btn btn-default" type="button" onclick="openKCFinder()">
                                  Chose Logo
                              </a>
                          </span>
                      </div>
                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1" >Name Shop</label>
                        <input type="text" placeholder="Name Shop" class="form-control autonumber" name="name" id="ip_name_shop" value="<?php echo $get_shop_customer['name'] ?>" />
                        
                        <p class="error name_shop_error">Please enter the Name Shop!</p>
                    </div>
                  
                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1">Type of Shop</label>
                        
                        <select name="type_shop" id="ip_type_shop" class="form-control">
                          <?php foreach ($get_category_all as $key => $value) { 
                            $select = "";
                            if ($get_shop_customer['category_shop'] == $value['category_id'])
                              $select = "selected";
                          ?>
                          <option <?php echo $select ?> value="<?php echo $value['category_id'] ?>"><?php echo $value['title'] ?></option>
                          <?php } ?>
                        </select>
                        
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1">Short description Shop (No more than 120 characters)</label>
                        <textarea type="text" placeholder="Short description Shop" class="form-control autonumber" name="description" id="ip_description"><?php echo $get_shop_customer['description'] ?></textarea>
                        <p class="error description_error">Please enter the Short description Shop!</p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1">Address Shop</label>
                        <input type="text" placeholder="Enter A Location" id="ip_address_shop" class="form-control" autocomplete="off" name="address" value="<?php echo $get_shop_customer['address'] ?>" />  
                        <p class="error address_shop_error">Please enter the Address Shop!</p>
                    </div>

                    <div class="col-md-12">
                      <p class="detail_error"><b>Please click on the location on the map to get the address store! </b></p>
                      <div id="map_shop_update" style="height: 500px;">
                     </div>
                          
                    </div>
                    <input type="hidden" name="lat" id="lat_form" value="<?php  echo $get_shop_customer['lat'] ?>"/>
                    <input type="hidden" name="lng" id="lng_form" value="<?php  echo $get_shop_customer['lng'] ?>"/>
                
                  <br/>
                  <div class="clearfix"></div>
                  <div class="col-md-12 text-center" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-success c-btn-uppercase c-btn-bold">
                      <i class="fa fa-diamond"></i> Update Infomation Shop
                    </button>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>


<?php echo $self->load->controller('common/footer') ?>