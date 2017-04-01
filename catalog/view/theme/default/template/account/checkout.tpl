<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="section-breadcrumb">
   <div class="container">
      <div class="left">
         <ol class="breadcrumb">
            <li class="first">        <a href="">Trang chủ</a>        
            </li>
            <li>        <a href="">Sản phẩm</a>        
            </li>
           
            <li class="active last"><span>Thanh toán</span>        
            </li>
         </ol>
      </div>
   </div>
</div>
<div id="content" class="container wrap-content">
  <?php if (isset($self -> session -> data['customer_id'])) { ?>
    <div class="row cart-body">
      <form class="form-horizontal" method="post" action="index.php?route=account/checkout/submit">
                <?php //print_r($customer) ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <!--SHIPPING METHOD-->
                    <div class="panel panel-info">
                        <div class="panel-heading">Thông tin người mua</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>ĐỊA CHỈ GIAO HÀNG</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Họ tên</strong></div>
                                <div class="col-md-12">
                                    <input type="text" required class="form-control" value="" name="first_name" value="<?php echo $customer['firstname'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Email</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="email" class="form-control" value="<?php echo $customer['email'] ?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Số điện thoại</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="telephone" class="form-control" value="<?php echo $customer['telephone'] ?>" required/>
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="col-md-12"><strong>Địa chỉ giao hàng</strong></div>
                                <div class="col-md-12"><textarea name="address" class="form-control" required></textarea></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Ghi chú</strong></div>
                                <div class="col-md-12"><textarea name="ghichu" class="form-control"></textarea></div>
                            </div>
                        </div>
                    </div>
                  </div>
                 
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <!--REVIEW ORDER-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Sản phẩm mua <div class="pull-right"><small><a class="afix-1" href="index.php?route=account/card">Giỏ hàng</a></small></div>
                        </div>
                        <div class="panel-body">
                          <?php $i = $total_gdg = $total_btc = 0; foreach ($card as $value) { 
                                $i++;
                                $product = $self -> get_product_id($value['product_id']);
                                $total_gdg += $product['price_gdg']*$value['qty'];
                                $total_btc += $product['price_btc']*$value['qty'];
                          ?>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3">
                                    <img class="img-responsive" src="<?php echo $self->get_images_product($product['product_id'])['image'] ?>" />
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-xs-12"><?php echo $product['name_product'] ?></div>
                                    <div class="col-xs-12"><small>Số lượng:<span><?php echo $value['qty'] ?></span></small></div>
                                </div>
                                <div class="col-sm-3 col-xs-3 text-right">
                                    <h6><span><?php echo $product['price_gdg']*$value['qty']; ?></span> GDG</h6>
                                    <h6><span><?php echo $product['price_btc']*$value['qty']; ?></span> BTC</h6>
                                </div>
                            </div>
                            
                            <hr />
                            <?php } ?>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Tổng đơn hàng</strong>
                                    <div class="pull-right"><span><?php echo $product['price_gdg']*$value['qty']; ?></span> GDG</div><br>
                                    <div class="pull-right"><span><?php echo $product['price_btc']*$value['qty']; ?></span> BTC</div>
                                </div>
                                <!-- <div class="col-xs-12">
                                    <small>Vận Chuyển</small>
                                    <div class="pull-right"><span>-</span></div>
                                </div> -->
                            </div>
                            
                            <!-- <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Tổng đơn hàng</strong>
                                    <div class="pull-right"><span>$</span><span>150.00</span></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!--REVIEW ORDER END-->
                </div>
            </div>
            <div class="clearfix"></div>
                
            <div class="panel panel-info col-md-4 col-md-push-4" style="padding: 0px;">
                <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Phương thức thanh toán</div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12"><strong>Chọn phương thức thanh toán</strong></div>
                        <div class="col-md-12">
                            <select id="payemnt" name="payment" class="form-control">
                                <option value="GDG">GDG</option>
                                <option value="Bitcoin">Bitcoin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 20px; float: left;width: 100%">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-submit-fix" style="width: 100%">Hoàn tất đơn hàng</button>
                        </div>
                    </div>
                </div>
            </div>
                   
                </div>
              </form>
   <?php } else { ?>
    <h3 class="text-center" style="color: #14aad1; margin-top: 20px;">Bạn vui lòng đăng nhập để thanh toán</h3>
    <div class="text-center" style="margin-top: 30px;">
      <a href="login.html">
      <button style=" margin-bottom: 10px; height: 36px; font-size: 15px; width: 200px; background: #f99f1c; border: navajowhite;" class=" btn btn-danger btn-sm"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Đăng nhập </button>  
      </a>
      <a href="index.php?route=account/register">
        <button style=" margin-bottom: 10px; height: 36px; font-size: 15px; width: 200px; background: #60af62; border: navajowhite;" class="btn btn-danger btn-sm">Đăng ký<i class="fa fa-angle-double-right" aria-hidden="true"></i> </button>   
      </a>  
    </div>
   <?php } ?>
</div>

<?php echo $self->load->controller('common/footer') ?>