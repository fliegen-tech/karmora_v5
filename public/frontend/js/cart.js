$("#cart_form").submit(function () {
    alert('aya');
    var link = baseurl + "cart/";
    var id = $(this).find('input[name=product_id]').val();
    var shoper_type = $('select[name=shoper_type]').val();
    var qty = $(this).find('input[name=quantity]').val();
    var shoper_array =  shoper_type.split('=');
    var shopper_account_type  = shoper_array[0];
    var shopper_account_type_price  = shoper_array[1];
    console.info('shopper_account_type_price = '+shopper_account_type_price);
    console.info('id = '+id);
    console.info('qty = '+qty);
    console.info('shopper_account_type = '+shopper_account_type);
    $.post(link + 'product_cart', {
        product_id: id,
        quantity: qty,
        shopper_account_type: shopper_account_type,
        shopper_account_type_price: shopper_account_type_price,
        ajax: '1',
        "karmora_mikamak677": csrfHash
    },
    function (data) {
        console.info(data);//alert(shopper_recurning_time);
        return false;
        if (data.html == 'true') {
            $.get(link + "cart_message", function (cart) { // Get the contents of the url cart/show_cart
                window.location.href = baseurl + "cart/show_cart";
                //baseurl +'https://www.karmora.com/1003/cart/show_cart';
                $("#cart_content").html(cart); // Replace the information in the div #cart_content with the retrieved data
            });
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

