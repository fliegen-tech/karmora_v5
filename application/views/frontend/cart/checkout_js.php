<script>
    function calucaltetax(){
        alert(baseurl+'calculateTax');
        var form = jQuery("#form");
            var data = form.serialize();
            jQuery.ajax({
                type: 'POST',
                url: baseurl+'calculateTax',
                data:data,
                form: form,
                context: document.body,
                error: function(data, transport) { },
                success: function(data){
                    console.info(data);
                }
            });
    }
</script>
<!--<script>
    $(document).ready(function () {
        $('#sameshipaddress').checked = false;
        $("#statesList_as_billing").attr('required', true);
        $("#billing_city2").attr('required', true);
        $("#shipping_detailaddress1").attr('required', true);
        $("#zipcode_shiiping").attr('required', true);
        $("#countriesList_shiiping").attr('required', true);
        $("#phoneList_shiiping").attr('required', true);
        
        $('#sameshipaddress').click(function (event) {
            if (this.checked) {
                $("#statesList_as_billing").attr('required', false);
                $("#billing_city2").attr('required', false);
                $("#shipping_detailaddress1").attr('required', false);
                $("#zipcode_shiiping").attr('required', false);
                $("#countriesList_shiiping").attr('required', false);
                $("#phoneList_shiiping").attr('required', false);
                $("#sameshipaddresshide").hide();
            }
            else {
                $("#sameshipaddresshide").show();
                $("#statesList_as_billing").attr('required', true);
                $("#billing_city2").attr('required', true);
                $("#shipping_detailaddress1").attr('required', true);
                $("#zipcode_shiiping").attr('required', true);
                $("#phoneList_shiiping").attr('required', true);
                $("#countriesList_shiiping").attr('required', true);
            }
            $('#sameshipaddress').checked = true;
        });


    });
</script>

