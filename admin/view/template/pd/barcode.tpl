<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Khách hàng</h1>

  </div>
</div>
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title pull-left">Khách hàng</h3>
      
      <div class="clearfix">
          
      </div>
    </div>
    <div class="panel-body">
       <div class="navbar-form">
      
        </div>
        <div class="clearfix" style="margin-top:10px;"></div>
        <div id="list"></div>

        <div class="clearfix" style="margin-top: 20px; float: left;width: 100%"></div>
      <?php if (count($customer) > 0) { ?>
   
      
      <div class="load_session">
      <?php  $value =  $customer;?>
      <h2 class="text-center" style="margin-bottom: 20px;">Thông tin khách hàng</h2>
        <div class="col-md-6">
          <h3>Tên khách hàng: <?php echo $value['firstname'] ?></h3>
          <h3>Ngày sinh: <?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></h3>
          <h3>Số điện thoại: <?php echo $value['telephone'] ?></h3>
        </div>
        <div class="col-md-6">
          <h3>Tuổi: <?php echo $self -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?></h3>
          <h3>Địa chỉ: <?php echo $value['address'] ?></h3>
          <h3>Ngày tạo: <?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></h3>
        </div>

     	<table class="table table-bordered table-hover">
     		<thead>
     			<tr>
     			
     				<th>Họ Tên</th>
            <th>Ngày sinh</th>
            <th>Tuổi</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Thời gian</th>
            <th>Lịch sử</th>
            <th>Sửa</th>
            <th>Xóa</th>
            <th>Tạo hóa đơn</th>
     			</tr>
     		</thead>
     		<tbody >
          
          
          <tr>
           
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></td>
            <td><?php echo $self -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            
            <td><?php echo ($value['telephone']);?></td>
            
            <td><?php echo $value['address'];?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            <td class="text-center"><a href="<?php echo $self->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$self->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
            <td class="text-center"><a href="<?php echo $self->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$self->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>   
            <td class="text-center">
              <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/create/submit_remove&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>
            </td>
            <td class="text-center">
              <a href="index.php?route=pd/customer/create_bill&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></i></button>
               </a>
            </td>
          </tr>
        
     		</tbody>
     	</table>
      

        <div class="clearfix" style="margin-top: 20px;"></div>
           <h3 class="text-center">Lịch sử</h3>
           <?php
      
            $get_history = $self -> model_pd_registercustom -> get_history_customer($value['customer_id']);
            if (count($get_history) > 0)
            { ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    
                <th>STT</th>
                <th>Thông tin tư vấn</th>
                    <th>Dịch vụ</th>
                    <th>Nhân viên quản lý</th>
                    <th>Ghi chú</th>
                    <th>Giá tiền</th>
                    <th>Thời gian</th>
                    
                  </tr>
                </thead>
                <tbody >
                <?php $i=0; foreach ($get_history as $values) { $i++;?>
                <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $values['thongtintuvan'];?></td>
                      <td><?php echo $values['dichvu']; ?></td>
                      <td><?php echo $values['nhanvientao'];?> </td>
                      <td><?php echo $values['ghichu'];?></td>
                      <td><?php echo (number_format($values['giatien']));?></td>
                      <td><?php echo date('d/m/Y H:i:s',strtotime($values['date_added'])) ?></td> 
                   </tr>
                <?php } ?>

                </tbody>
                </table>
            <?php }
            else{
                ?> <h3 class="text-center">Không có dữ liệu</h3> <?php
              }



            ?>
        </div>
      <?php } ?>
      
    </div>
  </div>
</div>
<style type="text/css" media="screen">
  ul#suggesstion-box li:hover {
    cursor: pointer;
    background-color: #E27225;
    color: #fff;
  }
  ul#suggesstion-box_username li:hover {
    cursor: pointer;
    background-color: #E27225;
    color: #fff;
  }
  ul#suggesstion-box_tuoi li:hover {
    cursor: pointer;
    background-color: #E27225;
    color: #fff;
  }
  ul#suggesstion-box{
     position: absolute;
    width: 270px;
  }
  ul#suggesstion-box_username{
     position: absolute;
    width: 270px;
  }
   ul#suggesstion-box_tuoi{
     position: absolute;
    width: 270px;
  }
  #content .panel-body{
    min-height: 530px;
  }
 
