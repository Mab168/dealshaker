<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div id="content" class="container">
    <div class="row margin-top-20">
        <div class="col-xs-12 col-md-3">
           <nav class="home-sidebar badge-row">
              <div class=" navbar navbar-default">
                 <div class="navbar-header">
                    <span class="navbar-brand uppercase" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    categories
                    </span>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">
                    Toggle navigation
                    </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                 </div>
                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav">
                       <li >                <a href="?route=account/business_profile/">    Thông tin
                          </a>                            
                       </li>
                       <li class="active">                <a href="?route=account/business_profile/shop">Sản phẩm của tôi
                          </a>                            
                       </li>
                       
                       <li badge="0">                <a href="?route=account/business_profile/order">    Đơn hàng của tôi <!-- <span class="badge pull-right badge-danger badge-row ">1</span> -->
                          </a>                            
                       </li>
                      <li>                <a href="?route=account/business_profile/orderbuy">    Sản phẩm đã mua
                          <!-- <span class="badge pull-right badge-danger badge-row ">1</span> -->
                          </a>                            
                       </li>
                    </ul>
                 </div>
              </div>
           </nav>
        </div>


  <div class="col-xs-12 col-md-9">
   <div class="sub-section-header-border-bottom">
      <h3 class="header">Quản lý sản phẩm</h3>
   </div>
  
    <div class="">
        <div class="c-content-panel">
                       
            <div class="c-body">
                <div class="c-content-tab-1">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="nav nav-tabs tabs-left c-font-uppercase c-font-bold" style="margin-bottom: 20px;">
                                <li class="active">
                                    <a href="#tab_16_1" data-toggle="tab" aria-expanded="true">Quản lý</a>
                                </li>
                                <li>
                                    <a href="#tab_16_2" data-toggle="tab" >Tạo sản phẩm</a>
                                </li>
                                 <li style="display: none;">
                                    <a href="#tab_16_3" data-toggle="tab" >Edit</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="tab-content c-padding-sm">
                                <div class="tab-pane fade c-state_active in active" id="tab_16_1">
                                    <table class="table table-bordered show_product">
                                        <thead>
                                            <tr>
                                                <th class="text-center">TT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Giá GDG</th>
                                                <th>Giá BTC</th>
                                                
                                                <th>Thời gian</th>
                                                <th style="width: 100px">Sự kiện</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($product as $value) { $i++;?>
                                            <tr>
                                                <td class="text-center"><?php echo $i ?></td>
                                                <td><?php echo $value['name_product']  ?></td>
                                                <td>
                                                <?php $images = $self -> get_images_product($value['product_id']) ;
                                                    ?>
                                                    <img style="width: 100px;max-height: 60px;" src="<?php echo $images['image'] ?>"
                                               
                                                    
                                                </td>
                                                <td><?php echo ($value['price_gdg'])  ?> GDG</td>
                                                <td><?php echo ($value['price_btc'])  ?> BTC</td>
                                                <!-- <td class="descript_ngan"><?php echo $value['descript_ngan']  ?></td> -->
                                                <td><?php echo date('d/m/Y H:i', strtotime($value['date_added'] ))  ?></td>
                                                <td class="text-center">
                                                    <a href="" class="edit_product" data-id="<?php echo $value['product_id'] ?>">
                                                        <i class="fa fa-edit" data-toggle="tooltip" title="Sửa!" ></i>
                                                    </a>
                                                    <a href="" class="delete_product" data-id="<?php echo $value['product_id'] ?>">
                                                        <i class="fa fa-times-circle-o" data-toggle="tooltip" title="Xóa!"></i>
                                                    </a>
                                                   
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                    <?php echo $pagination ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_16_2">
                                    <form class="form_add_edit form_add form-horizontal form_submit_sanpham" id="form_submit_sanpham_add" action="index.php?route=account/shop/add_product" method="POST" data-action="add" name="myform" novalidate> 
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Tên sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" name="name_product" class="form-control  c-square c-theme" id="input_tieude" placeholder="Nhập tên sản phẩm..." minlength="4" required>
                                            </div>
                                        </div>   
                                       
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá GDG sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" class="form-control  c-square c-theme" name="input_giasp_gdg" id="input_giasp_gdg" placeholder="Nhập giá GDG sản phẩm..." minlength="1" required>
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá BTC sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" class="form-control  c-square c-theme" name="input_giasp_btc" id="input_giasp_btc" placeholder="Nhập BTC giá sản phẩm..." minlength="1" required>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Danh mục sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                            <select name="input_danhmuc" id="input_danhmuc" class="form-control  c-square c-theme">
                                                <?php 
                                                    $getCategories = $self -> getCategories(0);
                                                    foreach ($getCategories as $value) {
                                                        $count_sub = $self -> getCategories($value['simple_blog_category_id']);
                                                ?>
                                                    <option value="<?php echo $value['simple_blog_category_id'] ?>">
                                                        <?php echo $value['name'] ?> 
                                                    </option>
                                                       <?php echo $self -> getSubcategory($value['simple_blog_category_id']) ?>
                                                    
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                                <!-- <select name="input_danhmuc" id="input_danhmuc" class="form-control  c-square c-theme" >
                                                    <?php foreach ($get_category_all as $key => $value) { ?>
                                                        <option value="<?php echo $value['category_id'];?>"><?php echo $value['title'];?></option>
                                                    <?php  } ?>
                                                </select> -->
                                                
                                            </div>
                                        </div>                    
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="tinymce4_mota">Mô tả:</label>
                                            <div class="col-sm-9"> 
                                                <textarea class="form-control  c-square c-theme" id="tinymce4_mota_add" placeholder="Mô tả về sản phẩm..." name="descript_ngan" minlength="4" required ></textarea>
                                                <p class="error errot_mota">Vui lòng nhập mô tả</p>
                                            </div>
                                        </div>
                                        <div class="form-group clear_both">
                                            <label class="col-sm-3 control-label">Nội dung:</label>
                                            <div class="col-sm-9">
                                                <textarea  name="description" class="form-control editor input_noidung" id="tinymce4_noidung_add"  minlength="4" required></textarea> 
                                                <p class="error errot_noidung">Vui lòng nhập nội dung</p>                             
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group "> 
                                            <label class="col-sm-3 control-label">Hình ảnh:</label>
                                            <div class="col-sm-9" id="beforappen"> 
                                                <div class="add_append_img">
                                                    <a href="catalog/view/theme/default/kcfinder/browse.php?type=image" class="iframe-btn button_add_img" type="button" onclick="">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                                <div class="img_append"></div>
                                                <p class="error error-images">Vui lòng chọn hình ảnh</p>
                                            </div> 
                                            
                                        </div>         

                                        <div class="col-md-6 col-md-push-4 block_button_form">
                                            <button style="width: 130px;float: left; margin-right: 10px" type="submit" class="btn btn-warning btn-block ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>

                                            <button style="width: 130px;float: left;" type="reset" class=" btn btn-outline-danger toggle_form_add_edit">Hủy</button>
                                        </div>
                                    </form> 


                                    <div class="clearfix"></div>
                                </div>
                                <div class="tab-pane fade" id="tab_16_3">
                                    <form class="edit_product_from form_add_edit form-horizontal" id="form_submit_sanpham_edit" action="index.php?route=account/shop/edit_product" method="POST" data-action="edit" data-id="" name="myform" novalidate> 
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Tên sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" name="name_product" class="form-control  c-square c-theme" id="input_tieude" placeholder="Nhập tên sản phẩm..." minlength="4" required>
                                            </div>
                                        </div>   
                                       
                                         <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá GDG sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" class="form-control  c-square c-theme" name="input_giasp_gdg" id="input_giasp_gdg" placeholder="Nhập giá GDG sản phẩm..." minlength="1" required>
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá BTC sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input type="text" class="form-control  c-square c-theme" name="input_giasp_btc" id="input_giasp_btc" placeholder="Nhập BTC giá sản phẩm..." minlength="1" required>
                                            </div>
                                        </div>  
                                           
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Danh mục sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <select name="input_danhmuc" id="input_danhmuc" class="form-control  c-square c-theme">
                                                <?php 
                                                    $getCategories = $self -> getCategories(0);
                                                    foreach ($getCategories as $value) {
                                                        $count_sub = $self -> getCategories($value['simple_blog_category_id']);
                                                ?>
                                                    <option value="<?php echo $value['simple_blog_category_id'] ?>">
                                                        <?php echo $value['name'] ?> 
                                                    </option>
                                                       <?php echo $self -> getSubcategory($value['simple_blog_category_id']) ?>
                                                    
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                                
                                            </div>
                                        </div>                    
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="tinymce4_mota">Mô tả:</label>
                                            <div class="col-sm-9"> 
                                                <textarea class="form-control  c-square c-theme" id="tinymce4_mota_edit" placeholder="Mô tả về sản phẩm..." name="descript_ngan" minlength="4" required ></textarea>
                                                <p class="error errot_mota">Vui lòng nhập mô tả</p>
                                            </div>
                                        </div>
                                        <div class="form-group clear_both">
                                            <label class="col-sm-3 control-label">Nội dung:</label>
                                            <div class="col-sm-9">
                                                <textarea  name="description" class="form-control editor input_noidung" id="tinymce4_noidung_edit"  minlength="4" required></textarea> 
                                                <p class="error errot_noidung">Vui lòng nhập nội dung</p>                             
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group "> 
                                            <label class="col-sm-3 control-label">Hình ảnh:</label>
                                            <div class="col-sm-9" id="beforappen"> 
                                                <div class="add_append_img">
                                                    <a href="catalog/view/theme/default/kcfinder/browse.php?type=image" class="iframe-btn button_add_img" type="button" onclick="">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                                <div class="img_append"></div>
                                                <p class="error error-images">Vui lòng chọn hình ảnh</p>
                                            </div> 
                                            
                                        </div>         

                                        <div class="col-md-6 col-md-push-4 block_button_form">
                                            <button style="width: 130px;float: left; margin-right: 10px" type="submit" class="btn btn-warning btn-block ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>

                                            <button style="width: 130px;float: left;" type="reset" class="btn btn-outline-dangertoggle_form_add_edit">Hủy</button>

                                            
                                        </div>
                                    </form> 


                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
    </div>

<?php echo $self->load->controller('common/footer') ?>