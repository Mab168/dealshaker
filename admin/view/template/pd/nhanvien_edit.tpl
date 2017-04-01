<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Cập nhập nhân viên</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel-body">
  
      <form id="register_dichvu" action="index.php?route=pd/nhanvien/submit_edit&id=<?php echo $_GET['id']; ?>&token=<?php echo $_GET['token']?>" method="POST" role="form">
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Họ tên</label>
          <input type="text" autocomplete="off" required="required" class="form-control" id="firstname" name="firstname" placeholder="Họ tên" value="<?php echo $get_nhanvien['name'];?>">
        </div>
         <div class="form-group">
          <label for="">Ngày sinh</label>
          <input type="date"  required="required" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh" value="<?php echo date('Y-m-d',strtotime($get_nhanvien['date_birthday']));?>">
        </div>
        <div class="form-group">
          <label for="">Số điện thoại</label>
          <input type="text"  required="required" class="form-control" id="telephone" name="telephone" placeholder="Số điện thoại" value="<?php echo $get_nhanvien['telephone'];?>">
        </div>
        <div class="form-group">
          <label for="">Địa chỉ</label>
          <input type="text"  required="required" class="form-control" id="address" name="address" placeholder="Địa chỉ" value="<?php echo $get_nhanvien['address'];?>">
        </div>
         
        
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Công việc</label>
            <input type="text"  required="required" class="form-control" id="congviec" name="congviec" placeholder="Công việc" value="<?php echo $get_nhanvien['congviec'];?>">
          </div>
          <div class="form-group">
            <label for="">Tiền lương</label>
            <input type="text"  required="required" class="form-control" id="tienluong" name="tienluong" placeholder="Tiền lương" value="<?php echo number_format($get_nhanvien['luong']);?>">
          </div>
         <div class="form-group">
          <label for="">Ngày làm</label>
          <input type="date"  required="required" class="form-control" id="ngaylam" name="ngaylam" placeholder="Ngày sinh" value="<?php echo date('Y-m-d',strtotime($get_nhanvien['ngaylam']));?>">
        </div>

          <div class="form-group">
              <label for="">Ghi chú</label>
              <textarea style="height: 40px;"  class="form-control" name="ghichu"><?php echo $get_nhanvien['ghichu'];?></textarea>
              
          </div>

        </div>
        <div class="clearfix"></div>
          <div class="col-md-12 text-center" style="margin-top: 20px;">
             <div class="form-group row">
                <button style="width: 40%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Cập nhập nhân viên</button>
              </div>
          </div>
      </form>
      
    </div>
</div>
<script type="text/javascript">
  $("#price").on('keyup', function(){
      var n = parseInt($(this).val().replace(/\D/g,''),10);
      $(this).val(n.toLocaleString());
  });

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