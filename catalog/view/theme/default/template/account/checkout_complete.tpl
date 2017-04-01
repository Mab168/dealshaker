<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
   <div class="container">
      <div class="left">
         <ol class="breadcrumb">
            <li class="first">        <a href="">Trang chủ</a>        
            </li>
            <li>        <a href="">Sản phẩm</a>        
            </li>
           
            <li class="active last"><span>Hoàn tất thanh toán</span>        
            </li>
         </ol>
      </div>
   </div>
</div>
<div id="content" class="container wrap-content">
  <div class="col-md-12">
  <div class="">
   
        <div class="bill_order col-md-10 col-md-push-1">
            <div class="pull-left" style="width: 18%">
                <img src="actalog/view/theme/default/images/logo.png" style="width: 100px; height: 100px" class="logo_bill">
            </div>
            <div class="pull-left" style="width: 82%; ">
                <h2 class="text-center" style="line-height: 100px;">CÔNG TY DICH VU WEBSITE</h2>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="content_bill">
                 <h3 class="text-center" style="margin-top: 20px;">Hóa đơn thanh toán</h3>
                 <p class="text-right"><u><i>Số:</i></u> 0000<?php echo $get_order[0]['order_id'] ?></p>
                 <p style="margin-top: 30px; float: left; margin-right: 25px;">Mã hóa đơn: <?php echo $get_order[0]['payment_code'] ?></p>
                 <p style="float: left;margin-top: 30px;">Ngày taọ: <?php echo date('d/m/Y H:i', strtotime($get_order[0]['date_added']))  ?></p>
                 <div class="clearfix"></div>
                 <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>TT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Mô tả</th>
                        </tr>
                        </thead>
                        <tbody>
                <?php $i= 0; foreach ($get_order as $value) { $i++;
                    $product = $self -> get_product_id($value['product_id']);

                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $product['name_product'] ?></td>
                        <td><?php echo $value['qty'] ?></td>
                        <td><?php echo $value['total'] ?> <?php echo $value['payment'] ?></td>
                        <td>
                            <?php if ($value['payment'] == "GDG") { ?>
                            Chuyển <?php echo $value['total'] ?> <?php echo $value['payment'] ?> đên username <b><?php echo $self -> get_customer($value['customer_sell'])['username_gdg'] ?></b>
                            <?php } else { ?>
                            <p>Chuyển <?php echo $value['total'] ?> <?php echo $value['payment'] ?> đên địa chỉ ví <b><?php echo $self -> get_customer($value['customer_sell'])['wallet'] ?></b> </p>
                            <p class="text-center">
                                <img src="https://chart.googleapis.com/chart?chs=150x150&chld=L|0&cht=qr&chl=bitcoin:<?php echo $self -> get_customer($value['customer_sell'])['wallet'] ?>?amount=<?php echo $value['total'] ?>">
                            </p>
                                <p class="text-center"><?php echo $self -> get_customer($value['customer_sell'])['wallet'] ?>
                            </p>
                            <?php } ?>
                        </p>
                    </tr>
                
                <?php
                } ?>
                </tbody>
            </table>  
            </div>
        </div>
  </div>
  </div>
</div>

<?php echo $self->load->controller('common/footer') ?>