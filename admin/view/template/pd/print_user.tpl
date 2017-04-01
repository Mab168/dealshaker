<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <title></title>
</head>
<body>
  <table style="width: 100%">
    
    <tbody>
      <tr class="header">
        <td colspan="2" style="text-align: center; font-size: 32px;">HÓA ĐƠN KHÁCH HÀNG</td>
      </tr>
      
      <tr><td class="height"></td></tr>
      <tr><td class="height"></td></tr>
      <tr><td class="height"></td></tr>
      
      <?php //print_r( $getCustomer) ?>
      <tr>
        <td class="left" colspan="2">Họ tên khách hàng : <?php echo $getCustomer['firstname'] ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Ngày tháng năm sinh : <?php echo date('d/m/Y',strtotime($getCustomer['date_birth'])) ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Số tuổi : <?php echo $self -> getAge(date('Y-m-d',strtotime($getCustomer['date_birth'])));?> tuổi</td>
      </tr>
      <tr>
        <td class="left" colspan="2">Số điện thoại :<?php echo $getCustomer['telephone'] ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Địa chỉ : <?php echo $getCustomer['address'] ?></td>
      </tr>
      <tr><td class="height"></td></tr>
      
     
      <tr><td class="height"></td></tr>
      <tr>
        <td class="left" colspan="2"><b>SỬ DỤNG DỊCH VỤ CỦA BEAUTY GOLD SPA</b></td>
      </tr>
      <tr><td class="height"></td></tr>
      <tr>
        <td class="left" colspan="2">Thông tin tư vấn: <?php echo $getCustomer['thongtintuvan'] ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Dịch vụ: <?php echo $getCustomer['dichvu'] ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Giá tiền: <?php echo number_format($getCustomer['giatien']) ?> VNĐ</td>
      </tr>
      <tr>
        <td class="left" colspan="2">Thời gian: <?php echo date('d/m/Y H:i:s',strtotime($getCustomer['date_added'])) ?></td>
      </tr>
      <tr>
        <td class="left" colspan="2">Ghi chú: <?php echo $getCustomer['ghichu'] ?></td>
      </tr>
        <td class="left" colspan="2"></td>
      </tr>
      <tr><td class="height"></td></tr>
      <tr><td class="height"></td></tr>
    </tbody>
  </table>
  <table style="float: right; margin-right: 50px;">
    <tbody>
      <tr>
        <td></td>
        <td class="center"><i>TPHCM,  Ngày <?php echo date('d') ?> Tháng <?php echo date('m') ?> Năm <?php echo date('Y') ?></i></td>
      </tr>
      <tr>
        <td></td>
        <td  class="center" style="font-size:22px;"><b>Spa Beauty Golod</b></td>
      </tr>
      <tr>
        <td>
          <br><br><br><br><br><br>
        </td>
        <td  class="center"><b>NV. <?php echo $getCustomer['nhanvientao'] ?></b></td>
      </tr>
      
    </tbody>
  </table>
  <img src="view/images/img.png">
 
</body>
</html>
<style type="text/css">
  img{
    width: 660px;
    position: absolute;
    top: 36%;
    z-index: 9;
    opacity: 0.07;
    left: 13%;
  }
  .img{
     top: 72%;
  } 
  body{
    position: relative;
    padding: 30px 0;
    width: 800px;
    margin: 0 auto;
    font-size: 18px;
    z-index: 9999;
  }
  body table tbody{
    font-size: 22px;
  }
  table thead td{
    text-align: center;
  }
  table thead td:nth-child(1){
    width: 50%;

  }
  table tbody tr.header{
    height: 30px;
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    

  }
  table tbody tr.header td{
    padding-top: 40px;
  }
  table tbody .center{
    text-align: center;
  }
  table tbody .left{
    text-align: left;
  }
  table tbody .right{
    text-align: right;
  }
  table tbody .height{
    height: 10px;
  }
  table tbody  span{
    margin-left: 30px;
  }
  @page {
      size: auto;   /* auto is the initial value */
      margin: 75px;  /* this affects the margin in the printer settings */
      margin-top: 50px;
      margin-bottom: 80px;

  }
  @media print {
    @page { margin: 0; }
    body { margin: 1.6cm; }
  }
</style>
<script type="text/javascript">
  window.print();
</script>