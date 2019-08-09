<div class="row">
    <?php
    if ($TotalAvailable >= 1) {

        if (!empty($charityList)) {
            ?>

            <div class="col-md-12 payemnt-form ">
                <div class="col-md-12 no-padding">
                    <div class="col-md-7 no-padding">
                        <?php if (form_error('gift_check') != FALSE) { ?>
                            <div class="alert alert-danger"><?php echo form_error('gift_check'); ?></div>
                        <?php } ?>

                        <div class="col-md-5 no-padding">
                            <label class="karmora-pink-color" style="display: inline-block; margin-top: 10px; margin-left: 10px;"><strong>Would you like to make a Gift ?</strong></label>
                        </div>
                        <div class="col-md-7">
                            <!-- <input type="checkbox" name="gift_check"  id="gift_check" value="gift"/> -->
                            <label class="switch-mac">
                                <input type="checkbox" value="gift" <?php if($TotalAvailable < 1 || empty($charityList) ){ echo 'disabled="disabled"';} ?> name="gift_check" id="gift_check">
                              <div class="slider-mac round-mac"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            
            <div class="container">
                <div class="col-md-12 payemnt-form check-donate-mac" style="display: none;">
                    <div class="col-md-12 no-padding">
                        <div class="col-md-7 no-padding">
                            <?php if (form_error('fname') != FALSE) { ?>
                                <div class="alert alert-danger"><?php echo form_error('fname'); ?></div>
                            <?php } ?>
                            <div class="col-md-4 no-padding">
                                <label><a href="#" class="label-text-color" data-toggle="tooltip" data-placement="top" title="The check amount will automatically equal the total amount of funds available.  You must have at least $10 available to Cash Out.">Sender Name</a></label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" required="" name="fname" class="form-control" placeholder="Sender Name" value="<?php
                                if (set_value('fname') != FALSE) {
                                    echo set_value('fname');
                                } else {
                                    if (isset($userData['fullName'])) {
                                        echo $userData['fullName'];
                                    }
                                }
                                ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <span class="line-spc"></span>
                    <div class="col-md-12 no-padding">
                        <div class="col-md-7 no-padding">
                            <?php if (form_error('amount') != FALSE) { ?>
                                <div class="alert alert-danger"><?php echo form_error('amount'); ?></div>
                            <?php } ?>
                            <div class="col-md-4 no-padding">
                                <label><a href="#" class="label-text-color" data-toggle="tooltip" data-placement="top" title="You are under no obligation to do so, but before you Cash Out you have the option to gift all, or a portion, of your available funds to an approved Karmora charity.  The amount that you gift will automatically reduce the amount of the check that is issued to your address.  You will instantly receive $2 Karmora Kash for every $1 that you gift!”">Gift Amount</a></label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" placeholder="Enter Gift Amount" class="form-control" value="<?php
                                if (set_value('amount') != FALSE) {
                                    echo set_value('amount');
                                }
                                ?>" name="amount" id="amount"/>
                            </div>
                        </div>
                    </div>

                

                <div class="clearfix"></div>
                <span class="line-spc"></span>

                <script>

//                     $('#gift_check').click(function () {
//                         if ($('#gift_check').prop('checked') == true) {
// //                            console.log('checked');
//                             donateCheck();
//                             alert('i think i am true');
//                         } else if ($('#gift_check').prop('checked') == false) {
// //                            console.log('unchecked');
//                             setCashouttoTotal();
//                             alert('i think i am false');
//                         }

//                     });
                    $('#gift_check').click(function () {
                        if ($('#gift_check').is(':checked')) {
//                            console.log('checked');
                            donateCheck();
                            $('.check-donate-mac').show();
                        } else if ($('#gift_check').not(':checked')) {
//                            console.log('unchecked');
                            setCashouttoTotal();
                            $('.check-donate-mac').hide();
                        }

                    });
                    $('#amount').blur(function () {
                         if ($('#gift_check').is(':checked')) {
//                            console.log('checked');
                            donateCheck();
                        }
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
                            setCashouttoNew()
                        } else {
                            alert('Minimum Cashout check value of is ' +<?php echo $minCashout ?> + ' required');
                            setCashouttoTotal();
                        }

                    }

                    function setCashouttoNew() {
                        $("#check_out_amount_rz").val('$' + newCashoutAmount);
                        $("#check_out_amount").val(newCashoutAmount);
                    }

                    function setCashouttoTotal() {
                        $("#amount").val(0);
                        $("#check_out_amount_rz").val("<?php echo '$' . number_format($TotalAvailable, 2, '.', ','); ?>");
                        $("#check_out_amount").val(<?php echo $TotalAvailable ?>);

                    }

                    function isNumber(n) {
                        return !isNaN(parseFloat(n)) && isFinite(n);
                    }


                </script>

                <div class="col-md-12 no-padding">
                    <div class="col-md-7 no-padding">
                        <?php if (form_error('charity') != FALSE) { ?>
                            <div class="alert alert-danger"><?php echo form_error('charity'); ?></div>
                        <?php } ?>
                        <div class="col-md-4 no-padding">
                            <label><a href="#" data-toggle="tooltip" class="label-text-color" data-placement="top" title="If you cannot locate an organization that you would like to make a gift to please go to the “My Charities” section of your website and submit an application to have the organization approved as a Good Karmora Charity.">Recipient</a></label>
                        </div>
                        <div class="col-md-8">
                            <select   class="form-control" name="charity" >
                                <option selected="selected" disabled="">Select Organization</option>
                                <?php foreach ($charityList as $charity) { ?>
                                    <option value="<?php echo $charity['pk_charity_id'] ?>"><?php echo $charity['charity_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


            </div>


            </div>
        <?php } else { ?>
           <div class="col-md-12 payment-detail">
                <div class="alert alert-warning"><?php //echo 'No organisation to send gift to.' ?></div>
            </div>
            <?php
        }
    }
    ?>
</div>
