<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Tạo hóa đơn</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Tạo hóa đơn</h3>
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
      <form id="register_thanhvien" action="index.php?route=pd/customer/submit_create_bill&customer_id=<?php echo $_GET['customer_id']; ?>&token=<?php echo $_GET['token'];?>" method="POST" role="form">

      <div class="col-md-6">
          <label for="">Thông tin tư vấn</label>
          <div class="funkyradio">
              <div class="funkyradio-primary">
                
                  <input value="Tình trạng ban đầu" <?php echo ($customer['thongtin']=="Tình trạng ban đầu") ? 'checked="true"' : "" ?> type="radio" name="thongtin" id="radio2" checked/>
                  <label for="radio2">Tình trạng ban đầu</label>
              </div>
              <div class="funkyradio-success">
                  <input value="Mong muốn" <?php echo ($customer['thongtin']=="Mong muốn") ? 'checked="true"' : "" ?> type="radio" name="thongtin" id="radio3" />
                  <label for="radio3">Mong muốn</label>
              </div>
              <div class="funkyradio-danger">
                  <input  value="Chỉ định" <?php echo ($customer['thongtin']=="Chỉ định") ? 'checked="true"' : "" ?> type="radio" name="thongtin" id="radio4" />
                  <label for="radio4">Chỉ định</label>
              </div>
          </div>
          <div class="form-group" style="margin-top: 6px;">
              <label for="">Dịch vụ</label>
              <select class="form-control" name="dichvu" id="dichvu">
                <option >Chọn dịch vụ</option>
                <?php foreach ($get_dichvu as $value) {
                  if ($value['name'] == $customer['dichvu']) $select = 'selected="selected"'; else $select = ''; 

                ?>
                  <option <?php echo $select ?> value="<?php echo $value['name'] ?>_<?php echo $value['price'] ?>"><?php echo $value['name'] ?></option>
                <?php } ?>
              </select>
          </div>
          <div class="form-group">
            <label for="">Giá tiền</label>
            <input type="text"  required="required" class="form-control" id="giatien" name="giatien" placeholder="Giá tiền" readonly="true" value="<?php echo number_format($customer['giatien']);?>">
          </div>
          <div class="form-group">
              <label for="">Ghi chú</label>
              <textarea style="height: 70px;" class="form-control" name="ghichu" value=""><?php echo $customer['ghichu'];?></textarea>
              
          </div>
          <div class="form-group">
          <label for="">Nhân viên làm</label>
          <select class="form-control" name="nhanvien">
            <option disabled="">Chọn Nhân viên</option>
            <?php foreach ($get_nhanvien as $value) { 
              if ($value['name'] == $customer['nhanvientao']) $select = 'selected="selected"'; else $select = ''; 

            ?>
              <option <?php echo $select ?> value="<?php echo $value['name'] ?>"><?php echo $value['name'] ?></option>
            <?php } ?>
            
          </select>
        </div>
        </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="">Họ tên</label>
          <input type="text" autocomplete="off" required="required" class="form-control" id="firstname" name="firstname" readonly="true" placeholder="Họ tên" value="<?php echo $customer['firstname'];?>">
        </div>
         <div class="form-group">
          <label for="">Ngày sinh</label>
          <input type="date" readonly="true"  required="required" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh" value="<?php echo date('Y-m-d',strtotime($customer['date_birth'])) ?>">
        </div>
        <div class="form-group">
          <label for="">Số điện thoại</label>
          <input type="text" readonly="true"  required="required" class="form-control" id="telephone" name="telephone" placeholder="Số điện thoại" value="<?php echo $customer['telephone'];?>">
        </div>
        <div class="form-group">
          <label for="">Địa chỉ</label>
          <input type="text" readonly="true"  required="required" class="form-control" id="address" name="address" placeholder="Địa chỉ" value="<?php echo $customer['address'];?>">
        </div>
         
        
        </div>
        
        <div class="clearfix"></div>
          <div class="col-md-12 text-center" style="margin-top: 20px;">
             <div class="form-group row">
                <button style="width: 40%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Tạo hóa đơn</button>
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
   if (location.hash !== '') {

      var hash = location.hash.replace("#","");
      hash = hash.split("-");
     
      if(hash.length === 5){
         if(!alertify.myAlert){
           alertify.dialog('myAlert',function factory(){
             return{
               main:function(message){
                 this.message = message;
               },
               setup:function(){
                   return { 
                     buttons:[{text: "Close", key:27/*Esc*/},{text: "<a href='index.php?route=pd/create/print_code&token=<?php echo $_GET['token'];?>' target='_blank'>Print</a>", key:27/*Esc*/}],

                   };
               },
               prepare:function(){
                 this.setContent(this.message);
               },
               build:function(){
                   var errorHeader = '<span class="fa fa-check-circle fa-2x" '
                   +    'style="vertical-align:middle;color:#e10000;">'
                   + '</span> Tạo thành công.';
                   this.setHeader(errorHeader);
               }
           }});
         }
         //launch it.
          var code = "<p>Mã code: "+hash[2]+"</p>";
         var investment = "<p>Gói đầu tư: "+hash[1]+" VNĐ</p>";
        
         var username = "<p>Họ tên: "+hash[0]+"</p>";
           var phone = "<p>Số điện thoại: "+hash[3]+"</p>";
         var address = "<p>Địa chỉ: "+hash[4]+"</p>";
         
         localStorage.setItem('code',code);
         localStorage.setItem('investment',investment);
         localStorage.setItem('username',username);
         localStorage.setItem('phone',phone);
         localStorage.setItem('address',address);
        
         //alertify.myAlert(code+investment+username+phone+address);
      } 

      
   }
   
</script>