<h4>Order Summary</h4>
<table class="table table-bordered ">
    <tbody>
        <tr>
            <td></td>
            <td>$<?php echo number_format($signupPromo['promo_price'], 2, '.', ',')?></td>
        </tr>
        <tr>
            <td>Coupon Code</td>
            <td>
                <input type="text" class="form-control" placeholder="Please enter Coupon Code">
            </td>
        </tr>
        <tr>
            <td>Shipping &amp; Handling</td>
            <td>$<?php echo number_format($signupPromo['promo_shipping'], 2, '.', ',')?></td>
        </tr>
        <tr>
            <td>Tax</td>
            <td>$0.00</td>
        </tr>
        <tr>
            <td>Order Total</td>
            <td>$<?php echo number_format($signupPromo['promo_price'] + $signupPromo['promo_shipping'], 2, '.', ',')?></td>
        </tr>
    </tbody>
</table>