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
            <?php
                if(!isset($this->session->userdata['front_data'])) {
                    $this->load->view($viewForm . 'signup_form');
                    is_null($username) ? $this->load->view($viewForm . 'referrer_form') : '';
                }
            ?>
            <div class="row">
                <div class="col-12">
                    <h2>Step 1 - Shipping Details</h2>
                </div>
            </div>

            <div class="join-now-step-one">
                <?php echo $this->load->view($viewForm . 'address_form', array('addressForm' => 'shipping_address')); ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2>Step 2 - Billing Details</h2>
                </div>
            </div>
            <div id="tax_error"></div>
            <div class="join-now-step-one">
                <?php $this->load->view($viewForm . 'address_form', array('addressForm' => 'billing_address', 'billingAddress' => TRUE, 'askName' => TRUE)); ?>
            </div>

            <div class="row">
                <div class="col-12">
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
                <div class="col-12">
                    <h2>Step 4 - Checkout</h2>
                </div>
            </div>

            <div class="join-now-step-one" id="eleminte">
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
            <?php if(!isset($this->session->userdata['front_data'])) { ?>
                <div class="row">
                    <div class="col-12">
                        <h2>Step 5 - Shopper Type</h2>
                    </div>
                </div>

                <div class="join-now-step-one">
	                <div class="join-now-step-cover">
	                	<div class="row">
		                    <div class="col-12">
		                        <div class="form-group">
		                            <label class="custom-control custom-radio">
		                              <input required="required" type="radio" class="custom-control-input" name="shopper_type" value="3">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description">Casual Shopper <span class="text-danger">*</span></span>
									</label>
		                        </div>
		                        <div class="form-group">
		                            <label class="custom-control custom-radio">
		                              <input required="required" type="radio" class="custom-control-input" name="shopper_type" value="5">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description">Premier Shopper <span class="text-danger">*</span></span>
									</label>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
            <?php } ?>

            <div class="paynow">
                <div class="col-12">
                    <div class="pay-now text-center">
                        <input type="submit" id="pay_now" name="submit" class="btn btn-joinnow left-right-hover" value="Pay Now">
                        <a href="#"><img src="<?php echo $themeUrl ?>/frontend/images/money-back.png" alt=""></a>
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


<script>
    var is_checkout = 1;
    var shiping_cost = '<?php echo $cart_info['shipping_cost']; ?>';
    var exclusiveProductTotal = '<?php echo $cart_info['exclusiveProductTotal']; ?>';
    var actualCost = '<?php echo $cart_info['actualCost']; ?>';
    var cartAmount = '<?php echo $cart_info['cartAmount']; ?>';
    var upgrade_amount = '<?php echo $upgrade_amount; ?>';
</script>
<?php $this->load->view('frontend/cart/checkout_js'); ?>