<script>
    $(document).ready(function (){
        $('#karmora_cash_check').attr('checked',false);
        $('#karmora_commsion_check').attr('checked',false);
    });
    // for karmora cash
    $('#karmora_cash_check').click(function (event) {
        calucaltetax();
        setKarmoraCommission();
        setKarmoraKash();
        getproductfinal();
        setshppingcost();
    });

    // for commsion
    $('#karmora_commsion_check').click(function (event) {
        calucaltetax();
        setKarmoraKash();
        setKarmoraCommission();
        getproductfinal();
        
    });
    
    // set karmora kash
    function setKarmoraKash() {
        if ($('#karmora_cash_check').is(":checked")) {
            $("#karmora_cash_disply").show();
            $("#karmora_cash_price").show();
            var karmora_cash = $('#karmora_cash').val().split(',').join('');
            $("#karmora_kash_use").val(parseFloat(karmora_cash).toFixed(2));
            var cost = $('#actualCost_without_shipping_cost').val().split(',').join('');
            var exclusiveproductTotal_karmora_cash = cost - karmora_cash;
                exclusiveproductTotal_karmora_cash = exclusiveproductTotal_karmora_cash.toFixed(2);
            $("#exclusiveproductTotal_karmora_cash").html('$'+exclusiveproductTotal_karmora_cash);
        }
        else {
            $("#karmora_cash_disply").hide();
            $("#karmora_cash_price").hide();
            $("#karmora_kash_use").val(0.00);
        }
    }

    // set Karmora Commisison
    function setKarmoraCommission() {
        if ($('#karmora_commsion_check').is(":checked")) {
            $("#karmora_commsion_disply").show();
            $("#karmora_commsion_price").show();
            var karmora_commission = parseFloat($('#karmora_commsion').val().split(',').join(''));
            $('#karmora_commission_use').val(karmora_commission.toFixed(2));
        } else {
            $("#karmora_commsion_disply").hide();
            $("#karmora_commsion_price").hide();
            $('#karmora_commission_use').val(0.00);
        }
    }
    // set karmora kash
    function getproductfinal() {
        var order_shipping_cost = jQuery('#order_shipping_cost').val();
        //var ActualPrice = jQuery('#ordertotal').val();
        var Cost_without_shipping_cost = $('#actualCost_without_shipping_cost').val().split(',').join('');
        var actual_cost_non_edit = parseFloat($('#actual_cost_non_edit').val().split(',').join(''));
        var tax = parseFloat($('#tax_price_hidden').val().split(',').join(''));
        var karmora_cash = parseFloat($('#karmora_kash_use').val().split(',').join(''));
        var karmora_commission = parseFloat($('#karmora_commission_use').val().split(',').join(''));
        var exclusiveproductTotal_karmora_cash = Cost_without_shipping_cost - karmora_cash;
        if(Cost_without_shipping_cost > 75){
            if(exclusiveproductTotal_karmora_cash < 75){
                actual_cost_non_edit = actual_cost_non_edit + 7.95;
                $("#shipping_html").html('$'+7.95);
            }else{
                actual_cost_non_edit = actual_cost_non_edit + 0;
                $("#shipping_html").html('$'+0.00);
            }
        }
        //var exclusiveproductTotal_karmora_cash = ActualPrice - karmora_cash - order_shipping_cost;
        var ordertotaldisplay = (actual_cost_non_edit + tax  ) - karmora_cash;
        var subtotal =   actual_cost_non_edit  - karmora_cash;
        if(karmora_commission >= subtotal){
            subtotal = subtotal + tax;
        }else{
            subtotal = karmora_commission ;
        }
        console.info(actual_cost_non_edit+'actual_cost_non_edit');
        console.info(karmora_cash+'karmora_cash');
        console.info(subtotal+'subtotal');
        console.info(karmora_commission+'karmora_commission');
        
        var total_charged     = Math.abs(ordertotaldisplay - subtotal ) ;
        var test              = total_charged.toFixed(2);
        $("#karmora_cash_price").html('-$'+karmora_cash.toFixed(2));
        $("#exclusiveproductTotal_karmora_cash").html('$'+exclusiveproductTotal_karmora_cash.toFixed(2));
        $('#ordertotal-display').html('$' + ordertotaldisplay.toFixed(2));
        $("#karmora_commsion_price").html('-$'+subtotal.toFixed(2));
        $('#karmora_commsion_used_final').val(subtotal.toFixed(2));
        $("#total_charged").html('$'+total_charged.toFixed(2));
            if(test <= 0){
                $("#eleminte").hide();
                $("#checkout_2_section").show();
                $("#karmora_commsion").hide();
                //$('#PayNow').val('Submit Order');
                $('#PayNow').hide();
                $('#submit_me').show();
                $('#submit_me').val('Submit Order');
                $("#card_number").attr('required', false);
                $("#month").attr('required', false);
                $("#year").attr('required', false);
                $("#card_code").attr('required', false);
                
            }else{
               $("#eleminte").show();
               $("#checkout_2_section").hide();
               $("#karmora_commsion").show();
               $('#PayNow').show();
               $('#submit_me').hide();
               $("#card_number").attr('required', true);
               $("#month").attr('required', true);
               $("#year").attr('required', true);
               $("#card_code").attr('required', true);
                
            }
    }

    function setshppingcost(){
        if ($('#karmora_cash_check').is(":checked")) {
            var cost = $('#actualCost_without_shipping_cost').val().split(',').join('');
            var karmora_cash = $('#karmora_cash').val().split(',').join('');
            var exclusiveproductTotal_karmora_cash = cost - karmora_cash;
            if(exclusiveproductTotal_karmora_cash < 75){
                $("#shipping_html").html('$'+7.95);
                $("#order_shipping_cost").val(7.95);
            }else{
                $("#shipping_html").html('$'+0.00);
                $("#order_shipping_cost").val(0);
            }
        }
        
    }
    
</script>



<script>
    function getqty(price,product_title){
                    var tax_price = $('#tax_price_hidden').val();
                    tax_price = parseFloat(tax_price);
                    price = parseFloat(price);
                    var sum = 397 + price + tax_price;
                    sum = sum.toFixed(2);
                    sum = parseFloat(sum);
                    var you_pay = sum - 79.95;
                    $("#nona_mae_detail").show();
                    $('#sub_total_view').html('$'+sum);
                    var total_price = 79.95 + 5 + tax_price;
                    total_price = total_price.toFixed(2);
                    
                    $('#total_payed_calculate').val(total_price);
                    $('#total_coupon_code_price').html('$'+total_price);
                    $('#total_product_payment').val(sum);
                    $('#sub_total_view_la').html('$'+sum);
                    $('#total_save').html('$'+you_pay);
                    $('#total_product').html(4);
                    $('#non_mae_product_name').html(product_title);
                    $('#non_mae_product_price').html('$'+price+'.00');
    }
</script>
-->

    