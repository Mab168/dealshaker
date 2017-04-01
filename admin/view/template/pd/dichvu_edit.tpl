<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Dịch vụ</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel-body">
  
      <form id="register_dichvu" action="index.php?route=pd/dichvu/submit_edit&id=<?php echo $_GET['id']; ?>&token=<?php echo $_GET['token']?>" method="POST" role="form">
      <div class="col-md-6 col-md-push-3">
        <div class="form-group">
          <label for="">Tên dịch vụ</label>
          <input type="text" autocomplete="off" required="required" class="form-control" id="firstname" name="name" placeholder="Tên dịch vụ" value="<?php echo $get_dichvu['name'] ?>">
        </div>
         
        <div class="form-group">
          <label for="">Giá tiền</label>
          <input type="text"  required="required" class="form-control" id="price" name="price" placeholder="Giá tiền" value="<?php echo number_format($get_dichvu['price']) ?>">
        </div>
         <div class="form-group" style="margin-top: 15px;">
            <button style="width: 100%; margin: 0 auto;" style="margin-top: 25px; float: left;" type="submit" class="btn btn-primary">Lưu Dịch vụ</button>
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