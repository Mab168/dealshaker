<!DOCTYPE html>
<!--[if IE 9]>
<html class="ie ie9" lang="en-US">
<![endif]-->
<html lang="en-US">

<!-- Mirrored from torchtemplates.net/skela/homepage-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Dec 2016 07:55:57 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>Home | Fundbtc </title>

    <link rel="icon" href="catalog/view/theme/default/img/logo_favi.png">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

    

    <link rel="stylesheet" href="catalog/view/theme/default/home/css/bootstrap.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/animate.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/flexslider.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/jquery-ui.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/simple-line-icons.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/font-awesome.min.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/icon-font.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/flat-icon.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/css/skela.css">
    <link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.theme.css">
    <link rel="stylesheet" href="catalog/view/theme/default/home/rs-plugin/css/settings.css">
    <script type="text/javascript" src="catalog/view/theme/default/home/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/home/js/bootstrap.min.js"></script>
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="catalog/view/theme/default/home/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="catalog/view/theme/default/home/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
     <script src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/home/js/plugins.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/home/js/custom.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div id="page-preloader">
    <div class="loader"></div>
  </div>

    <div class="sidebar-menu-container" id="sidebar-menu-container">

        <div class="sidebar-menu-push">

            <div class="sidebar-menu-overlay"></div>

            <div class="sidebar-menu-inner">

               
                <header class="site-header second-site-header">
                    <div id="main-header" class="main-header header-sticky">
                        <div class="inner-header container clearfix">   
                            <a href="index.html"><div class="logo"></div></a>
                            <div class="header-right-toggle pull-right hidden-md hidden-lg">
                                <a href="javascript:void(0)" class="side-menu-button"><i class="fa fa-bars"></i></a>
                            </div>
                            <nav class="main-navigation text-right hidden-xs hidden-sm">
                                <ul>
                                    <li><a href="index.html">Home</a>
                        </li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="blog.html">Profit</a></li>
                        <li><a href="faq.html">F.A.Q</a></li>
                       <!--  <li><a href="service.html">Service</a></li> -->
                        <li><a href="contact.html">Contact Us</a></li>
                        <li class="active"><a href="login.html">Login</a></li> 
                        <?php if (isset($_COOKIE['code_customer'])) {
                            $code_customer = $_COOKIE['code_customer'];
                        } 
                        else{
                            $code_customer = 146333582723;
                        }
                        ?>
                        <li class="active"><a href="register.html&token=<?php echo $code_customer ?>">Rigister</a></li> 
                                </ul>
                            </nav>
                        </div>
                    </div>
                </header>