<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Tạo Dịch vụ</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Tạo Dịch vụ</h3>
    </div>
    
    <div class="panel-body">
      <form id="register_dichvu" action="index.php?route=pd/dichvu/submit_create&token=<?php echo $_GET['token']?>" method="POST" role="form">
      <div class="col-md-6 col-md-push-3">
        <div class="form-group">
          <label for="">Tên dịch vụ</label>
          <input type="text" autocomplete="off" required="required" class="form-control" id="firstname" name="name" placeholder="Tên dịch vụ">
        </div>
         
        <div class="form-group">
          <label for="">Giá tiền</label>
          <input type="text" required="required" class="form-control" id="price" name="price" placeholder="Giá tiền">
        </div>
         <div class="form-group" style="margin-top: 15px;">
            <button style="width: 100%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Tạo Dịch vụ</button>
          </div>
          </div>
      </form>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#price").on('keyup', function(){
      var n = parseInt($(this).val().replace(/\D/g,''),10);
      $(this).val(n.toLocaleString());
  });

</script>
<?php echo $footer; ?>
