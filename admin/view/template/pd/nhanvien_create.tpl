<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Tạo Nhân viên</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Tạo Nhân viên</h3>
    </div>
    
    <div class="panel-body">
      <form id="register_dichvu" action="index.php?route=pd/nhanvien/submit_create&token=<?php echo $_GET['token']?>" method="POST" role="form">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Họ tên</label>
          <input type="text" autocomplete="off" required="required" class="form-control" id="firstname" name="firstname" placeholder="Họ tên">
        </div>
         <div class="form-group">
          <label for="">Ngày sinh</label>
          <input type="date"  required="required" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh">
        </div>
        <div class="form-group">
          <label for="">Số điện thoại</label>
          <input type="text"  required="required" class="form-control" id="telephone" name="telephone" placeholder="Số điện thoại">
        </div>
        <div class="form-group">
          <label for="">Địa chỉ</label>
          <input type="text"  required="required" class="form-control" id="address" name="address" placeholder="Địa chỉ">
        </div>
         
        
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Công việc</label>
            <input type="text"  required="required" class="form-control" id="congviec" name="congviec" placeholder="Công việc">
          </div>
          <div class="form-group">
            <label for="">Tiền lương</label>
            <input type="text"  required="required" class="form-control" id="tienluong" name="tienluong" placeholder="Tiền lương">
          </div>
         <div class="form-group">
          <label for="">Ngày làm</label>
          <input type="date"  required="required" class="form-control" id="ngaylam" name="ngaylam" placeholder="Ngày sinh">
        </div>

          <div class="form-group">
              <label for="">Ghi chú</label>
              <textarea style="height: 40px;" class="form-control" name="ghichu"></textarea>
              
          </div>

        </div>
        <div class="clearfix"></div>
          <div class="col-md-12 text-center" style="margin-top: 20px;">
             <div class="form-group row">
                <button style="width: 40%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Tạo Nhân viên</button>
              </div>
          </div>
      </form>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#tienluong").on('keyup', function(){
      var n = parseInt($(this).val().replace(/\D/g,''),10);
      $(this).val(n.toLocaleString());
  });

</script>
<?php echo $footer; ?>
