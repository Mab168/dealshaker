<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div id="content" class="container">
    <div class="row margin-top-20">
        <div class="col-xs-12 col-md-3">
           <nav class="home-sidebar badge-row">
              <div class=" navbar navbar-default">
                 <div class="navbar-header">
                    <span class="navbar-brand uppercase" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    categories
                    </span>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">
                    Toggle navigation
                    </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                 </div>
                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav">
                       <li >                <a href="/en/business-profile">    Thông tin
                          </a>                            
                       </li>
                       <li >                <a href="?route=account/business_profile/shop">Sản phẩm của tôi
                          </a>                            
                       </li>
                       
                       <li class="active">                <a href="?route=account/business_profile/order">    Đơn hàng của tôi <!-- <span class="badge pull-right badge-danger badge-row ">1</span> -->
                          </a>                            
                       </li>
                       <li badge="1">                <a href="?route=account/business_profile/orderbuy">    Sản phẩm đã mua
                          <!-- <span class="badge pull-right badge-danger badge-row ">1</span> -->
                          </a>                            
                       </li>
                      
                    </ul>
                 </div>
              </div>
           </nav>
        </div>


  <div class="col-xs-12 col-md-9">
   <div class="sub-section-header-border-bottom">
      <h3 class="header">Đơn hàng của tôi</h3>
   </div>
  
    <div class="">
        <div class="c-content-panel">
                       
            <div class="c-body">
                <div class="c-content-tab-1">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="tab-content c-padding-sm">
                                <div class="tab-pane fade c-state_active in active" id="tab_16_1">
                                    <table class="table table-bordered show_product">
                                        <thead>
                                            <tr>
                                                <th class="text-center">TT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Phương thức thanh toán</th>
                                                <th>Tổng cộng</th>
                                                <th>Thời gian</th>
                                                <th style="width: 100px">Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($product as $value) { $i++;?>
                                            <tr>
                                                <td class="text-center"><?php echo $i ?></td>
                                                <td><?php echo $value['name_product']  ?></td>
                                                <td>
                                                <?php $images = $self -> get_images_product($value['product_id']) ;
                                                    ?>
                                                    <img style="width: 100px;max-height: 60px;" src="<?php echo $images['image'] ?>"
                                               
                                                    
                                                </td>
                                                <td><?php echo ($value['payment'])  ?> </td>
                                                <td><?php echo ($value['total'])  ?> <?php echo ($value['payment'])  ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($value['date_added'] ))  ?></td>
                                                <td class="text-center">
                                                    <i data-toggle="modal" data-target="#item-<?php echo $value['order_id'] ?>" data-toggle="tooltip" title="Xem chi tiết" class="fa fa-newspaper-o" aria-hidden="true"></i>
                                                </td>
                                            </tr>

<div class="modal fade" id="item-<?php echo $value['order_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="float: left; line-height: 60px;" class="modal-title">Mã hóa đơn <?php echo $value['payment_code'] ?></h4><img style="width: 100px;max-height: 60px; float: right" src="<?php echo $images['image'] ?>" />
            </div>
            <div class="modal-body">
                <h5>Tên sản phẩm <b><?php echo $value['name_product']  ?></b></h5>
                <p style="margin-top: 10px;">Phương thức thanh toán: <b><?php echo $value['payment']  ?></b></p>

                <p style="margin-top: 10px;">Tổng tiền: <b><?php echo $value['total']  ?> <?php echo $value['payment']  ?></b></p>
                <p style="margin-top: 10px;">Thời gian đặt mua: <b><?php echo date('d/m/Y H:i:s',strtotime($value['date_added']))  ?></b></p>

                <hr>
                <h5>Thông tin người mua</h5>
                <p style="margin-top: 10px;">Họ tên: <b><?php echo $value['firstname']  ?></b></p>
                <p style="margin-top: 10px;">Số điện thoại: <b><?php echo $value['telephone']  ?></b></p>
                <p style="margin-top: 10px;">Email: <b><?php echo $value['email']  ?></b></p>
                <p style="margin-top: 10px;">Địa chỉ giao hàng: <b><?php echo $value['address_payment']  ?></b></p>
                <p style="margin-top: 10px;">Ghi chú: <b><?php echo $value['ghichu']  ?></b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                    <?php echo $pagination ?>
                                    </div>
                                </div>
                            
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
    </div>

<?php echo $self->load->controller('common/footer') ?>