<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Dịch vụ</h1>

  </div>
</div>  
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Dịch vụ</h3><a href="index.php?route=pd/dichvu/create&token=<?php echo $_GET['token']?>"><button class="btn btn-success pull-right" style="margin-top: -5px;"><i class="fa fa-plus" aria-hidden="true"></i> Thêm dịch vụ</button>
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
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>TT</th>
            <th>Tên dịch vụ </th>
            <th>Giá dịch vụ</th>
            <th>Sự kiện</th>
          
          </tr>
        </thead>
        <tbody id="list">
          <?php $i=0; foreach ($get_dichvu as $value) { $i++;
            //print_r($value);die;
          ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $value['name'];?></td>
            <td><?php echo number_format($value['price']);?> VNĐ</td>
            
            <td class="text-center">
               <a href="index.php?route=pd/dichvu/edit&id=<?php echo $value['id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
               </a>
               <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/dichvu/submit_remove&id=<?php echo $value['id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>

            </td>
            
          </tr>
          <?php } ?>
        </tbody>
      </table>
      
    </div>
  </div>
</div>


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