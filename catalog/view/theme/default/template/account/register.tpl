<?php
$self -> document -> setTitle('Register User');
 echo $self->load->controller('common/header')?>
 <div class="wrap-bg-theme buy" style="background-image: url(catalog/view/theme/default/bundles/merchantsonedealsopen/img/themes/background_buydc25.jpg?201703131257)">
<section class="backgroud enter backgroud-1">
   <div class="wrap-form text-center">
      <div class="links-horizontal">
         <a href="login.html"
            class="btn-blueberry links-horizontal-item">
         Log In
         </a>
         <a href="register.html"
            class="btn-blueberry active links-horizontal-item">
         Sign Up
         </a>
      </div>
      <div class="container">
        <div class="row">
           <div class="form-box col-sm-11 col-md-9 col-center registration-form">
              <div class="form-box-top">
                 <h4 class="header">
                    Sign up
                 </h4>
              </div>
         <form id="register-account" action="<?php echo $self -> url -> link('account/registers/confirmSubmit', '', 'SSL'); ?>" class="form-horizontal form-horizontal" method="post" novalidate="novalidate">
        
        <div class="row">
          <div class="col-sm-6">
            <label class="username icon" for="username">Username</label>
            
            <input placeholder="Your Username" class="form-control c-square c-theme" name="username" id="username" value="" data-link="<?php echo $actionCheckUser; ?>">
            <span id="user-error" class="field-validation-error" style="display: none;">
               <span>Please enter user name</span>
            </span>
        </div>

        <div class="col-md-6">
            <label class="username icon" for="fullname">Card/passport</label>
              <input placeholder="Citizenship Card/Passport No" class="form-control c-square c-theme" name="cmnd" id="cmnd" data-link="<?php echo $actionCheckCmnd; ?>">
            <span id="cmnd-error" class="field-validation-error" style="display: none;">
               <span id="CardId-error">The Citizenship card/passport no field is required.</span>
            </span>
        </div>
      </div>
          
      <div class="row">
        <div class="col-sm-6">
            <label class="username icon" for="fullname">Card/passport</label>
                <input placeholder="Citizenship Card/Passport No" class="form-control c-square c-theme" name="cmnd" id="cmnd" data-link="<?php echo $actionCheckCmnd; ?>">
              <span id="cmnd-error" class="field-validation-error" style="display: none;">
                 <span id="CardId-error">The Citizenship card/passport no field is required.</span>
              </span>
        </div>
        <div class="col-sm-6">
            <label class="email icon" for="emailaddress">Email Address</label>
              <input class="form-control c-square c-theme" placeholder="Email Address" name="email" id="email" data-link="<?php echo $actionCheckEmail; ?>">
            <span id="email-error" class="field-validation-error" style="display: none;">
               <span id="Email-error">Please enter Email Address</span>
            </span>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <label class="email icon" for="emailaddress">Phone Number</label>
              <input placeholder="Phone Number" name="telephone" class="form-control c-square c-theme"  id="phone" data-link="<?php echo $actionCheckPhone; ?>">
            <span id="phone-error" class="field-validation-error" style="display: none;">
               <span>Please enter Phone Number</span>
            </span>
        </div>
        <div class="col-md-6">
          <label class="password icon" for="username">Password</label>
                <input placeholder="Password For Login" class="form-control c-square c-theme"  id="password" name="password" type="password">
              <span id="password-error" class="field-validation-error" style="display: none;">
                 <span>Please enter password</span>
              </span> 
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <label class="" for="username">Retype Password</label>  
              <input placeholder="Repeat Password For Login" class="form-control c-square c-theme"  id="confirmpassword" type="password">
            <span id="confirmpassword-error" class="field-validation-error" style="display: none;">
               <span>Repeat Password For Login not correct</span>
            </span>
        </div>
        <div class="col-sm-6">
          <label class="bitcoin icon" for="username">Bitcoin Address</label>  
              <input id="BitcoinWalletAddress" class="form-control c-square c-theme"  placeholder="Bitcoin Wallet" data-link="<?php echo $actionWallet; ?>" name="wallet" type="text"/>
            <span id="BitcoinWalletAddress-error" style="display: none;" class="field-validation-error">
               <span></span>
            </span>
        </div>
      </div>

      <div class="clearfix"></div>
      <div class="col-md-12 text-center" style="margin-top: 30px;">
          <div class="morph-button morph-button-modal morph-button-modal-1 morph-button-fixed">
              <button type="submit" class="btn-blueberry btn-submit">Create an Account</button>
              
          </div>
          <div class="submit-ie text-center" style="display:none;">
              <input type=hidden name=agree value=1>
              <button type="submit" class="button blue arrow">Agree Terms and Signup</button>
          </div>
      </div>
          <div class="clearfix"></div>
        </form>
      </div>
      </div>
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
<script type="text/javascript">
   if (location.hash === '#success') {
      alertify.set('notifier','delay', 100000000);
      alertify.set('notifier','position', 'top-right');
      alertify.success('Create user successfull !!!');
   }
   
</script>
<?php echo $self->load->controller('common/footer')?>