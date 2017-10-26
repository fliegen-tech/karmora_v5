<?php $exclusiveProductTotal = 0; $shipping_cost = 0; ?>
<?php $actualCost_without_shipping_cost = number_format($this->cart->total()  , 2, '.', ',');?>
<?php $actualCost = number_format($this->cart->total() + $shipping_cost , 2, '.', ',');?>
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
        <tr>
            <td scope="row"><strong>Subtotal</strong></td>
            <td><strong>$<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?></strong></td>
        <tr>
            <td scope="row">Shipping & Handling</td>
            <td>$<?php echo number_format($shipping_cost, 2, '.', ','); ?></td>
        </tr>
        <tr>
            <td scope="row">Tax</td>
            <td>$<?php echo number_format(0, 2, '.', ','); ?></td>
        </tr>
        <tr>
            <td scope="row"><strong>Order Total:</strong></td>
            <td><strong>$<?php echo $actualCost; ?></strong></td>
        </tr>
        <tr>
            <td scope="row"><strong>Charge Amount:</strong></td>
            <td><strong>$<?php echo $actualCost; ?></strong></td>
        </tr>
        </tbody>
    </table>
</div>
