<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Đầu tư</h1>

  </div>
</div>
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title pull-left">Đầu tư | <?php echo $customer['username'] ?></h3>
      
      <div class="clearfix">
          
      </div>
    </div>
    <div class="panel-body">
       <div class="navbar-form">
        <div class="row">

          <h3 class="text-center">Gói đầu tư hiện tại :<?php echo number_format($show_pd_customer['filled']/1000) ?> PV</h3>

          <?php if (doubleval($show_pd_customer['filled']) == 0){ ?>

            <form class="col-md-4 col-md-push-4" style="margin-top: 30px" action="index.php?route=pd/customer/invesment&token=<?php echo $_GET['token'] ?>" method="post">
              <?php if (isset($_SESSION['complate'])){ ?>
              <div class="alert alert-success">
                <strong>Success!</strong> Cập nhật thông tin thành công.
              </div>
              <?php unset($_SESSION['complate']); } ?>
              <h4>Chọn gói và chọn đầu tư để kích hoạt gói</h4>
              <div class="form-group" style="width: 100%;margin-top: 20px">
                <label style="width: 100%" for="email">Gói đầu tư</label>
                <select style="width: 100%" name="package" class="form-control">
                  <option value="100">3.000.000 VNĐ | 100 PV</option>
                  <option value="200">6.000.000 VNĐ | 200 PV</option>
                  <option value="300">9.000.000 VNĐ | 300 PV</option>
                  <option value="3333">100.000.000 VNĐ | 3333 PV</option>
                  <option value="6666">200.000.000 VNĐ | 6666 PV</option>
                  <option value="16666">500.000.000 VNĐ | 16666 PV</option>
                  <option value="24166">1.450.000.000 VNĐ | 24166</option>
                </select>
                <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id'] ?>">
              </div>
              <div class="form-group text-center" style="width: 100%;margin-top: 20px">
                <button style="width: 100%" type="submit" onclick="return confirm('Bạn có chắc chắn kích hoạt cho <?php echo $customer['username'] ?> không?')" class="btn btn-primary">Đầu tư</button>
              </div>
            </form>
          <?php } else { ?> 
            <form class="col-md-4 col-md-push-4" style="margin-top: 30px" action="index.php?route=pd/customer/upgray_invesment&token=<?php echo $_GET['token'] ?>" method="post">
              <?php if (isset($_SESSION['complate'])){ ?>
              <div class="alert alert-success">
                <strong>Success!</strong> Cập nhật thông tin thành công.
              </div>
              <?php unset($_SESSION['complate']); } ?>
              <h4>Chọn gói và chọn đầu tư để nâng cấp gói</h4>
              <div class="form-group" style="width: 100%;margin-top: 20px">
                <label style="width: 100%" for="email">Gói đầu tư</label>
                <select style="width: 100%" name="package" class="form-control">
                <?php if (doubleval($show_pd_customer['filled']) < 200000) {?>
                  <option value="200">6.000.000 VNĐ | 200 PV</option>
                <?php } ?>
                <?php if (doubleval($show_pd_customer['filled']) < 300000) {?>
                  <option value="300">9.000.000 VNĐ | 300 PV</option>
                <?php } ?>
                <?php if (doubleval($show_pd_customer['filled']) < 3333000) {?>
                  <option value="3333">100.000.000 VNĐ | 3333 PV</option>
                <?php } ?>
                <?php if (doubleval($show_pd_customer['filled']) < 6666000) {?>
                  <option value="6666">200.000.000 VNĐ | 6666 PV</option>
                <?php } ?>
                <?php if (doubleval($show_pd_customer['filled']) < 16666000) {?>
                  <option value="16666">500.000.000 VNĐ | 16666 PV</option>
                <?php } ?>
                <?php if (doubleval($show_pd_customer['filled']) < 24166000) {?>
                  <option value="24166">1.450.000.000 VNĐ | 24166</option>
                <?php } ?>
                </select>
                <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id'] ?>">
              </div>
              <div class="form-group text-center" style="width: 100%;margin-top: 20px">
                <button style="width: 100%" type="submit" onclick="return confirm('Bạn có chắc chắn kích hoạt cho <?php echo $customer['username'] ?> không?')" class="btn btn-warning">Nâng cấp gói đầu tư</button>
              </div>
            </form>

          <?php } ?>
           
          </div>
        </div>
        <div class="clearfix" style="margin-top:10px;"></div>
    </div>
  </div>
</div>

<?php echo $footer; ?>