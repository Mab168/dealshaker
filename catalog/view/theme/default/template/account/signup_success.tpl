<?php echo $header; ?>
<!-- <style type="text/css">
   body.account-personal-add_customer{  background: #1f283a !important;
}body.account-personal-add_customer .panel{background: rgba(255,255,255,1)!important}
</style> -->
<div class="row">
   <div class="col-md-12 hidden-xs col-sm-12" style="">
     
          <div class="text-center">
            <div class="text-success">
              <h1>Register success</h1>
            </div>
          </div>
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