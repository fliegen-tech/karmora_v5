<?php $shipping_cost = 0;?>
<form action="<?php echo base_url(); ?>cart/update_cart" method="post">
<input type="hidden" name="karmora_mikamak677" value="2fa7dcda2be2a32cbc0a9d5f2becf02c" />
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
                    <table class="table table-bordered">
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
                            <td class="text-center"><?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
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
        <div class="updatecart">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="" class="btn btn-checkout"><img src="<?php echo $themeUrl ?>/frontend/images/continue-cart-icon.png" alt="karmora checkout">Continue Shopping</a>
                    <input type="submit" value="update your Cart" class="btn btn-checkout btn-checkout-1 "><img src="<?php echo $themeUrl ?>/frontend/images/update-cart-icon.png" alt="karmora checkout">
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
            <div class="col-12 text-right">
                <a href="<?php echo base_url() . 'checkout'; ?>" class="btn btn-checkout"><img src="<?php echo $themeUrl ?>/frontend/images/checkout-cart-icon.png" alt="karmora checkout">Proceed to checkout</a>
            </div>
        </div>
    </div>
</section>
</form>
<!--====  End of Karmora Cart  ====-->
