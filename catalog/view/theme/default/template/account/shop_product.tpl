<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
   <div class="container">
      <div class="left">
         <ol class="breadcrumb">
            <li class="first">        <a href="/">Trang chủ</a>        
            </li>
            
            <li class="active last">        <span>Cửa hàng của tôi</span>        
            </li>
         </ol>
      </div>
   </div>
</div>
<div id="content" class="container wrap-content">

    <div class="">
        <div class="c-content-panel">
                       
            <div class="c-body">
                <div class="c-content-tab-1">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="nav nav-tabs tabs-left c-font-uppercase c-font-bold" style="margin-bottom: 20px;">
                                <li class="active">
                                    <a href="#tab_16_1" data-toggle="tab" aria-expanded="true">Manager</a>
                                </li>
                                <li>
                                    <a href="#tab_16_2" data-toggle="tab" >Create</a>
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
                                                <th>TT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Giá</th>
                                                <th>Mô tả ngắn</th>
                                                <th>Thời gian đăng</th>
                                                <th style="width: 100px">Sự kiện</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($product as $value) { $i++;?>
                                            <tr>
                                                <th scope="row"><?php echo $i ?></th>
                                                <td><?php echo $value['name_product']  ?></td>
                                                <td>
                                                <?php $images = $self -> get_images_product($value['product_id']) ;
                                                    ?>
                                                    <img style="width: 100px;" src="<?php echo $images['image'] ?>"
                                               
                                                    
                                                </td>
                                                <td><?php echo number_format($value['price'])  ?> VNĐ</td>
                                                <td class="descript_ngan"><?php echo $value['descript_ngan']  ?></td>
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
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input onkeyup="reformatText(this)" type="text" class="form-control  c-square c-theme" name="input_giasp" id="input_giasp" placeholder="Nhập giá sản phẩm..." minlength="4" required>
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
                                                    <option value="">
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
                                            <button type="submit" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>

                                            <button type="reset" class="btn btn-default c-btn-square c-btn-uppercase c-btn-bold toggle_form_add_edit">Hủy</button>
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
                                            <label class="col-sm-3 control-label" for="input_tieude">Giá sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <input onkeyup="reformatText(this)" type="text" class="form-control  c-square c-theme" name="input_giasp" id="input_giasp" placeholder="Nhập giá sản phẩm..." minlength="4" required>
                                            </div>
                                        </div>   
                                           
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label" for="input_tieude">Danh mục sản phẩm:</label>
                                            <div class="col-sm-9"> 
                                                <select name="input_danhmuc" id="input_danhmuc" class="form-control  c-square c-theme" >
                                                    <?php foreach ($get_category_all as $key => $value) { ?>
                                                        <option value="<?php echo $value['category_id'];?>"><?php echo $value['title'];?></option>
                                                    <?php  } ?>
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
                                            <button type="submit" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>

                                            <button type="reset" class="btn btn-default c-btn-square c-btn-uppercase c-btn-bold toggle_form_add_edit">Hủy</button>
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



<?php echo $self->load->controller('common/footer') ?>