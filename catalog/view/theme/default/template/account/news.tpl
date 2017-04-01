<?php 
   $self -> document -> setTitle('NEWS'); 
   echo $self -> load -> controller('common/header'); 
   //echo $self -> load -> controller('common/column_left'); 
   ?>

   <div class="h-main-content">
    <div class="container">
        <div class="row">
        <div class="col-md-12" id="anouncenment">
        <h1 class="page-title">News</h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                </div>
              
                <div class="panel-body" style="min-height:335px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 15px;">
                          Updating...
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div> 
  </div>

</div>
<?php echo $self->load->controller('common/footer') ?>