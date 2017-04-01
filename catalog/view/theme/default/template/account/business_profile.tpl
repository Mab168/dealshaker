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
                       <li class="active">                <a href="?route=account/business_profile/">    Thông tin
                          </a>                            
                       </li>
                       <li >                <a href="?route=account/business_profile/shop">Sản phẩm của tôi
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
      <h3 class="header">Thông tin</h3>
   </div>
   <div class="row">
      <div class="col-md-12">
        <?php if ($customer['img_profile'] == "") { ?>
        <div class="alert alert-danger">
          <strong>Thông báo!</strong> Bạn vui lòng cập nhập đầy đủ thông tin.
        </div>
        <?php } ?>
        <div class="panel panel-info">

            <div class="panel-heading">
              <h3 class="panel-title">Cập nhập thông tin</h3>
            </div>
            <form id="update_profile" method="POST" action="index.php?route=account/business_profile/update_profile">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center">
                  <div class="" style="position: relative;">
                    <input type="file" id="file" name="avatar" style="position: absolute; width: 100%;
                      height: 270px; opacity: 0;left: 0;top: 0">

                    <img style="display: none;" id="blah" style="margin-top: 15px; width: 100%; height: 250px" id="thumb_image" class="fancybox_image img-circle img-responsive" src=""> 
                    <img class="img-circle img-responsive" id="old_img" style="margin-top: 15px; width: 100%; height: 250px" src="<?php echo ($customer['img_profile'] == "") ? HTTPS_SERVER.'catalog/view/theme/default/images/notFound.png' : $customer['img_profile']; ?>" />

                    <div class="error-file alert alert-dismissable alert-danger" style="display:none; margin:20px 0px;">
                                      <i class="fa fa-fw fa-times"></i>Please chosen image with : 'jpeg', 'jpg', 'png', 'gif', 'bmp'
                                  </div>       
                  </div>

                </div>
                <?php //print_r($customer); die; ?>
                <div class=" col-md-9 col-lg-9 "> 
                
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Tên đăng nhập</td>
                        <td><input readonly="true" type="text" class="form-control" name="username" value="<?php echo $customer['username'] ?>" ></td>
                      </tr>
                      <tr>
                        <td>Ngày sinh</td>
                        <td><input type="date" class="form-control" name="date_birth" id="date_birth" value="<?php echo date('Y-m-d',strtotime($customer['date_birth'])) ?>"></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><input type="text" class="form-control" id="email" name="email" value="<?php echo $customer['email'] ?>"></td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td>Số điện thoại</td>
                        <td><input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $customer['telephone'] ?>"></td>
                      </tr>
                        <tr>
                        <td>Giới tính</td>
                        <td><input type="text" class="form-control" id="male" name="male" value="<?php echo $customer['male'] ?>"></td>
                      </tr>
                      <tr>
                        <td>Địa chỉ</td>
                        <td><input type="text" class="form-control" id="address_cus" name="address_cus" value="<?php echo $customer['address_cus'] ?>"></td>
                      </tr>
                        <td>Ví Blockchain</td>
                        <td><input type="text" class="form-control" id="wallet" name="wallet" value="<?php echo $customer['wallet'] ?>">
                        </td>
                           
                      </tr>
                      </tr>
                        <td>Tên đăng nhập GDG</td>
                        <td><input type="text" class="form-control" id="username_gdg" name="username_gdg" value="<?php echo $customer['username_gdg'] ?>">
                        </td>
                           
                      </tr>
                    </tbody>
                  </table>
                  <div class="text-center">
                    <button type="submit"  class="btn btn-primary">Cập nhập thông tin</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
      </div>
   </div>
</div>
    </div>


</div>


<?php echo $self->load->controller('common/footer') ?>