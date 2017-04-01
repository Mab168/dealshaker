<?php  echo $self->load->controller('common/header'); ?>
<div class="container mb-80 mt-100">
<div class="misc-content">
    <div class="container">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 mt-80">
                <div class="misc-header text-center" style="position: relative;">
                  
                </div>
                <div class="misc-box" style="margin-top: 50px;">   
                    <h4 class="text-center text-uppercase pad-v">Đăng kí tài khoản.</h4>
                     
                     <form id="register-account" action="<?php echo $self -> url -> link('account/personal/register_submit', '', 'SSL'); ?>" class="" method="post" novalidate="novalidate">
                       
                         <div class="form-group">
                             
                             <div class="group-icon">
                            <input type="hidden" name="node" value="<?php echo $self->request->get['token']; ?>">
                              <input class="form-control" placeholder="Username" name="username" id="username" value="" data-link="<?php echo $actionCheckUser; ?>">
                              <span id="user-error" class="field-validation-error" style="display: none;">
                                 <span>Vui lòng nhập Username</span>
                              </span>
                            <span class="icon-user text-muted icon-input"></span>
                             </div>
                        </div>
                        <div class="form-group group-icon">
                             <!-- <label class="text-muted" for="exampleInputPassword1">Password</label> -->
                             <div class="group-icon">
                              <input type="hidden" name="node" value="<?php echo $self->request->get['token']; ?>">
                              <input class="form-control" placeholder="Địa chỉ email" name="email" id="email" data-link="<?php echo $actionCheckEmail; ?>">
                              <span id="email-error" class="field-validation-error" style="display: none;">
                                 <span id="Email-error">Vui lòng nhập địa chỉ email</span>
                              </span>
                            
                             </div>
                        </div>
                         <div class="form-group group-icon" style="display: none;">
                             
                             <div class="group-icon">
                            <input class="form-control" placeholder="Phone Number" name="telephone" id="phone" data-link="<?php echo $actionCheckPhone; ?>">
                              <span id="phone-error" class="field-validation-error" style="display: none;">
                                 <span>Please enter Phone Number</span>
                              </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon" style="display: none;">
                             
                             <div class="group-icon">
                            <input class="form-control" placeholder="Citizenship Card/Passport No" name="cmnd" id="cmnd" data-link="<?php echo $actionCheckCmnd; ?>">
                           <span id="cmnd-error" class="field-validation-error" style="display: none;">
                              <span id="CardId-error">The Citizenship card/passport no field is required.</span>
                           </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon" style="display: none;">
                             
                             <div class="group-icon">
                            <select class="form-control" id="country" name="country_id">
                              <option value="">-- Choose your Country --</option>
                              <?php foreach ($country as $key=> $value) {?>
                              <option value="<?php echo $value['id'] ?>">
                                 <?php echo $value[ 'name'] ?>
                              </option>
                              <?php } ?>
                           </select>
                           <span id="country-error" class="field-validation-error" style="display: none;">
                              <span>The country field is required.</span>
                           </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon">
                             
                             <div class="group-icon">
                            <input class="form-control" placeholder="Mật khẩu đăng nhập" id="password" name="password" type="password">
                           <span id="password-error" class="field-validation-error" style="display: none;">
                              <span>Vui lòng nhập mật khẩu</span>
                           </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon">
                             
                             <div class="group-icon">
                           <input class="form-control valid" placeholder="Nhập lại mật khẩu" id="confirmpassword" type="password">
                           <span id="confirmpassword-error" class="field-validation-error" style="display: none;">
                              <span>Mật khẩu không trùng khớp</span>
                           </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon" style="display: none;">
                             <div class="group-icon">
                           <input class="form-control valid" name="transaction_password" placeholder="Password Transaction" id="password2" type="password">
                           <span id="password2-error" class="field-validation-error" style="display: none;">
                              <span>Repeat Password For Login not correct</span>
                           </span>
                            
                             </div>
                        </div>
                         <div class="form-group group-icon" style="display: none;">
                             <div class="group-icon">
                           <input class="form-control valid" placeholder="Reapeat Password Transaction" id="confirmpasswordtransaction" type="password">
                           <span id="confirmpasswordtransaction-error" class="field-validation-error" style="display: none;">
                              <span>Repeat Password For Login not correct</span>
                           </span>
                            
                             </div>
                        </div>
                        <div class="form-group group-icon">
                             
                             <div class="group-icon">
                           <input class="form-control" id="BitcoinWalletAddress" placeholder="Bitcoin Wallet" data-link="<?php echo $actionWallet; ?>" name="wallet" type="text"/>
                           <span id="BitcoinWalletAddress-error" style="display: none;" class="field-validation-error">
                              <span>Vui lòng nhập địa chỉ ví!</span>
                           </span>
                            
                             </div>
                        </div>

                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="checkbox">
                                    <label>
                                        
                                        <input id="agreeTerm" class="i-checks"  type="checkbox" value="true">
                                        <span>  Tôi đồng ý với các <a href="#">điều khoản</a></span></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                       <button style="margin: 0 auto;background: #05AED5;color: #fff" type="submit" class="btn btn-block btn-default">Đăng kí</button>
                       
                        
                    </form>
                </div>
                <div class="text-center misc-footer">
                    
                </div>
            </div>
         </div>
        </div>
      </div>
      </div>
<?php echo $self->load->controller('common/footer') ?>
