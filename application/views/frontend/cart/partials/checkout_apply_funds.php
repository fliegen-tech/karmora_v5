<div class="col-7">
    <?php if (isset($redum_value) && $redum_value > 0) { ?>
    <div class="row">
        <div class="col-9">
            <div class="funds-leftbar">
                <h3>Apply Available Karmora Kash</h3>
                <p>You have <span>$<?php echo number_format($available_karmora_cash, 2, '.', ','); ?></span> of Karmora Kash available. You can use up to <span>$<?php echo number_format($redum_value, 2, '.', ','); ?></span> towards this purchase. Would you like to apply Karmora Kash?</p>
            </div>
        </div>
        <div class="col-3">
            <div class="switch">
                <input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                <label for="cmn-toggle-4"></label>
            </div>
            <input type="hidden" name="karmora_cash" id="karmora_cash" value="<?php echo $redum_value; ?>">
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-9">
            <div class="funds-leftbar">
                <h3>Apply eWallet Funds</h3>
                <p>You have <span>$<?php echo number_format($available_commsion, 2, '.', ','); ?></span> of Karmora Kash available. You can use up to <span>$59.95</span> towards this purchase. Would you like to apply Karmora Kash?</p>
            </div>
        </div>
        <?php if (isset($commsion_value) && $commsion_value > 0 ) { ?>
        <div class="col-3">
            <div class="switch">
                <input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                <label for="cmn-toggle-4"></label>
            </div>
            <input type="hidden" name="karmora_cash" id="karmora_cash" value="<?php echo $redum_value; ?>">
        </div>
        <?php } ?>
    </div>
</div>