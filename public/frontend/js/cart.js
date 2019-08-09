$("#cart_form").submit(function () {
    var link = baseurl + "cart/";
    var id = $(this).find('input[name=product_id]').val();
    var shoper_type = $('select[name=shoper_type]').val();
    var qty = $(this).find('input[name=quantity]').val();
    var shoper_array =  shoper_type.split('=');
    var shopper_account_type  = shoper_array[0];
    var shopper_account_type_price  = shoper_array[1];
    $.post(link + 'product_cart', {
        product_id: id,
        quantity: qty,
        shopper_account_type: shopper_account_type,
        shopper_account_type_price: shopper_account_type_price,
        ajax: '1',
        "karmora_mikamak677": csrfHash
    },
    function (data) {
        if (data.html == 'true') {
            $("#cart_content").html('<div class="alert alert-success"><strong>Success!</strong> You have added an Exclusive Product into your Shopping Cart. <a href="'+baseurl +'cart/show_cart">View Cart</a></div>'); // Replace the information in the div #cart_content with the retrieved data
            $("html, body").animate({
                scrollTop: 0
            }, 5000);
        } else {
            alert("Product does not exist");
        }// Interact with returned data
    }, 'json');
    return false; // Stop the browser of loading the page defined in the form "action" parameter.
});


$(".empty").click(function () {
    var link = baseurl + "cart/";
    $.get(link + "empty_cart", function () {
        $.get(link + "cart_message", function (cart) {
            $("#cart_content").html(cart);
        });
    });

    return false;
});

