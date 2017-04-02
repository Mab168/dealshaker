<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $title; ?> </title>
    <meta http-equiv="cache-control" content="no-cache" />
    <base href="<?php echo $base; ?>" />
    <?php if ($description){ ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords){ ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>



    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    
    <!--  -->
    <!-- <script src="catalog/view/theme/default/assets/js/compileddc25.js?201703131257"></script>
    <script src="catalog/view/theme/default/bundles/merchantsonedealsopen/js/Listing/categoryFilterdc25.js?201703131257"></script>
    <script>
       Store.Listing.categoryFilter.init();
    </script>  -->
     <script src="catalog/view/theme/default/css/toastr/toastr.min.js"></script>
    <link href="catalog/view/theme/default/css/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    
    <!--  -->
    <script src="catalog/view/javascript/fancybox/jquery.fancybox.js"></script>
    <script src="catalog/view/theme/default/tinymce/tinymce.min.js"></script>
    <link href="catalog/view/theme/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="catalog/view/theme/default/css/fancybox/jquery.fancybox.css" rel="stylesheet">

   <script src="catalog/view/javascript/main.js"></script>
    <!--- ###################  -->
    <link href="catalog/view/theme/default/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="catalog/view/theme/default/images/logo.png" /> </head>
    <link href="catalog/view/theme/default/assets/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="catalog/view/theme/default/css/owl.theme.default.css" rel="stylesheet" type="text/css" />
    <link href="catalog/view/theme/default/css/owl.carousel.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="catalog/view/theme/default/assets/css/compileddc25.css?201703131257"/>
    <!-- <script src="catalog/view/theme/default/assets/js/compileddc25.js?201703131257"></script> -->
   <!--  <script src="catalog/view/theme/default/bundles/merchantsonedealsopen/bower_components/matchHeight/dist/jquery.matchHeight-mindc25.js?201703131257"></script>
    
    
     <script src="catalog/view/theme/default/bundles/merchantsonedealsopen/bower_components/jquery-incremental-counter/jquery.incremental-counter.mindc25.js?201703131257"></script> -->

   
    <script src="catalog/view/theme/default/assets/js/owl.carousel.min.js" type="text/javascript"></script>

   
    
    <!--- ###################  -->

    <link href="catalog/view/theme/default/css/customer.css" rel="stylesheet">
    <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
    <?php foreach ($scripts as $script) { ?>
      <script src="<?php echo $script; ?>" type="text/javascript"></script>
      <?php } ?>
    <link href="catalog/view/theme/default/css/alertify.css" rel="stylesheet">
    <script src="catalog/view/javascript/common.js" type="text/javascript"></script>
    <script src="catalog/view/javascript/main_product.js" type="text/javascript"></script>
    <script src="catalog/view/javascript/jquery.form.min.js" type="text/javascript"></script>
    <script src="catalog/view/javascript/alertifyjs/alertify.js" type="text/javascript"></script>
    
    <script src="catalog/view/javascript/validate/jquery.validate.js" type="text/javascript"></script>
    
</head>
<!--  <script type="text/javascript">
(function($) {
    $(function() { //on DOM ready 
            $("#scroller").simplyScroll();
    });
 })(jQuery);
</script> -->
<body class="bg-orange">
    <header  itemscope="">
   <div class="top-header">
      <div class="container flex-f">
         <div class="header-wrap-left">
            <!-- <div class="wrap-btn-buy-sell">
               <p class="">
                  <span class="text">
                  I want to:
                  </span>
                  <a href="index.html" title="Buy"
                     class="btn-wants color-yellow-theme-bg active">
                  Buy
                  </a><a href="?route=account/business_profile" title="Sell"
                     class="btn-wants color-blue-theme-bg">
                  Sell
                  </a>
               </p>
            </div> -->
         </div>
         <div class="header-wrap-right">
            <div class="list-inline login-list hidden-xs">
                <?php if (isset($_SESSION['customer_id'])) { ?>
                   
                
                <ul class="list-inline">
                   <li class="hidden-xs current first">                    <a href="home.html">
                      Trang chủ
                      </a>
                   </li>
                   <li class="nav-parent last dropdown">
                      <a href="#" class="dropdown-toggle click_home" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      <i class="visible-xs-inline visible-sm-inline imoon icon-user v-align-middle fs-18" aria-hidden="true"></i>
                      <span class="hidden-sm hidden-xs">Hello, <?php echo $customer['username'] ?></span>    
                      <b class="caret"></b>
                      </a>
                      <ul class="menu_level_1 dropdown-menu">
                         <li class="first">                    <a href="?route=account/business_profile">
                            Trang cá nhân
                            </a>
                         </li>
                         <li class="last">                    <a href="logout.html">
                            Thoát
                            </a>
                         </li>
                      </ul>
                   </li>
                </ul>
                <?php } else { ?>
               <ul class="">
                  <li>
                     <a href="login.html" role="button">
                    Đăng nhập
                     </a>
                  </li>
                  <li>
                     <a href="register.html" role="button">
                     Đăng ký
                     </a>
                  </li>
               </ul>
               <?php } ?>
            </div>
            <div class="list-inline login-list hidden-lg hidden-md hidden-sm">
               <div class="dropdown">
                  <a href="#" class="dropdown-toggle icon-on-mobile" type="button" id="dropdownMenu1"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="imoon icon-user v-align-middle fs-18" aria-hidden="true"></i>
                  <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                     <li>
                        <a href="login.html" role="button">
                        Đăng nhập
                        </a>
                     </li>
                     <li>
                        <a href="register.html" role="button">
                        Đăng ký
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <!-- <ul class="language-switcher">
               <li flagImage="en.png" class="first last dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <img src="catalog/view/theme/default/bundles/merchantsonedealsopen/img/flags/rectangle/en6668.png?201703131257%20}}"
                     title="ENGLISH"/>
                  ENGLISH
                  <b class="caret"></b>
                  </a>
                  <ul class="menu_level_1 dropdown-menu">
                     <li flagImage="cn.png" class="first last">                    <a href="https://dealshaker.com/cn/">
                        <img src="catalog/view/theme/default/bundles/merchantsonedealsopen/img/flags/rectangle/cndc25.png?201703131257"
                           title="中文"/>
                        中文
                        </a>
                     </li>
                  </ul>
               </li>
            </ul> -->
         </div>
      </div>
   </div>
   <div class="middle-header" style="background-image: url(catalog/view/theme/default/bundles/merchantsonedealsopen/img/themes/background_buydc25.jpg?201703131257)">
      <div class="white-gradient-logo"></div>
      <div class="container">
         <div class="row relative">
            <div class="col-sm-4 logo">
               <a href="home.html">
               <img alt="Logo"
                  src="catalog/view/theme/default/images/logo.png" style="height: 100px" 
                  class="img-responsive"/>
               </a>
            </div>
            <div class="wrap-search">
               <form name="" method="get" action="search.html">
                  <div class="search-box">
                     <div class="input-group">
                        <input type="search" id="q" name="q" required="required" class="form-control" placeholder="Tìm kiếm..." aria-label="Tìm kiếm..." />
                        <div class="input-group-btn">
                           <button type="submit"
                              class="btn btn-search bg-color-blueberry">
                           <i class="fa fa-search"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</header>
