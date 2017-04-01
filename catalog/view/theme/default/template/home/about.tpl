<?php echo $self->load->controller('home/page/header'); ?> 
<div class="page-heading">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <h1>About Us</h1>
                                </div>
                                <div class="list">
                                    <div class="left-shape"></div>
                                    <ul>
                                        <li><a href="index.html">Homepage</a> /</li>
                                        <li> <a href="#">About Us</a></li>
                                    </ul>
                                    <div class="right-shape"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <section class="why-choose-us about-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="sub-section-heading">
                                    <h2>Why choose us?</h2>
                                    <div class="line-dec"></div>
                                    <p>FunBTC - We include many leader (US, China, India, Japan, Russia, Germany, Brazil, France, England, Mexico, Italy, Korea, Canada, Spain, Turkey, Indonesia, Australia, Poland, Netherlands, Saudi Arabia, Philippins, Malaysia...) more than 10 years of experience in the development new crypto currency launched on the market for several years now. Currently we gathered to jointly launched a support fund to provide the highest profits for investors. This fund will invest in the latest developments such as create new crypto currency,mining coins, Bitcoin Stock Exchange, the first invest in the latest invention in order to bring the average return of 5% a day. Currently, we have created a capital fund 20 million dollars, with a capital of this fund we are confident will provide the best returns for investors.</p>
                                    
                            <br/>
                            
                                </div>
                                
                            </div>
                            <div class="col-md-5">
                                <div class="right-image">
                                    <img src="catalog/view/theme/default/images/1475057237bitcoin.jpg" alt="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <p><b><i class="fa fa-user" aria-hidden="true"></i>   Top Leader say about FundBTC: </b></p>
                            <hr>    
                            <p>
                            <b>Hugh Grosvenor:</b> <i>”I have invested 800,000 $ in FundBtc long time,  i hope my team will grow strong.”</i>
                            <br>
                            <hr>
                            <b>Matthew Turcotte:</b> <i>“This is a community program very good so i have invested in FundBtc 500,000 $”</i>
                            <br>
                            <hr>
                            <b>Robert Nay:</b> <i>“I understand the value of FundBtc, it is working well on the project feasible, i invested 450,000 $”</i>
                            <br>
                            <hr>
                            <b>Naveen Selvadurai:</b> <i>“I made mistakes, but now i believe FundBtc is on track so i invest 1,200,000 $ not pay back”</i>
                            <br>
                            <hr>
                            <b>Yifu Gou:</b> <i>“ I love crypto currency,  i love FunBtc, the best place to invest in now”</i>
                            <br>
                            <hr>
                            And more leaders.</p>
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
                <!-- <section class="services-about-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="building.html"><div class="service-item">
                                    <img src="catalog/view/theme/default/home/images/special-icon-1.png" alt="">
                                    <h4>Building Construct</h4>
                                    <div class="line-dec"></div>
                                    <p>Sed sed massa aliquet est tempus tincidunt nun idle tinidunt arcu ids egestas vulputate acenas purus mecenas, maximus.</p>
                                </div></a>
                            </div>
                            <div class="col-md-4">
                                <a href="renovation.html"><div class="service-item">
                                    <img src="catalog/view/theme/default/home/images/special-icon-2.png" alt="">
                                    <h4>Renovation</h4>
                                    <div class="line-dec"></div>
                                    <p>Sed sed massa aliquet est tempus tincidunt nun idle tinidunt arcu ids egestas vulputate acenas purus mecenas, maximus.</p>
                                </div></a>
                            </div>
                            <div class="col-md-4">
                                <a href="design.html"><div class="service-item">
                                    <img src="catalog/view/theme/default/home/images/special-icon-3.png" alt="">
                                    <h4>Interior Design</h4>
                                    <div class="line-dec"></div>
                                    <p>Sed sed massa aliquet est tempus tincidunt nun idle tinidunt arcu ids egestas vulputate acenas purus mecenas, maximus.</p>
                                </div></a>
                            </div>
                        </div>
                    </div>
                </section> -->
<?php echo $self->load->controller('home/page/footer'); ?> 