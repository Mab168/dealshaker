<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1>
                Trang quản lý spa Beauty Gold
            </h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="
                        
                        <?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_install) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $error_install; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 customer_pd">
                <?php echo $customer; ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 customer_pd">
                <div class="tile">
                    <div class="tile-heading">Tổng số hóa đơn</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totalhoadon; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 customer_pd">
                <div class="tile">
                    <div class="tile-heading">Số nhân viên</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totalnhanvien; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 customer_pd">
                <div class="tile">
                    <div class="tile-heading">Tổng số các dịch vụ</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totaldichvu; ?>
                        </h2>
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="col-md-12">
          <h3 class="text-center">Lịch sử hóa đơn mới nhất</h3>
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
          <?php $i=0; foreach ($get_history_customer as $value) { $i++;
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
        </div>
    </div>
</div>

    </section>
<style type="text/css" media="screen">
.customer_pd{
    padding-right: 5px;
    padding-left: 5px;
}
.section a{
    margin-left: -73px;
    z-index: 99999;
    position: relative;
    font-size: 15px;
    opacity: 0;
}
#second {
  background-color: #FF8A66;
}
.section {
 
}
.section input[type="radio"],
.section input[type="checkbox"]{
  display: none;
}
.container {
  margin-bottom: 10px;
}
.container label {
  position: relative;
}

/* Base styles for spans */
.container span::before,
.container span::after {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  margin: auto;
}

/* Radio buttons */
.container span.radio:hover {
  cursor: pointer;
}
.container span.radio::before {
  left: -52px;
  width: 45px;
  height: 25px;
  background-color: #A8AAC1;
  border-radius: 50px;
}
.container span.radio::after {
  left: -49px;
  width: 17px;
  height: 17px;
  border-radius: 10px;
  background-color: #6C788A;
  transition: left .25s, background-color .25s;
}
input[type="radio"]:checked + label span.radio::after {
  left: -27px;
  background-color: #EBFF43;
}
</style>
</div>
<?php echo $footer; ?>