<div class="wrap">

    <nav class="navbar navbar-default navbar-m-0 style-bt main-horisontal-nav home-link" role="navigation"  itemscope="" itemtype="http://schema.org/SiteNavigationElement">
            <div class="container">
               <div class="navbar-header">
                  <a class="navbar-brand uppercase hidden-lg hidden-md" href="#">
                  Main Menu
                  </a>
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                     data-target="#navbar-ex1-collapse">
                  <span class="sr-only">
                  Toggle navigation
                  </span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
               </div>
               <div class="collapse navbar-collapse nav-main-public public-main-navigation" id="navbar-ex1-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="home.html"  itemprop="url"  class="overflow-hidden-nowrap">
                        <i class="hidden-lg hidden-md hidden-sm hidden-xs fa fa-user icon-mob-menu"></i>
                        Home 
                        </a>
                     </li>
                    <?php 
                        $getCategories = $self -> getCategories(0);
                        foreach ($getCategories as $value) {
                            $count_sub = $self -> getCategories($value['simple_blog_category_id']);
                    ?>
                        <li class="<?php echo (count($count_sub) > 0) ? 'dropdown dropdown-submenu' : ''?>">
                            <a href="?route=account/product/product_category&categories=<?php echo $value['simple_blog_category_id'] ?>"  itemprop="url" class="overflow-hidden-nowrap" >

                            <i class="hidden-lg hidden-md hidden-sm hidden-xs fa fa-user icon-mob-menu"></i>
                            <?php echo $value['name'] ?> 

                            <i class="fa fa-angle-right  fr fs-20 hidden-sm hidden-xs"></i>
                            </a>
                            <button type="button" class="btn  dropdown-toggle wrap-btn-mobile-menu hidden-lg hidden-md" data-toggle="dropdown" aria-haspopup="true">
                            <i class="fa fa-plus plus-minus fs-20"></i>
                            </button>
                           
                           <?php echo $self -> getSubcategory($value['simple_blog_category_id']) ?>
                        </li>
                    <?php
                        }
                    ?>
                    
                  </ul>
               </div>
            </div>
         </nav>


         

    

            
         

