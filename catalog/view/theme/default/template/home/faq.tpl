<?php echo $self->load->controller('home/page/header'); ?> 
    <!-- /.mainmenu-area -->
    <div class="page-heading">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <h1>F.A.Q</h1>
                                </div>
                                <div class="list">
                                    <div class="left-shape"></div>
                                    <ul>
                                        <li><a href="index.html">Homepage</a> /</li>
                                        <li> <a href="#">F.A.Q</a></li>
                                    </ul>
                                    <div class="right-shape"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <section class="sec-padding faq-home faq-page bg-color-111 tp-pt80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--Accordion Box-->
                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">What is Fundbtc ?</div>
                        <div class="faqTxt">
                            <p>We include many leader more than 10 years of experience in the development new crypto currency launched on the market for several years now. Currently we gathered to jointly launched a support fund to provide the highest profits for investors. This fund will invest in the latest developments such as create new crypto currency,mining coins, Bitcoin Stock Exchange, the first invest in the latest invention in order to bring the average return of 5% a day. Currently, we have created a capital fund 20 million dollars, with a capital of this fund we are confident will provide the best returns for investors.</p>
                        </div>
                    </div>
                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">Who manages the investment portfolio?</div>
                        <div class="faqTxt">
                            <p> The investment portfolio is managed by our team of financial specialists with strong command in finance allows for effective analysis of the market and financial situation. The Company employs experts on the full-time basis who have been working on the currency exchange market for more than 7 years on average. Our financial team also includes specialists who are experts in evaluating new private businesses called start-ups which have most chances to grow into large-scale and highly profitable enterprises.</p>
                        </div>
                    </div>
                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">What do I need to do to become a client of Fundbtc?</div>
                        <div class="faqTxt">
                            <p>you need to open a free account. 
It doesn't take much time, but you will get an opportunity to become an investor and earn profit.
Please check our <a href="index436d.html?a=cust&amp;page=getstarted" class="read_more">Get Started </a> page for more details.</p>
                        </div>
                    </div>
                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">How many accounts can I create from one Computer?</div>
                        <div class="faqTxt">
                            <p>You can create 3 (three) separate accounts from your computer and your IP address and one account for your family. If we find more accounts used through the same IP address, we can suspend your account temporarily.<br>
                        All account should have different ewallet and email data.</p>
                        </div>
                    </div>

                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">How can I change my personal information in my account?</div>
                        <div class="faqTxt">
                            <p>Log into the account and click "Edit Account" to enter the personal information page where you will be able to modify your data. Save the changes when all necessary data are entered. 
However, you may not modify your e-mail and e-wallet because this function is disabled for security reasons. If you want to change these data, please contact us and include your secret questions and secret answer in your message.</p>
                        </div>
                    </div>

                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">I can't log in into my account. What could cause this problem?</div>
                        <div class="faqTxt">
                            <p>Sometimes problems of this kind are caused by errors of your web browser. There is no reason to worry, you just need to wait a few minutes and then try to log in again. First of all you need to clean the cache of your web browser. 
If the problem persists, please contact our online manager. </p>
                        </div>
                    </div>
                    
                    <div class="singleFaq animated fadeInUp" style="opacity: 1;">
                        <div class="faqTitle h4">How secure is your website and my account data?</div>
                        <div class="faqTxt">
                            <p>We have a wide range of security measures to protect your account. Our website is protected against DDoS attacks, all transferred data are SSL-encrypted and we use a licensed script, we are also using a few of online security certificates, you are able to see most of them in our main page.
Our website is located on a dedicated server with a firewall installed on it.</p>
                        </div>
                    </div>
                </div>
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