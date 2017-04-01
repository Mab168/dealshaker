<?php  echo $self->load->controller('common/header'); ?>
<div class="wrap-bg-theme buy" style="background-image: url(catalog/view/theme/default/bundles/merchantsonedealsopen/img/themes/background_buydc25.jpg?201703131257)">
<section class="backgroud enter backgroud-1">
   <div class="wrap-form text-center">
      <div class="links-horizontal">
         <a href="login.html"
            class="btn-blueberry active links-horizontal-item">
         Log In
         </a>
         <a href="register.html"
            class="btn-blueberry links-horizontal-item">
         Sign Up
         </a>
      </div>
      <div class="container">
         <div class="row">
            <div class="form-box col-xs-10 col-md-5 col-lg-4 col-center login-form">
               <div class="form-box-top">
                  <h4 class="header">
                     Log In
                  </h4>
               </div>
               <form name="" action="login.html" method="post" class="form-lg-input form-horizontal">
                  <div class="form-group">
                     <div class=""></div>
                     <div class="col-sm-12">
                        <div class="input-group input-strict">
                           <span class="input-group-addon">
                           <i class="fa fa-user"></i>
                           </span>
                           <input type="text" id="_username" name="email" required="required" class="form-control" placeholder="Username" value="<?php echo $email; ?>" />                
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class=""></div>
                     <div class="col-sm-12">
                        <div class="input-group input-strict">
                           <span class="input-group-addon">
                           <i class="fa fa-lock"></i>
                           </span><input type="password" id="_password" name="password" required="required" class="form-control" placeholder="Password" value="<?php echo $password; ?>"/>                
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12">
                        <div class="input-group input-strict">
                           <span class="input-group-addon">
                           <i class="fa fa-check-square-o"></i>
                           </span>
                           <span class="input-group-captcha">
                              <span class="captcha-image"><?php
                               $ranStr = md5(microtime());
                               $ranStr = hexdec( crc32($ranStr));
                               $ranStr = substr($ranStr, 0, 6);
                               $_SESSION['cap_code'] = $ranStr;
                             ?>
                             <img class="img_capcha" style="float: left; height: 40px; width: 90px;" src="captcha_code.php"/>
                            </span>

                              <input type="text" id="captcha" name="capcha" required="required" class="form-control" placeholder="Capcha" />
                              <a class="captcha_reload" href="javascript:reload_captcha_58d6948470523();"><i class="fa fa-refresh"></i></a>            
                           </span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                    <?php if ($redirect) { ?>
                       <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                       <?php } ?>
                    
                    <?php if ($success) { ?>
                    <div class="text-success"><i class="fa fa-check-circle"></i>
                       <?php echo $success; ?>
                    </div>
                    <?php } ?>
                    <?php if ($error_warning) { ?>
                    <div class="text-warning"><i class="fa fa-exclamation-circle"></i>
                       <?php echo $error_warning; ?>
                    </div>
                    <?php } ?>
                    <div style="" class="remember-text-login forget-password-login remember-register-3"><a href="forgot.html"  class="forgot">Quên mật khẩu ?</a>
                  </div>
            </div>
         </div>
         <div class="form-group margin-bottom-0">
         <div class="">
         <button type="submit" data-login="login-btn"
            data-loading-text="Processing"
            class="btn-blueberry btn-submit">
         Log In
         </button>
         </div>
         </div>
         <input type="hidden" id="_token" name="_token" value="7i6qiFJvtoVdixfjDnrMiuLM1gw6emDXepREaFfprE4" /></form>
      </div>
   </div>
</section>
</div>
<!-- <section class="wrap-section">
   <div class="container">
      <div class="row">
         <div class="wrap-header text-center">
            <h2 class="section-header-cross-border">
               About
            </h2>
         </div>
      </div>
      <div class="flex flex-row-col">
         <div class="col-sm-6 desc-falf">
            <div class="wrap-item-descrpt">
               <h3 class="text-center">
                  What is Dealshaker?
               </h3>
               <p class="text-center">
                  DealShaker is a virtual advertising platform that empowers both merchant to
                  consumer and consumer to consumer product and service deal promotions. It provides an outlet for
                  promotion of goods and services in a combination of the new - age cryptocurrency OneCoin and
                  EUR/cash to the members of the rapidly expanding global network with more than 3 Million members -
                  OneLife
               </p>
               <p class="text-center pt-1">
                  <a href="../help-center/about.html" class="link-readmore-blue-light">
                  Read more >>>
                  </a>
               </p>
            </div>
         </div>
         <div class="col-sm-6 desc-falf">
            <div class="wrap-item-descrpt">
               <h3 class="text-center">
                  How can I sign up?
               </h3>
               <p class="text-center">
                  The DealShaker advertising platform is exclusive to the OneLife Network
                  members and OneCoin owners. You can ask an official OneLife representative about the OneLife Network
                  or register for FREE membership, in order to receive access to DealShaker. All OneLife members can
                  access www.dealshaker.com with their OneLife creadentials
               </p>
               <p class="text-center pt-1">
                  <a href="../help-center/faq.html" class="link-readmore-blue-light">
                  Read more >>>
                  </a>
               </p>
            </div>
         </div>
      </div>
   </div>
</section> -->



<?php echo $self->load->controller('common/footer') ?>