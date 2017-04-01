<?php 
die();
$self -> document -> setTitle('Register User');
echo $header; ?>
<!-- <style type="text/css">
   body.account-personal-add_customer{  background: #1f283a !important;
}body.account-personal-add_customer .panel{background: rgba(255,255,255,1)!important}
</style> -->
<div class="row">
   <div class="col-md-8 hidden-xs col-sm-8" style="">
      <div class="background_img_over">
         <div class="background_child"></div>
          <img src="catalog/view/theme/default/images/coinmax.png" style="position:absolute; top: 25%; left: 30%;z-index: 9999" />
      </div>
   </div>
   <div class="col-md-4 col-sm-4"  style="padding: 0">
   
     
      <form id="register-account" action="<?php echo $self -> url -> link('account/personal/signup_submit', '', 'SSL'); ?>" class="form-horizontal" method="post" novalidate="novalidate">
      
         <input type="hidden" name="p_binary" value="<?php echo $p_binary ?>"/>
         <input type="hidden" name="postion" value="<?php echo $postion ?>">
        
         <div class="row">
            <div class="panel panel-default">
                <div class="heade-login text-center">
               <img src="catalog/view/theme/default/img/logo.png" alt="logo" style=" width:150px;">
            </div>
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                              <!-- <span class="input-group-addon">
                              <i class="fa fa-user email-icon login"></i>
                              </span> -->
                              
                              <input class="form-control" placeholder="Your Username" name="username" id="username" value="" data-link="<?php echo $actionCheckUser; ?>">
                           </div>
                           <span id="user-error" class="field-validation-error" style="display: none;">
                           <span>Please enter user name</span>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                             <!--  <span class="input-group-addon">
                              <i class="fa fa-envelope email-icon login"></i>
                              </span> -->
                             <!--  <input type="hidden" name="node" value="<?php echo $self->request->get['token']; ?>"> -->
                              <input class="form-control" placeholder="Email Address" name="email" id="email" data-link="<?php echo $actionCheckEmail; ?>">
                           </div>
                           <span id="email-error" class="field-validation-error" style="display: none;">
                           <span id="Email-error">Please enter Email Address</span>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                             <!--  <span class="input-group-addon">
                              <i class="fa fa-phone email-icon login"></i>
                              </span> -->
                             <input class="form-control" placeholder="Phone Number" name="telephone" id="phone" data-link="<?php echo $actionCheckPhone; ?>">
                           
                           </div>
                           <span id="phone-error" class="field-validation-error" style="display: none;">
                           <span>Please enter Phone Number</span>
                        </div>
                     </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                              <!-- <span class="input-group-addon">
                              <i class="fa fa-credit-card email-icon login"></i>
                              </span> -->
                            <input class="form-control" placeholder="Citizenship Card/Passport No" name="cmnd" id="cmnd" data-link="<?php echo $actionCheckCmnd; ?>">
                           
                           
                           </div>
                           <span id="cmnd-error" class="field-validation-error" style="display: none;">
                           <span id="CardId-error">The Citizenship card/passport no field is required.</span>
                           </span>
                        </div>
                     </div>
                     

                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                             <!--  <span class="input-group-addon">
                              <i class="fa fa-map-marker email-icon login"></i>
                              </span> -->
                           <select class="form-control" id="country" name="country_id">
                              <option value="">-- Choose your Country --</option>
                              <?php foreach ($country as $key=> $value) {?>
                              <option value="<?php echo $value['id'] ?>">
                                 <?php echo $value[ 'name'] ?>
                              </option>
                              <?php } ?>
                           </select>
                           
                           
                           
                           </div>
                           <span id="country-error" class="field-validation-error" style="display: none;">
                           <span>The country field is required.</span>
                           </span>
                        </div>
                     </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                              <!-- <span class="input-group-addon">
                              <i class="fa fa-lock password-icon"></i>
                              </span> -->
                            <input class="form-control" placeholder="Password For Login" id="password" name="password" type="password">
                          
                           
                           
                           </div>
                            <span id="password-error" class="field-validation-error" style="display: none;">
                           <span>Please enter password for login</span>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                              <!-- <span class="input-group-addon">
                              <i class="fa fa-lock password-icon"></i>
                              </span> -->
                            <input class="form-control valid" placeholder="Repeat Password For Login" id="confirmpassword" type="password">
                           
                           </div>
                           <span id="confirmpassword-error" class="field-validation-error" style="display: none;">
                           <span>Repeat Password For Login not correct</span>
                           </span>
                           
                        </div>
                     </div>
                     <div class="">
                        <div class="col-sm-12">
                            <input class="form-control" id="password2" placeholder="Transaction Password" name="transaction_password" type="hidden" value="123">
                          <span id="password2-error" class="field-validation-error" style="display: none;">
                           <span>Please enter transaction password</span>
                           </span>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-sm-12">
                           <input class="form-control valid" placeholder="Repeat Transaction Password" id="confirmpasswordtransaction" type="hidden" value="123">
                          <span id="confirmpasswordtransaction-error" class="field-validation-error" style="display: none;">
                           <span>Repeat Transaction Password is not correct</span>
                           </span>
                           </span>
                        </div>
                     </div>
   <div class="form-group">
                        <div class="col-sm-12">
                           <div class="input-group">
                             <!--  <span class="input-group-addon">
                              <i class="fa fa-bitcoin password-icon"></i>
                              </span> -->
                            <input class="form-control" id="BitcoinWalletAddress" placeholder="Bitcoin Wallet" data-link="<?php echo $actionWallet; ?>" name="wallet" type="text"/>
                                         
                          
                           </div>
                         <span id="BitcoinWalletAddress-error" class="field-validation-error">
                                          <span></span>
                                          </span>
                        </div>
                     </div>
            
                  </div>
                 
                  <div class="control-group form-group">
                     <div class="controls">
                        
                     </div>
                  </div>
                  <div class="text-center">
                     <div class="checkbox-inline">
                           <input id="agreeTerm" type="checkbox" value="true">
                           <label for="agreeTerm">Agree to our Terms and Condition</label>
                        </div>
                     <div id="success"></div>
                     <button type="submit" class="btn btn-primary">Register</button>
                  </div>
               
               </div>

            </div> <div class="text-center"><p>Copyrights © 2016 All Rights Reserved by Smart financial connections., Inc</p></div>
         </div>
         
      </form>
   </div>
</div>
<style type="text/css">
   footer, .header-logo{display: none !important;}
   .container{padding-top: 10px;}
</style>
<script type="text/javascript">
   if (location.hash === '#success') {
      alertify.set('notifier','delay', 100000000);
      alertify.set('notifier','position', 'top-right');
      alertify.success('Create user successfull !!!');
   }
   
</script>
<?php echo $footer; ?>