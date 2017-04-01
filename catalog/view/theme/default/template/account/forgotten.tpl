<?php  echo $self->load->controller('common/header'); ?>
    <div class="container mb-80 mt-100">
        <div class="misc-wrapper">
            <div class="misc-content">
                <div class="container">
                    <div class="row" style="margin-bottom: 50px;">
                        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-3">
                            <div class="misc-box">

                                <h3 class="text-center text-uppercase pad-v mt-50">Quên mật khẩu</h3>
                                <div class="alert alert-info">
                                    <p class="">Vui lòng nhập Usernam để lấy lại mật khẩu!</p>
                                </div>
                                <form action="/forgot.html" method="post" class="forgot-form">
                                    <div class="form-group group-icon" style="margin-bottom: 10px; float: left; width: 100%">
                                        <input type="text" name="email" value="" id="input-email" placeholder="Username của bạn" id="input-password" class="form-control" />
                                        <span class=" icon-user text-muted icon-input"></span>
                                    </div>
                                     <?php
                                        $ranStr = md5(microtime());
                                        $ranStr = hexdec( crc32($ranStr));
                                        $ranStr = substr($ranStr, 0, 6);
                                        $_SESSION['cap_code'] = $ranStr;
                                      ?>
                                      <div class="form-group group-icon" style="margin-bottom: 10px; float: left; width: 100%">
                                       <img class="img_capcha" style="float: left; height: 35px;" src="captcha_code.php"/>
                                    <input style="width: 65%; margin-left: px; float: right" autocomplete="off" type="text" name="capcha" placeholder="Capcha" id="input-password" value="" class="form-control" />
                                        
                                    </div>
                                    <div class="clearfix">
                                        
                                        <button class="btn btn-sm btn-block btn-primary mt-20 pull-left" type="submit">Khôi phục</button>
                                    </div>
                                </form>
                                 <?php if ($error_warning) { ?>
               <div class="text-warning"><i class="fa fa-exclamation-circle"></i>
                  <?php echo $error_warning; ?>
               </div>
               <?php } ?>
                                <a class="mt-20 pull-left" href="<?php echo $back; ?>.html">Trở về</a>


                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
<?php echo $self->load->controller('common/footer') ?>