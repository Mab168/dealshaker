<?php 
   $self -> document -> setTitle($lang['heading_title']); 
   echo $self -> load -> controller('common/header'); 
  // echo $self -> load -> controller('common/column_left'); 
   ?>

<section id="Page-title" class="Page-title-Style1">
    <div class="color-overlay"></div>
    <div class="container inner-img">
        <div class="row">
            <div class="Page-title">
                <div class="col-md-12 text-center">
                    <div class="title-text">
                        <h2 class="page-title">Quản lý F1</h2>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <div class="breadcrumb-trail breadcrumbs">
                        <span class="trail-begin"><a href="home.html">Home</a></span>
                        <span class="sep">/</span> <span class="trail-end">Quản lý F1</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container mt-100">
        <div class="row">
            <div class="col-sm-12">   

    <div class="h-main-content">
    <div class="container">
        <div class="row">
            
      <div class="">
        <div class="panel panel-info" style="border-color: #05aed5">
          <div class="panel-heading" style="background: #05aed5; ">
            <h3 style="color: #fff" class="panel-title">Refferals Link</h3>
          </div>
          <div class="panel-body" style="border: 1px solid #BDC3C7">
           <input style="width:100%;border:none;margin-top:15px;color: #1A2B51;font-size: 15px; padding-left: 20px;" readonly class="js-copytextarea"value="<?php echo HTTPS_SERVER.'register.html&token='.$customer['customer_code']; ?>" title="<?php echo HTTPS_SERVER.'register.html&token='.$customer['customer_code']; ?>">
                <br>
                <br>
             <button style="float: left; background: #05aed5" class="btn btn-default js-textareacopybtn">COPY Referral Link</button>
          </div>
        </div>
          <h4 class="page-title">Quản lý F1</h4>
                  <div id="no-more-tables">
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th class="text-center">No.</th>
                              <th>Username</th>
                              <!-- <th>Level</th> -->
                              <th>QR Code</th>
                              
                           </tr>
                        </thead>
                        <tbody>
                           <?php $count = 1; foreach ($refferals as $key => $value) { ?>
                           <tr>
                              <td data-title="<?php echo $lang['NO'] ?>." align="center"><?php echo $count ?></td>
                              <td data-title="<?php echo $lang['USERNAME'] ?>"><?php echo $value['username'] ?></td>
                              <!-- <td data-title="LEVEL">
                                 <?php echo "L".(intval($value['level']) - 1) ?>
                              </td> -->
                              <td data-title="<?php echo $lang['WALLET'] ?>" >
                                 
                                 <img src="https://chart.googleapis.com/chart?chs=75x75&chld=L|0&cht=qr&chl=bitcoin:<?php echo $value['wallet']; ?>">
                                 
                              </td>
                              
                           </tr>
                           <?php $count++; } ?>
                        </tbody>
                     </table>
                     <?php echo $pagination; ?>
                  </div>
               </div>
            </div>
     
</div>
</div>
</div>
</div>
</div>

<?php echo $self->load->controller('common/footer') ?>
<script type="text/javascript">

        var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

        copyTextareaBtn.addEventListener('click', function(event) {
          var copyTextarea = document.querySelector('.js-copytextarea');
          copyTextarea.select();

          try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
          } catch (err) {
            console.log('Oops, unable to copy');
          }
        });
        </script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').dataTable();
    } );
</script>