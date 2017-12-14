<?php if (!$this->cart->contents()): ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="alert alert-info col-12">
                    <?php echo 'Your Shopping Cart is empty.'; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
else:$shipping_cost = 0; ?>
<?php echo form_open(base_url('cart/update_cart')); ?>
<section class="cart-sec page-spacing">
    <div class="container">
        <div class="checkout-tobar">
            <div class="row">
                <div class="col-6 text-left">
                    <h3>Shopping Cart</h3>
                </div>
                <div class="col-6 text-right">
                    <a href="<?php echo base_url() . 'checkout'; ?>" class="btn btn-checkout"><img src="<?php echo $themeUrl ?>/frontend/images/checkout-cart-icon.png" alt="karmora checkout">Proceed to checkout</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="karmora-table cart-table" id="cart-table">
                    <!-- My Cummunity Table -->
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Unit Price</th>
                            <th>Qty.</th>
                            <th>Sub Total</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($this->cart->contents() as $items): ?>
                        <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                        <tr>
                            <td scope="row" class="text-center"><img src="<?php echo $themeUrl; ?>/images/product/<?php echo $items['pic']; ?>" alt=""></td>
                            <td><?php echo $items['name']; ?> <small>(Karmora Kash can be redeemed at Checkout)</small></td>
                            <td class="text-center">$<?php echo $this->cart->format_number($items['price'], 2, ',', ','); ?></td>
                            <?php if(!isset($this->session->userdata['front_data'])){ ?>
                            <td class="text-center">1</td> <?php }else{ ?>
                            <td class="text-center"><?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                            <?php } ?>
                            <td class="text-center">$<?php echo $this->cart->format_number($items['subtotal'], 2, '.', ','); ?></td>
                            <td class="text-center"><a href="<?php echo base_url() . 'cart/remove/' . $items['rowid']; ?>"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if($upgrde_data){ $this->load->view('frontend/cart/partials/product_upgrade'); } ?>
                        </tbody>
                    </table>
                    <!-- End My Cummunity Table -->
                </div>
            </div>
        </div>
        <?php if(isset($this->session->userdata['front_data']) && $this->session->userdata['front_data']['user_account_type_id'] == 3){ ?>
        <div class="update-cart">
            <div class="col-12 text-center">
                <h3>Hold On Just a Second!</h3>
                <p>Want to save over 25%? Upgrade today to a Premier Shopper!</p>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="text-right">
                        <a href="<?php echo base_url(); ?>" class="btn btn-joinnow left-right-hover">Learn More</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-left">
                        <a href="<?php echo base_url('karmora-upgrade'); ?>" class="btn btn-joinnow left-right-hover">Upgrade Now</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="updatecart">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="<?php echo base_url(); ?>" class="btn btn-checkout"><img src="<?php echo $themeUrl ?>/frontend/images/continue-cart-icon.png" alt="karmora checkout">Continue Shopping</a>
                    <input type="submit" value="update your Cart" class="btn btn-checkout btn-checkout-1"><!-- <img src="<?php echo $themeUrl ?>/frontend/images/update-cart-icon.png" alt="karmora checkout"> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pull-right">
                    <table class="grand-total-table-2">
                        <tbody>
                        <tr>
                            <td>Grand Total</td>
                            <td>$<?php echo $this->cart->format_number($this->cart->total() + $shipping_cost + $upgrade_amount, 2, '.', ','); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right checkout-proced">
                <a href="<?php echo base_url() . 'checkout'; ?>" class="btn btn-checkout"><img src="<?php echo $themeUrl ?>/frontend/images/checkout-cart-icon.png" alt="karmora checkout">Proceed to checkout</a>
            </div>
        </div>
    </div>
</section>
<?php echo form_close(); endif; ?>
<!--====  End of Karmora Cart  ====-->
