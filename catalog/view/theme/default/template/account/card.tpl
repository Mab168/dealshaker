<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
   <div class="container">
      <div class="left">
         <ol class="breadcrumb">
            <li class="first">        <a href="">Trang chủ</a>        
            </li>
            <li>        <a href="">Sản phẩm</a>        
            </li>
           
            <li class="active last"><span>Giỏ hàng</span>        
            </li>
         </ol>
      </div>
   </div>
</div>
<div id="content" class="container wrap-content">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>TT</th>
          <th>Tên sản phẩm</th>
          <th>Hinh ảnh sản phẩm</th>
          <th>Giá sản phẩm</th>
          <th>Số lượng mua</th>
          <th>Tổng GDG</th>
          <th>Tổng BTC</th>
          <th>Xóa</th>
        </tr>
      </thead>
      <tbody class="card_body">
        <?php if (isset($card) > 0) { ?>
        <?php $i = $total_gdg = $total_btc = 0; foreach ($card as $value) { $i++;
          $product = $self -> get_product_id($value['product_id']);
          ?>
        
        <tr class="item_product_<?php echo $product['product_id'] ?>">
          <td><?php echo $i ?></td>
          <td><?php echo $product['name_product'] ?></td>
          <td class="text-center"><img style="width: 100px;" src="<?php echo $self->get_images_product($product['product_id'])['image'] ?>" /></td>
          <td><?php echo $product['price_gdg'] ?> GDG | <?php echo $product['price_btc'] ?> BTC</td>
          <td class="text-center"><input class="number_item" data-id="<?php echo $product['product_id'] ?>" style="width: 70px; text-align: center;margin: 0 auto;" type="" name="" class="form-control" value="<?php echo $value['qty'] ?>"></td>
          <td><?php echo $product['price_gdg']*$value['qty'] ?> GDG</td>
          <td><?php echo $product['price_btc']*$value['qty'] ?> BTC</td>
          <td class="text-center"><i style="cursor: pointer;" class="fa fa-trash remove_product" data-id="<?php echo $product['product_id'] ?>" aria-hidden="true"></i></td>
        </tr>
        <?php 
          $total_gdg += $product['price_gdg']*$value['qty'];
          $total_btc += $product['price_btc']*$value['qty'];
        ?>
        <?php } ?>
        <tr>
          <td class="text-right" colspan="5"><b>Tổng</b></td>
          <td class="text-center"><b><?php echo $total_gdg; ?> GDG</b> </td>
          <td class="text-center" colspan="2"><b><?php echo $total_btc; ?> BTC</b></td>
        </tr>
        <?php } else { ?>
        <tr>
          <td colspan="8" class="text-center">Không có sản phẩm trong giỏ hàng</td>
        </tr>
        <?php } ?>
      </tbody>
    </table> 

    <div class="clearfix"></div>
    <a href="home.html">
      <button style="float: left; margin-bottom: 10px; height: 36px; font-size: 15px; width: 200px; background: #f99f1c; border: navajowhite;" class=" btn btn-danger btn-sm"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Tiếp tục mua hàng </button>  
    </a>
    <a href="index.php?route=account/checkout">
      <button style="float: right; margin-bottom: 10px; height: 36px; font-size: 15px; width: 200px; background: #60af62; border: navajowhite;" class="btn btn-danger btn-sm"> Tiến hành thanh toán <i class="fa fa-angle-double-right" aria-hidden="true"></i> </button>   
    </a>  
</div>

<?php echo $self->load->controller('common/footer') ?>