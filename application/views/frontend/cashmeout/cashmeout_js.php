<?php if ($this->session->flashdata('checkout')) { ?>
    <script type="text/javascript">
        $(window).load(function () {
            $('#Successmessage').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        });
    </script>
<?php } ?>

<script>
    $('#gift_check').click(function () {
        if ($('#gift_check').is(':checked')) {
            donateCheck();
            $('.check-donate-mac').show();
        } else if ($('#gift_check').not(':checked')) {
            setCashouttoTotal();
            $('.check-donate-mac').hide();
        }
    });
    $('#amount').blur(function () {
        donateCheck();
    });
    function donateCheck() {
        updateCashoutAmount();
    }
    function updateCashoutAmount() {
        giftAmount = isNumber($("#amount").val()) && $("#amount").val() > 0 ? $("#amount").val() : 0;
        cashoutAmount = <?php echo $TotalAvailable; ?>;
        minAmout = <?php echo $minCashout; ?>;
        newCashoutAmount = cashoutAmount - giftAmount;
        newCashoutAmount = newCashoutAmount.toFixed(2);
        if (newCashoutAmount >= minAmout) {
            setCashouttoNew();
        } else {
            alert('Minimum check value to cash out must be more than $' +<?php echo number_format($minCashout, 2, '.', ',')  ?> + ' ');
            setCashouttoTotal();
        }
    }
    function setCashouttoNew() {
        $("#check_out_amount_rz").val('' + commaSeparateNumber(newCashoutAmount));
        $("#amountr").val('' + commaSeparateNumber(parseFloat(giftAmount).toFixed(2)));
        $("#check_out_amount").val(newCashoutAmount);
    }
    function setCashouttoTotal() {
        $("#amount").val(0);
        $("#check_out_amount_rz").val("<?php echo '' . number_format($TotalAvailable, 2, '.', ','); ?>");
        $("#check_out_amount").val(<?php echo $TotalAvailable ?>);

    }
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>

<script>
    function approveForm() {

        var data = validateForm();
        createSummaryTable(data);
        if (!data['error']) {
            $('#showpopupformdata').modal('show');
        }
    }
    function validateForm() {
        alert('aya');

        $("#error_fname").html("");
        $("#error_address").html("");
        $("#error_City").html("");
        $("#error_state").html("");
        $("#error_zipcode").html("");
        $("#error_phone").html("");
        $("#error_check_amount").html("");
        $("#error_donate_amount").html("");
        $("#error_donate_amount").html("");
        $("#error_fo").html("");
        var data = Array();
        data["fod"] = false;

        data["error"] = false;
        data["name"] = $('[name="member_name"]').val().trim();
        data["address"] = $('[name="street_address"]').val().trim();
        data["city"] = $('[name="city"]').val().trim();
        data["state"] = $('[name="state"]').val().trim();
        data["stateName"] = getSelectedText("state");
        data["zipCode"] = $('[name="zipcode"]').val().trim();
        data["phone"] = $('[name="phone_no"]').val().trim();
        var checkAmount = $('[name="check_out_amount_rz"]').val().trim();
        data["checkAmount"] = checkAmount.replace(",", "");
        if (data["fod"] === false) {
            var donateAmount = $('[name="amount"]').val().trim();
            data["donateAmount"] = donateAmount;
            data["fo"] = $("#charity_data").val();
            data["fo_name"] = getSelectedText("charity_data");
        } else {
            data['donateAmount'] = "";
            data["fo"] = "";
        }
        data["totalCashout"] = Math.round((+data["checkAmount"] + +data["donateAmount"]) * 100) / 100;

        if (data["name"] === "" || data["name"] === null) {
            $("#error_fname").html("Name is required");
            $('html, body').animate({
                scrollTop: $("#error_fname").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["address"] === "" || data["address"] === null) {
            $("#error_address").html("Address is required");
            $('html, body').animate({
                scrollTop: $("#error_address").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["city"] === "" || data["city"] === null) {
            $("#error_City").html("City is required");
            $('html, body').animate({
                scrollTop: $("#error_City").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["state"] === "" || data["state"] === null) {
            $("#error_state").html("Select a state");
            $('html, body').animate({
                scrollTop: $("#error_state").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["zipCode"] === "" || data["zipCode"] === null) {
            $("#error_zipcode").html("Zip Code is required");
            $('html, body').animate({
                scrollTop: $("#error_zipcode").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["phone"] === "" || data["phone"] === null) {
            $("#error_phone").html("Phone no. is required");
            $('html, body').animate({
                scrollTop: $("#error_phone").offset().top
            }, 2000);
            data["error"] = true;
        }
        if (data["checkAmount"] === "" || data["checkAmount"] === null) {
            $("#error_check_amount").html("Checkout amount is required");

            data["error"] = true;
        }
        if (data["fo"] !== "" && data["donateAmount"] === "") {
            $("#error_donate_amount").html("Fundraising Organization is selected. Enter amount to donate.");
            data["error"] = true;
        }
        if (data["checkAmount"] !== "" && data["donateAmount"] !== "") {
            if (data["checkAmount"] < 10) {
                data["error"] = true;
                $("#error_check_amount").html("Minimum Amount For Cash Back Check Is $10.");
            }
        }
        if (data["donateAmount"] !== "" && data["fo"] === "") {
            $("#error_fo").html("Select a Fundraising Organization to donate.");
            data["error"] = true;
        }
        return data;
    }
    function getSelectedText(elementId) {
        var elt = document.getElementById(elementId);

        if (elt.selectedIndex == -1)
            return null;

        return elt.options[elt.selectedIndex].text;
    }
    function createSummaryTable(data) {
        $("#summaryTable > tbody").html("");
        $("#summaryTable > tbody:last").append("<tr><td>Check Amount:</td><td>$" + numberWithCommas((parseFloat(data['checkAmount'])).toFixed(2)) + "</td></tr>");
        $("#summaryTable > tbody:last").append("<tr><td>Payment Destination:</td><td>" + data['address'] + "<br />" + data['city'] + ", " + data['zipCode'] + ", " + data['stateName'] + "<br />USA</td></tr>");
        $("#summaryTable > tbody:last").append("<tr><td>&nbsp;</td><td>&nbsp;</td></tr>");
        if (data['donateAmount'] !== "") {
            $("#summaryTable > tbody:last").append("<tr><td>Gift Amount:</td><td>$" + numberWithCommas((parseFloat(Math.round(data['donateAmount'] * 100) / 100)).toFixed(2)) + "</td></tr>");
            $("#summaryTable > tbody:last").append("<tr><td>Recipient:</td><td>" + data['fo_name'] + "</td></tr>");
        }
        $("#summaryTable > tbody:last").append("<tr><td>Total Cashout:</td><td>$" + numberWithCommas((parseFloat(data["totalCashout"])).toFixed(2)) + "</td></tr>");

    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>