</style>
<script type="text/javascript">
  jQuery('.date').datetimepicker({
      pickTime: false
  });
  $('#submit_date').click(function(){
      jQuery('.loading').show();
      setTimeout(function(){ 
        var date_day = $('#date_day').val();
        $.ajax({
            url : "<?php echo $load_date ?>",
            type : "post",
            dataType:"text",
            data : {
                'date' : date_day
            },
            success : function (result){
                jQuery('#list').html(result);
                jQuery('.loading').hide();
            }
        });
      }, 100);
  });
  jQuery('#btn-filter').click(function(){
    jQuery('.loading').show();
    setTimeout(function(){ 
      var name = jQuery('#name').val();
      
      $.ajax({
        url : "<?php echo $link_search; ?>",
        type : "post",
        dataType:"html",
        data : {
            'name': name
        },
        success : function (result){
          $('#list').html(result);
          jQuery('.loading').hide();
        }
      
      });
    }, 100);
        
    }); 
    $("#name").keyup(function(){

        $.ajax({
        type: "POST",
        url: "<?php echo $getaccount;?>",
        data:'keyword='+$(this).val(),        
        success: function(data){
            $("#suggesstion-box").show();
            $("#suggesstion-box").html(data);
            $("#name").css("background","#FFF");            
        }
        });
    });
    $("#p_node").keyup(function(){
        $.ajax({
        type: "POST",
        url: "<?php echo $getaccount_username;?>",
        data:'keyword='+$(this).val(),        
        success: function(data){
            $("#suggesstion-box_username").show();
            $("#suggesstion-box_username").html(data);
            $("#p_node").css("background","#FFF");            
        }
        });
    });
    $("#tuoi").keyup(function(){
        $.ajax({
        type: "POST",
        url: "<?php echo $getaccount_tuoi;?>",
        data:'keyword='+$(this).val(),        
        success: function(data){
            $("#suggesstion-box_tuoi").show();
            $("#suggesstion-box_tuoi").html(data);
            $("#p_node").css("background","#FFF");            
        }
        });
    });

    function selectU(val,customer_id) {
         jQuery('.loading').show();
        $("#name").val(val);
        $("#suggesstion-box").hide();
        $.ajax({
        url : "<?php echo $link_search; ?>",
        type : "post",
        dataType:"html",
        data : {
            'name': customer_id
        },
        success : function (result){
          $('#list').html(result);
          jQuery('.loading').hide();
        }
      
      });
    }
    function selectU_username(val) {
        jQuery('.loading').show();
        $("#p_node").val(val);
        $("#suggesstion-box_username").hide();
        $.ajax({
        url : "<?php echo $link_search_username; ?>",
        type : "post",
        dataType:"html",
        data : {
            'name': val
        },
        success : function (result){
          $('#list').html(result);
          jQuery('.loading').hide();
        }
      
      });
    }
    function selectU_tuoi(val,customer_id) {
        jQuery('.loading').show();
        $("#p_node").val(val);
        $("#suggesstion-box_tuoi").hide();
        $.ajax({
        url : "<?php echo $link_search_tuoi; ?>",
        type : "post",
        dataType:"html",
        data : {
            'customer_id': customer_id
        },
        success : function (result){
          $('#list').html(result);
          jQuery('.loading').hide();
        }
      
      });
    }
    $('#thangs').on('change',function(){
      
      jQuery('.loading').show();
      $.ajax({
        url : "index.php?route=pd/customer/search_thang&token=<?php echo $_GET['token']; ?>",
        type : "post",
        dataType:"html",
        data : {
            'thang': $(this).val()
        },
        success : function (result){
          $('#list').html(result);
          jQuery('.loading').hide();
        }
    })
  })

    function load_user(barcode)
    {
      jQuery('.loading').show();

      $.ajax({
        url : "index.php?route=pd/barcode/load_barcode&token=<?php echo $_GET['token']; ?>",
        type : "post",
        dataType:"html",
        data : {
            'barcode': barcode
        },
        success : function (result){
          jQuery('.load_session').hide();
          $('#list').html(result);
          jQuery('.loading').hide();
        }

    });
    }
    $(document).scannerDetection({
      timeBeforeScanTest: 200, // wait for the next character for upto 200ms
      avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
      preventDefault: true,

      endChar: [13],
        onComplete: function(barcode, qty){
          validScan = true;

          $('#userInput').val(barcode);
          load_user(barcode);
          console.log(barcode);
        } 
      ,
      onError: function(string, qty) {

      $('#userInput').val ($('#userInput').val()  + string);

      }
      
      
    });
</script>
<input id="userInput" style="display: none;" type="text"  autofocus/>


<?php echo $footer; ?>