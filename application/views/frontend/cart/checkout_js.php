<script>
    function calucaltetax() {
        makeRequieedOnSameAs();
        jQuery('#tax_price_html').html('');
        jQuery('#tax').val(0);
        jQuery('#tax_error').html('');
        var form = jQuery("#form");
        var data = form.serialize();
        jQuery.ajax({
            type: 'POST',
            url: baseurl + 'calculateTax',
            data: data,
            form: form,
            context: document.body,
            error: function (data, transport) {
                console.info(data);
            },
            success: function (data) {
                console.info(data);
                if (data == 'error') {
                    $('#sameshipaddress').checked = false;
                    jQuery('#tax_error').focus();
                    jQuery("#tax_error").html('<div class="alert alert-danger">The Provided Address Is incorrect </div>');
                } else {
                    var tax_price = parseFloat(data).toFixed(2);
                    jQuery('#tax_price_html').html('$' + tax_price);
                    jQuery('#tax').val(data);
                }
                if(is_checkout == 1){
                    finilizecheckout();
                }else{
                    finilizeothers();
                }
            }
        });
    }
</script>
<script>
    $('#karmora_kash_checkBox').click(function (event) {
        setKarmoraCommission();
        setKarmoraKash();
        finilizecheckout();
    });
    $('#karmora_commsion_checkBox').click(function (event) {
        setKarmoraKash();
        setKarmoraCommission();
        finilizecheckout();
    });
    // set karmora kash
    function setKarmoraKash() {
        if ($('#karmora_kash_checkBox').is(":checked")) {
            var karmora_kash = $('#karmora_kash').val().split(',').join('');
            var exclusiveproductTotal_karmora_cash = cartAmount - karmora_kash;
            var karmora_kash = parseFloat(karmora_kash);
            $("#karmora_kash_disply").show();
            $("#karmora_kash_use").val(karmora_kash.toFixed(2));
            $("#karmora_kash_use_html").html('$' + karmora_kash.toFixed(2));
            $("#product_total_with_karmora_Kash").html('$' + exclusiveproductTotal_karmora_cash.toFixed(2));
        }
        else {
            $("#karmora_kash_disply").hide();
            $("#karmora_kash_use").val(0.00);
        }
    }

    // set Karmora Commisison
    function setKarmoraCommission() {
        if ($('#karmora_commsion_checkBox').is(":checked")) {
            var karmora_commission = parseFloat($('#karmora_commsion').val().split(',').join(''));
            var karmora_commission = parseFloat(karmora_commission);
            $("#karmora_commsion_disply").show();
            $("#karmora_commission_use").val(karmora_commission.toFixed(2));
            $("#karmora_commsion_use_html").html('$' + karmora_commission.toFixed(2));
        } else {
            $("#karmora_commsion_disply").hide();
            $("#karmora_commission_use").val(0.00);
        }
    }
</script>
<script>
function finilizecheckout() {
        var tax = parseFloat($('#tax').val().split(',').join(''));
        var karmora_cash         = (($('#karmora_kash_use').val().split(',').join('') !='') ? parseFloat($('#karmora_kash_use').val().split(',').join('')) : 0);
        var karmora_commission   = (($('#karmora_commission_use').val().split(',').join('') !='') ? parseFloat($('#karmora_commission_use').val().split(',').join('')) : 0);
        var convertto_nmbr       = +upgrade_amount + +exclusiveProductTotal;
        var exclusiveproductTotal_karmora_cash = convertto_nmbr - karmora_cash;
        var convert2tonmbr                     = +upgrade_amount + +actualCost;
        var ordertotaldisplay = ( parseFloat(convert2tonmbr) + parseFloat(tax)  ) - karmora_cash;
        var amount_caluation  =   parseFloat(convert2tonmbr)  - parseFloat(karmora_cash);
        if(karmora_commission >= amount_caluation){
            amount_caluation = amount_caluation + tax;
        }else{
            amount_caluation = karmora_commission ;
        }
        var total_charged         = Math.abs(ordertotaldisplay - amount_caluation ) ;
        var payable_amount        = total_charged.toFixed(2);
        $("#karmora_cash_price").html('-$'+karmora_cash.toFixed(2));
        $("#product_total_with_karmora_Kash").html('$'+exclusiveproductTotal_karmora_cash.toFixed(2));
        $('#order_total_html').html('$' + ordertotaldisplay.toFixed(2));
        $("#karmora_commsion_use_html").html('-$'+amount_caluation.toFixed(2));
        $("#charge_amount_html").html('$'+total_charged.toFixed(2));
        if(payable_amount <= 0){
            $(".card-fileds").prop('required',false);
            $("#eleminte").hide();
            $('#pay_now').text("Save Order");
        }else{
            $("#eleminte").show();
            $(".card-fileds").prop('required',true);
            $('#pay_now').text("Pay Now");
        }
    }
</script>
<script>
    function finilizeothers() {
        var tax = parseFloat($('#tax').val().split(',').join(''));
        var exclusiveproductTotal_karmora_cash       = +upgrade_amount + +shiping_cost;
        var ordertotaldisplay                        = ( parseFloat(exclusiveproductTotal_karmora_cash) + parseFloat(tax)  );
        $('#order_total_html').html('$' + ordertotaldisplay.toFixed(2));
        $('#charge_amount_html').html('$' + ordertotaldisplay.toFixed(2));
    }
</script>
<script>
    function makeRequieedOnSameAs() {
        if($('#sameshipaddress').is(":checked")) {
                $('#address-form-billing_address').hide();
                $(".billing_address").prop('required',false);
        }else{
            $('#address-form-billing_address').show();
            $(".billing_address").prop('required',true);
        }
    }
</script>
<script>
    $(document).ready(function(){
        $("input[name='fullname']").on("keyup",function () {
            //alert($(this).val());
            $("input[name='billing_address[name]']").val('');
            $("input[name='billing_address[name]']").val($(this).val());
        });
    });
</script>


    