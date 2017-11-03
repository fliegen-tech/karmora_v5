<form method="post" id="form" name="form">
<section class="premier-signup-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Let’s Get THIS Party Started</h1>
                <p class="premier-desp1">And get you on your way to building the biggest and best shopping Community!</p>
            </div>
        </div>
        <div class="signup-cover">
            <div class="row">
                <div class="col-12 no-padding">
                    <h2>Step 1 - Shipping Details</h2>
                </div>
            </div>

            <div class="join-now-step-one">
                <div class="join-now-step-cover">
                    <?php echo $this->load->view($viewForm . 'address_form', array('addressForm' => 'shipping_address')); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 no-padding">
                    <h2>Step 2 - Billing Details</h2>
                </div>
            </div>
            <div id="tax_error"></div>
            <div class="join-now-step-one">
                <div class="join-now-step-cover">
                    <?php $this->load->view($viewForm . 'address_form', array('addressForm' => 'billing_address', 'billingAddress' => TRUE, 'askName' => TRUE)); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 no-padding">
                    <h2>Step 3 - Apply Available Funds</h2>
                </div>
            </div>

            <div class="join-now-step-one">
                <div class="join-now-step-cover">
                    <div class="available-funds-cover">
                        <div class="row">

                            <?php $this->load->view('frontend/cart/partials/checkout_apply_funds'); ?>
                            <div class="col-5">
                                <?php $this->load->view('frontend/cart/partials/checkout_order_summary'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 no-padding">
                    <h2>Step 4 - Checkout</h2>
                </div>
            </div>

            <div class="join-now-step-one">
                <div class="join-now-step-cover">
                    <div class="row">
                        <div class="col-6">
                            <div class="order-leftbar">
                                <?php $this->load->view($viewForm . 'credit_card_form_fields'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="paynow">
                <div class="col-12">
                    <div class="pay-now text-center">
                        <input type="submit" name="submit" value="submit check">
                        <a onclick="calucaltetax()"  class="btn btn-joinnow left-right-hover">Pay Now</a>
                        <a href=""><img src="<?php echo $themeUrl ?>/frontend/images/money-back.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" name="karmora_kash_use" id="karmora_kash_use" value="" />
<input type="hidden" name="karmora_commission_use" id="karmora_commission_use" value="" />
<input type="hidden" name="ordertotal" id="ordertotal" value="<?php echo $cart_info['actualCost'] + $upgrade_amount; ?>" />
<input type="hidden" name="tax_price"  id="tax" value="0" />
<input type="hidden" name="karmora_mikamak677" value="<?php echo $this->security->get_csrf_hash();?>" />
</form>
<!--====  End of Join Now ====-->




<?php $this->load->view('frontend/cart/checkout_js'); ?>

