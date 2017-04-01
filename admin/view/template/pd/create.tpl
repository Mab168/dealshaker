<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Tạo khách hàng</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Tạo khách hàng</h3>
    </div>
    <?php 
      if (isset($_SESSION['success'])){?>
      <div class="alert alert-success">
        <strong>Tạo!</strong> thành công.
      </div>
    <?php } 
      unset($_SESSION['success']);
     ?>
    <div class="panel-body">
      <form id="register_thanhvien" action="<?php echo $action_upgrade; ?>" method="POST" role="form">
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
         <div class="form-group">
          <label for="">Nhân viên làm</label>
          <select class="form-control" name="nhanvien">
            <option disabled="">Chọn Nhân viên</option>
            <?php foreach ($get_nhanvien as $value) { ?>
              <option value="<?php echo $value['name'] ?>"><?php echo $value['name'] ?></option>
            <?php } ?>
            
          </select>
        </div>
          <div class="form-group">
              <label for="">Mã barcode</label>
              <input type="text"  required="required" readonly="" class="form-control" id="barcode" name="barcode" placeholder="Mã barcode">
              
          </div>
        </div>
        <div class="col-md-6">
          <label for="">Thông tin tư vấn</label>
          <div class="funkyradio">
              <div class="funkyradio-primary">
                  <input value="Tình trạng ban đầu" type="radio" name="thongtin" id="radio2" checked/>
                  <label for="radio2">Tình trạng ban đầu</label>
              </div>
              <div class="funkyradio-success">
                  <input value="Mong muốn" type="radio" name="thongtin" id="radio3" />
                  <label for="radio3">Mong muốn</label>
              </div>
              <div class="funkyradio-danger">
                  <input value="Chỉ định" type="radio" name="thongtin" id="radio4" />
                  <label for="radio4">Chỉ định</label>
              </div>
          </div>
          <div class="form-group" style="margin-top: 6px;">
              <label for="">Dịch vụ</label>
              <select class="form-control" name="dichvu" id="dichvu" required="">
                <option >Chọn dịch vụ</option>
                <?php foreach ($get_dichvu as $value) { ?>
                  <option value="<?php echo $value['name'] ?>_<?php echo $value['price'] ?>"><?php echo $value['name'] ?></option>
                <?php } ?>
              </select>
          </div>
          <div class="form-group">
            <label for="">Giá tiền</label>
            <input type="text"  required="required" class="form-control" id="giatien" name="giatien" placeholder="Giá tiền" readonly="true">
          </div>
          <div class="form-group">
              <label for="">Ghi chú</label>
              <textarea style="height: 70px;" class="form-control" name="ghichu"></textarea>
              
          </div>
          
        </div>
        <div class="clearfix"></div>
          <div class="col-md-12 text-center" style="margin-top: 20px;">
             <div class="form-group row">
                <button style="width: 40%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Tạo khách hàng</button>
              </div>
          </div>
      </form>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#dichvu').on('change',function(){
    var dichvu = $(this).val().split('_');
    dichvu = (dichvu[dichvu.length-1]);
    $('#giatien').val(numberWithCommas(dichvu));
  })
  function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}
</script>
<?php echo $footer; ?>
<style type="text/css" media="screen">
  ul#suggesstion-box li:hover {
    cursor: pointer;
    background-color: #E27225;
    color: #fff;
}
ul#suggesstion-box
{
    z-index: 99999;
    position: absolute;
    width: 95%;
}.alertify.ajs-resizable:not(.ajs-maximized) .ajs-dialog {
    min-width: 548px;
    min-height: 270px;
}
</style>

<script type="text/javascript">
$('#barcode').val('');
$('#register_thanhvien').on('submit',function(){
  if ($('#barcode').val() == "")
  {
    alert("Vui lòng nhập mã barcode");
    return false;
  }
})


function check_barcode(barcode){
  $.ajax({
    url : "index.php?route=pd/barcode/check_barcode&token=<?php echo $_GET['token']; ?>",
    type : "post",
    dataType:"html",
    data : {
        'barcode': barcode
    },
    success : function (result){
      if (result == 0)
      {
        $('#barcode').val('');
        $('#barcode').val(barcode);
        $('#barcode').attr('readonly','true');
      }
      else
      {
        alert("Mã barcode đã tồn tại");
      }
    }
  });
}

  $(document).scannerDetection({
    onComplete: function(barcode, qty){
      check_barcode(barcode);
      } 
  });
</script>