<?php $route=$self -> request -> get['route']; ?>
<div class="left-side-menu">
            <!--  Menu -->
    <div class="sidebar-menu">
        <ul>
            
            <li class="has-sub">
                <a class="waves-effect waves-light" href="home.html"> <i class="layout-icon icon_house_alt" aria-hidden="true"></i> <span>Dashboard</span> </a>
                
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="investment.html"> <i class="layout-icon icon_menu-square_alt2" aria-hidden="true"></i><span> Investment </span></a>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="refferal"> <i class="layout-icon icon_ul" aria-hidden="true"></i><span> Refferals </span></a>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="column-tree.html"> <i class="layout-icon icon_flowchart" aria-hidden="true"></i><span> Column Tree </span></a>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="row-tree.html"> <i class="layout-icon icon_easel" aria-hidden="true"></i><span> Row Tree </span></a>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="news.html"> <i class="layout-icon icon_book_alt" aria-hidden="true"></i><span> New </span></a>
            </li>
            
            <li class="has-sub">
                <a class="waves-effect waves-light" href="javascript:void(0)"> <i class="layout-icon icon_ribbon_alt" aria-hidden="true"></i><span> Profit History </span><span class="arrow_carrot-right" aria-hidden="true"></span></a>
                <ul class="site-menu-sub">
                    <li><a class="waves-effect waves-light" href="everyday-profit.html">Daily Profit</a></li>
                    <li><a class="waves-effect waves-light" href="binary-profit.html">Pairing Bonus</a></li>
                    <li><a class="waves-effect waves-light" href="refferal-profit.html">Refferal Profit</a></li>
                </ul>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="javascript:void(0)"> <i class="layout-icon icon_id" aria-hidden="true"></i><span> Account </span><span class="arrow_carrot-right" aria-hidden="true"></span></a>
                <ul class="site-menu-sub">
                    <li><a class="waves-effect waves-light" href="your-profile.html">Your Profiles</a></li>
                    <li><a class="waves-effect waves-light" href="change-login-password.html">Change Password</a></li>
                    <li><a class="waves-effect waves-light" href="your-wallet.html"><?php echo $lang['text_wallet']; ?></a></li>
                </ul>
            </li>
            <li class="has-sub">
                <a class="waves-effect waves-light" href="logout.html"> <i class="layout-icon icon_lock_alt" aria-hidden="true"></i><span> <?php echo $lang['logout']; ?> </span></a>
            </li>
            
            
            
        </ul>
    </div>
    <div class="clearfix"></div>
    <!--  Help Box -->
    <div class="sitebar-footer">
        <!-- <a href="features/login.html" data-placement="top" data-toggle="tooltip" data-original-title="Login">
            <i class="icon  icon_lock-open_alt" aria-hidden="true"></i>
        </a>
        <a href="features/register.html" data-placement="top" data-toggle="tooltip" data-original-title="Register">
            <i class="icon icon_key_alt" aria-hidden="true"></i>
        </a>
        <a href="features/lockscreen.html" data-placement="top" data-toggle="tooltip" data-original-title="Lock Screen">
            <i class="icon icon_lock_alt" aria-hidden="true"></i>
        </a>
        <a href="features/mailbox.html" data-placement="top" data-toggle="tooltip" data-original-title="Mail">
            <i class="icon icon_mail_alt" aria-hidden="true"></i>
        </a> -->
    </div>
</div>