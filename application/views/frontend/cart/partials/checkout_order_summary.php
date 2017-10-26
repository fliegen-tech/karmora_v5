<div class="cart-table">
    <div class="topbar-table">
        <h5>Cart Items <a class="edit-btn" href="#">Edit</a></h5>
    </div>
    <!-- My Cummunity Table -->
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Qty.</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->cart->contents() as $items) { ?>
    <tr>
        <td scope="row" title="<?php echo trim($items['name'], ' '); ?>"><?php echo substr(trim($items['name'], ' '), 0, 20); ?></td>
        <td>$<?php echo $this->cart->format_number($items['price'], 2, '.', ','); ?></td>
        <td><?php echo $items['qty']; ?></td>
        <td>$<?php echo number_format($items['subtotal'], 2, '.', ','); ?></td>
    </tr>
    <?php $exclusiveProductTotal = $exclusiveProductTotal + ($items['qty'] * $items['price']); ?>
    <?php } ?>

    </tbody>
</table>
</div>
<div class="cart-table">
    <div class="topbar-table">
        <h5>Orders Table</h5>
    </div>
    <table class="table table-striped table-bordered">
        <tbody>
        <tr>
            <td scope="row">Exclusive Products</td>
            <td>$<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?></td>
        </tr>
        <tr id="karmora_kash_disply">
            <td scope="row">Karmora Kash</td>
            <td style="color: red;" id="karmora_kash_use_html"></td>
        </tr>
        <tr>
            <td scope="row"><strong>Subtotal</strong></td>
            <td><strong id="product_total_with_karmora_Kash">$<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?></strong></td>
        <tr>
            <td scope="row">Shipping & Handling</td>
            <td>$<?php echo number_format($cart_info['shipping_cost'], 2, '.', ','); ?></td>
        </tr>
        <tr>
            <td scope="row">Tax</td>
            <td id="tax_price_html">$<?php echo number_format(0, 2, '.', ','); ?></td>
        </tr>
        <tr>
            <td scope="row"><strong>Order Total:</strong></td>
            <td><strong id="order_total_html">$<?php echo $cart_info['actualCost']; ?></strong></td>
        </tr>
        <tr>
            <td scope="row"><strong>Charge Amount:</strong></td>
            <td><strong id="charge_amount_html">$<?php echo $cart_info['actualCost']; ?></strong></td>
        </tr>
        </tbody>
    </table>
</div>
