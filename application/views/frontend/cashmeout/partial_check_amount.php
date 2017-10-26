<?php if ($TotalAvailable >= $minCashout && $TotalAvailable > 0) { ?>
<div class="col-md-12 payemnt-form ">
    <div class="col-md-12 no-padding">
        <div class="col-md-7 col-sm-7 no-padding">
            <div class="col-md-4 col-sm-4 no-padding">
                <label><a href="#" class="label-text-color" data-toggle="tooltip" data-placement="top" title="The check amount will automatically equal the total amount of funds available.  You must have at least $10 available to Cash Out.">Check Amount</a></label>
            </div>
            <div class="col-md-8 col-sm-8">
                <input type="text" required="" class="cash-me-btn-fid" name="check_out_amount_rz" id="check_out_amount_rz" class="for-margin-bottom" readonly="readonly"  value="$<?php
                if (isset($TotalAvailable)) {
                    echo number_format(abs($TotalAvailable), 2);
                }
                ?>" />
                <input type="hidden" name="check_out_amount" id="check_out_amount" value="<?php
                if (isset($TotalAvailable)) {
                    echo round($TotalAvailable, 2);
                }
                ?>" />
                       <?php if (form_error('check_out_amount') != FALSE) { ?>
                    <div class="alert alert-danger"><?php echo form_error('check_out_amount'); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <span class="line-spc"></span>
    <span class="line-spc"></span>
    
    <h4 style="font-weight: 700; font-style: italic;">Please enter the name and mailing address that will be used for delivery of the gift checks that will be sent to your prospective fundraising organization.</h4>
    <span class="line-spc"></span>
    <div class="col-md-12 no-padding"> 
        <div class="col-md-7 col-sm-7 no-padding">
            <div class="col-md-4 col-sm-4 no-padding">
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="karmora-kcash2-btn">
                    <input class="btn-cash-1-out btn-br" type="submit" name="submit" value="Cash Me Out!" />
                    <button type="reset" class="btn-cash-1-out btn-br">Clear</button>
                </div>
            </div>
        </div>
    </div>
    

    <div>
    </div>
</div>
<?php } ?>