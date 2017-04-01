<?php echo $self->load->controller('home/page/header'); ?> 
   <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1>Contact Us</h1>
                    </div>
                    <div class="list">
                        <div class="left-shape"></div>
                        <ul>
                            <li><a href="index.html">Homepage</a> /</li>
                            <li> <a href="#">Contact Us</a></li>
                        </ul>
                        <div class="right-shape"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section class="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="message-content">
                        <div class="row">   
                            <div class="col-md-4 col-sm-12">
                                <input type="text" name="name-id" id="name-id" placeholder="First Name">
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <input type="text" name="surname-id" id="surname-id" placeholder="Last Name">
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <input type="email" name="email-id" id="email-id" placeholder="Email Address">
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <textarea name="message-id" id="message-id" placeholder="Message"></textarea>
                                <button id="submit-contact" type="button" class="button">Send Message Now <i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="company-information">
                        <h4>corporate office</h4>
                        <div class="content">
                            <ul>
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    <p >NV-318, Hiko, NV 89017 California CA</p>
                                </li>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <p style="line-height: 43px">+845 212-36209</p>
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <p style="line-height: 43px"> <a href="#">support@fundbtc.com</a></p>
                                </li>
                            </ul>
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