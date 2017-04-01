<?php $self->document->setTitle("Trang chủ"); echo $self->load->controller('common/header'); //echo $self->load->controller('common/column_left'); ?>
<div class="c-layout-page">
  <div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
      <div class="container">
          <div class="c-page-title c-pull-left">
              <h3 class="c-font-uppercase c-font-sbold">Customer Login/Register</h3>
              <h4 class="">Page Sub Title Goes Here</h4>
          </div>
          <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
              <li>
                  <a href="shop-customer-account.html">Customer Login/Register</a>
              </li>
              <li>/</li>
              <li class="c-state_active">Jango Components</li>
          </ul>
      </div>
  </div>
</div>
<div class="c-layout-page">
    <div class="c-content-box c-size-md">
        <div class="container">
            <div class="loop owl-carousel owl-theme">
            <div class="item">
              <h4>1</h4>
            </div>
            <div class="item">
              <h4>2</h4>
            </div>
            <div class="item">
              <h4>3</h4>
            </div>
            <div class="item">
              <h4>4</h4>
            </div>
            <div class="item">
              <h4>5</h4>
            </div>
            <div class="item">
              <h4>6</h4>
            </div>
            <div class="item">
              <h4>7</h4>
            </div>
            <div class="item">
              <h4>8</h4>
            </div>
            <div class="item">
              <h4>9</h4>
            </div>
            <div class="item">
              <h4>10</h4>
            </div>
            <div class="item">
              <h4>11</h4>
            </div>
            <div class="item">
              <h4>12</h4>
            </div>
          </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
  $('.loop').owlCarousel({
    center: true,
    items: 2,
    loop: true,
    margin: 10,
    autoplayTimeout : 1000,
    autoplayHoverPause : true,
    navigation : false,
    autoplay: true,
    dots : false,
    lazyLoad: true,
    responsive: {
      600: {
        items: 4
      }
    }
  });
});
</script>

<?php echo $self->load->controller('common/footer') ?>