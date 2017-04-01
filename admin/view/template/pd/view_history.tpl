<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Lịch sử giao dịch </h1>

  </div>
</div>
<div class="container-fluid">
  <div class="panel panel-default row">
    <div class="panel-heading">
      <h3 class="panel-title pull-left">Lịch sử giao dịch | <?php print_r($customerss['firstname']);?></h3>
      
      <div class="clearfix">
          
      </div>
    </div>
    <div class="panel-body" style="overflow-x: scroll;">
    <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>TT</th>
            
            <th>Họ Tên</th>
            <th>Tuổi</th>
            <th>Thông tin tư vấn</th>
            <th>Dịch vụ</th>
            
            <th>Nhân viên</th>
            <th>Giá tiền</th>
            <th>Thời gian</th>
          </tr>
        </thead>
        <tbody id="list">
          <?php $i=0; foreach ($customer as $value) { $i++;
          ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo $self -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            <td><?php echo $value['thongtintuvan'];?></td>
            <td><?php echo $value['dichvu'];?></td>
            <td><?php echo $value['nhanvientao'];?></td>
            <td><?php echo number_format($value['giatien']);?></td>

            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php echo $pagination ?>

<hr></hr>
     
    </div>
  </div>
</div>
