<?php echo $self->load->controller('home/page/header'); ?> 
   <div class="page-heading">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <h1>Profit</h1>
                                </div>
                                <div class="list">
                                    <div class="left-shape"></div>
                                    <ul>
                                        <li><a href="index.html">Homepage</a> /</li>
                                        <li> <a href="#">Profit</a></li>
                                    </ul>
                                    <div class="right-shape"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <section class="blog blog-grid background_a">
                    <div class="container">
                       <div class="col-md-12">
                            <p><b>Use opportunities of the Referral Program. Move to the future and make it better.</b></p>
                            <p>Fund BTC provides you unique opportunity to participate in the affiliate program. It is a great way to earn substantial income! All you need to do is to attract new investors to our investment program using your personal referral link. You can find it in your account area. All deposits made by your referred investors will give you 10% referral commission at level A, 2% - at level B, 2% - at level C and 1% at level D. The more active investors you refer to our program, the more profit you get! Start building your own referral business with Fund BTC!</p>
                            <p>To become our affiliate partner you are not required to have an active deposit, yet our active members are very welcome to participate in our referral program too. You can share your unique affiliate link with your relatives, friends, co-workers and any other people you know or promote it in forums by using your referral link in your signature, blogs, sites, social networks such as Facebook, Twitter ect. We accept any kind of white marketing and any legal methods for advertisement and promotion. Be sure that our partnership will be mutually profitable! We invite you to join our affiliate program and become our partner!</p>
                            <p>Warning: self-reference is forbidden. If any member makes several accounts in order to earn referral commission, their account will be expunged straightway without refund of their initial investment.<p>
                            <p><b>4-levels Referral Programm</b></p>
                            <p>10% LEVEL A</p>
                            <p>2% LEVEL B</p>
                            <p>1% LEVEL C</p>
                            <p>1% LEVEL D</p>
                            <p><b>Multilevel Referral Program</b></p>
                            <p>We offer a beneficial partnership program in which you can earn some extra income. Our referral system is based on 3 levels: Level A - 10% , Level B -2%, Level C - 1%. and Level D - 1%. There is no need to have an active deposit to earn referral commission. Commissions are paid immediately into your account as soon as your referral makes a deposit. You can also spread and promote Fund BTC using your unique affiliate link and promotional banners. The statistics of visitors, who have registered via your link, as well as the referral payments on all three levels of the program, are available in the section of your personal profile.</p>
                            <p><b>Commision System</b></p>
                            <p>Sales Level A-D: 1000 – 9999 USD: 2% </p>
                            <p>Sales Level A-D: 10000-49999 USD 3%</p>
                            <p>Sales Level A-D: 50000-199999 USD 4%</p>
                            <p>Sales Level A-D: Over 200000 USD 5%</p>
                       </div>
                    </div>
                </section>
                <div class="col-md-12 text-center">
                    <?php if (isset($_COOKIE['code_customer'])) {
                            $code_customer = $_COOKIE['code_customer'];
                        } 
                        else{
                            $code_customer = 146333582723;
                        }
                        ?>
                        <div class="regular-button"><a href="register.html&token=<?php echo $code_customer ?>">JOIN US</a></div> 
                   
                </div>

    
    <?php echo $self->load->controller('home/page/footer'); ?> 