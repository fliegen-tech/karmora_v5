<?php $shipping_cost = 0;//echo '<pre>'; print_r($this->cart->contents()); ?>
<section class="shopping-car-sect">
        <div class="container">

            <div class="cart-header">
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-6">
                        <h2>Shopping Cart</h2>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-6">
                        <a href="<?php echo base_url() . 'checkout'; ?>" class="primer-btn-join-program green-btn-cart std-cart-btn pull-right">
                            <img src="<?php echo $themeUrl ?>/images/checkout-cart-icon.png" alt="karmora checkout" />
                            Proceed to checkout
                        </a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <span class="line-spc"></span>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="custom-table table-striped tbl-cart">
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
                        <?php
                        $i = 1;
                        $y = 0
                        ?>
                        <?php foreach ($this->cart->contents() as $items): ?>

                            <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                            <tr <?php
                                if ($i & 1) {
                                    echo 'class="alt"';
                                }
                            ?>>
                                <td><img height="106" src="<?php echo $themeUrl; ?>/images/product/<?php echo $items['pic']; ?>"></td>
                                <td><?php echo $items['name']; ?><br>
                                    <small>(Karmora Kash can be redeemed at Checkout)</small>
                                <td>$<?php echo $this->cart->format_number($items['price'], 2, ',', ','); ?></td>
                                <td> <?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                                <td>$<?php echo $this->cart->format_number($items['subtotal'], 2, '.', ','); ?></td>
                                <td><a href="<?php echo base_url() . 'cart/remove/' . $items['rowid']; ?>"><i class="fa fa-trash-o"></i></a></td>

                            </tr>

        <?php $i++;
        $y++;
        ?>
    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
             <span class="line-spc"></span>
            <div class="clearfix"></div>
                    <div class="cart-buttons-group-oldc-none text-right btn-carts-none">
                    <a href="<?php echo base_url(); ?>" class="primer-btn-join-program std-cart-btn">
                        <img src="<?php echo $themeUrl ?>/images/continue-cart-icon.png" alt="karmora checkout" />
                        Continue Shopping
                    </a>

                    <div class="black-btn-cart std-cart-btn btn-resp-bottom" style="display: inline-block;">
                        <img src="<?php echo $themeUrl ?>/images/update-cart-icon.png" alt="karmora checkout" style="margin-right: 0px" />
                        <input type="submit" name="" value="update your Cart" class="btn-cart">
                    </div>
                <div class="clearfix"></div>

                <div class="pull-right">
                 <table class="grand-total-table-2">
                  <tbody>
                      <tr>
                        <td>Grand Total</td>
                        <td>$<?php echo $this->cart->format_number($this->cart->total() + $shipping_cost, 2, '.', ','); ?></td>
                      </tr>
                  </tbody>


                </table>
                </div>
                <div class="clearfix"></div>
                <a href="<?php echo base_url() .'checkout'; ?>" class="primer-btn-join-program green-btn-cart std-cart-btn">
                    <img src="<?php echo $themeUrl ?>/images/checkout-cart-icon.png" alt="karmora checkout" />
                    Proceed to checkout
                </a>




        </div>
    </section>
