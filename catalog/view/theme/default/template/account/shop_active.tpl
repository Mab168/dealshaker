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
<div class="">
    <div class="c-content-box c-size-md">
        <div class="container">
              <div class="c-content-box c-size-md c-bg-grey-1">
                <div class="container">
                    <div class="c-content-pricing-1 c-option-2">
                        <div class="c-content-title-1">
                            <h3 class="c-center c-font-uppercase c-font-bold">Purchase a Package</h3>
                            <div class="c-line-center"></div>
                        </div>
                        <div class="c-tile-container">
                            <div class="c-tile c-tile-small">
                                <div class="c-label c-theme-bg">Standard</div>
                                <p class="c-price">59
                                    <sup>$</sup>
                                </p>
                                <p class="c-font-uppercase">1000 Copies</p>
                                <p class="c-font-uppercase">Unlimited Data</p>
                                <p class="c-font-uppercase">Unlimited Users</p>
                                <p class="c-font-uppercase">For 7 days</p>
                                <button type="button" class="btn btn-md c-btn-square c-btn-border-2x c-btn-dark c-btn-uppercase c-btn-bold">Purchase</button>
                            </div>
                            <div class="c-tile c-theme-bg c-highlight">
                                <div class="c-label c-theme">Business</div>
                                <p class="c-price">99
                                    <sup>$</sup>
                                </p>
                                <p class="c-font-uppercase">10,000 Copies</p>
                                <p class="c-font-uppercase">Unlimited Data</p>
                                <p class="c-font-uppercase">Unlimited Users</p>
                                <p class="c-font-uppercase">For 30 days</p>
                                <button type="button" class="btn btn-md c-btn-square c-btn-border-2x c-btn-white c-btn-uppercase c-btn-bold">Purchase</button>
                            </div>
                            <div class="c-tile c-tile-small">
                                <div class="c-label c-theme-bg">Expert</div>
                                <p class="c-price">199
                                    <sup>$</sup>
                                </p>
                                <p class="c-font-uppercase">Unlimited Copies</p>
                                <p class="c-font-uppercase">Unlimited Data</p>
                                <p class="c-font-uppercase">Unlimited Users</p>
                                <p class="c-font-uppercase">For 1 Year</p>
                                <button type="button" class="btn btn-md c-btn-square c-btn-border-2x c-btn-dark c-btn-uppercase c-btn-bold">Purchase</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $self->load->controller('common/footer') ?>