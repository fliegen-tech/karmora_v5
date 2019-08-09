<!--=========================================
   =            Join Now           =
   ==========================================-->
<section class="premier-signup-sec page-spacing">
    <div class="container">
        <div class="row">
            <?php echo $this->session->flashdata($flashKey); ?>
            <div class="col-12">
                <h1>Let’s Get THIS Party Started</h1>
                <p class="premier-desp1">And get you on your way to building the biggest and best shopping Community!</p>
            </div>
        </div>
        <div class="signup-cover">
            <?php
            echo form_open(base_url('join-premier'),array('id'=>'form','method'=>'post'));
            ?>
            <div class="row">
                <div class="col-12">
                    <h2>STEP 1: Choose Your Exclusive Product!</h2>
                </div>
            </div>
            <?php $this->load->view($view . 'partials/product_list'); ?>
            <div class="row">
                <div class="col-12">
                    <h2>STEP 2: Tell Us A Little Bit About You!</h2>
                </div>
            </div>

            <?php
            $this->load->view($viewForm . 'signup_form');
            is_null($username) ? $this->load->view($viewForm . 'referrer_form') : '';
            ?>

            <div class="join-now-step-one">
                <h4>Please Enter Your Shipping Address</h4>
                <?php echo $this->load->view($viewForm . 'address_form', array('addressForm' => 'shipping_address')); ?>
            </div>

            <div class="join-now-step-one">
                <h4>Please Enter Your Billing Address</h4>
                <?php $this->load->view($viewForm . 'address_form', array('addressForm' => 'billing_address', 'billingAddress' => TRUE, 'askName' => TRUE)); ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2>STEP 3: LET’S DO THIS THING!</h2>
                </div>
            </div>

            <div class="join-now-step-one join-now-cover-checkout">
                <h4>Complete Your Order</h4>
                <div class="join-now-step-cover">
                    <div class="row">
                        <div class="col-6 order2">
                            <div class="order-leftbar">
                                <?php echo $this->load->view($viewForm . 'credit_card_form_fields'); ?>
                                <div class="total-charges">
                                    <div class="row">
                                        <div class="col-6">
                                            <h3>Total Charged</h3>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a id="charge_amount_html" href="#" class="btn btn-joinnow left-right-hover">$<?php echo number_format($signupPromo['promo_price'] + $signupPromo['promo_shipping'], 2, '.', ',') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="privacy-policy-cover">
                                    <div class="form-group">
                                        <label class="">
                                            <input  type="checkbox" value="accept" name="read_agreement" required="">
                                            I have read, understand and agree to the below documents:
                                        </label>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#trial-membership-agreement">Premier Shopper Trial Membership Agreement</a>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#term-of-use">Premier Shopper Terms of Use</a>
                                    </div>
                                </div>
                                <div class="paynow">
                                    <div class="row">
                                        <div class="col-4">
                                            <input class="btn btn-joinnow left-right-hover" type="submit" name="submit" value="Pay Now">
                                        </div>
                                        <div class="col-8 text-right">
                                            <ul class="list-inline">
                                                <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)"><img src="<?php echo $themeUrl; ?>/frontend/images/question-compostation.png"> Have Questions?</a></li>
                                                <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)"><img src="<?php echo $themeUrl; ?>/frontend/images/chat.png"> Chat with Us</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 order1">
                            <div class="order-rightbar">
                                <?php $this->load->view($view . 'partials/sign_up_order_summary'); ?>
                                <div class="make-money-cover">
                                    <img src="<?php echo $themeUrl; ?>/frontend/images/money-back.png" />
                                    <h3>Good Karmora 100% Money Back Gurantee!</h3>
                                    <p>Your purchase is protected by our Exclusive Product 30 Day No Questions Asked Money Back Guarantee!   If you are not happy with your purchase for any reason during the first 30 Days simply open a <a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)">live chat</a> or call (844) KAR-MORA and we will process your return for a full refund.   It's just Good Karmora!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tax_price"  id="tax" value="0" />
            <input type="hidden" name="ordertotal" id="ordertotal" value="<?php echo number_format($signupPromo['promo_price'] + $signupPromo['promo_shipping'], 2, '.', ',')?>">
            <?php
            echo form_close();
            ?>
        </div>
    </div>
</section>
<script>
    var is_checkout = 0;
    var shiping_cost = '<?php echo $signupPromo['promo_shipping']; ?>';
    var upgrade_amount = '<?php echo $signupPromo['promo_price']; ?>';
</script>
<?php $this->load->view('frontend/cart/checkout_js'); ?>
<!--====  End of Join Now ====-->