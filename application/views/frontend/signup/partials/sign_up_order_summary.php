<h4>Order Summary</h4>
<table class="table table-bordered ">
    <tbody>
        <tr>
            <td>Promation Price</td>
            <td>$<?php echo number_format($signupPromo['promo_price'], 2, '.', ',')?></td>
        </tr>
        <tr>
            <td>Shipping &amp; Handling</td>
            <td>$<?php echo number_format($signupPromo['promo_shipping'], 2, '.', ',')?></td>
        </tr>
        <tr>
            <td>Tax</td>
            <td id="tax_price_html">$0.00</td>
        </tr>
        <tr>
            <td>Order Total</td>
            <td id="order_total_html">$<?php echo number_format($signupPromo['promo_price'] + $signupPromo['promo_shipping'], 2, '.', ',')?></td>
        </tr>
    </tbody>
</table>
