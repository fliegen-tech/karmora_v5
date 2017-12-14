<div class="col-7">
    <?php if (isset($redum_value) && $redum_value > 0) { ?>
    <div class="row">
        <div class="col-9 order2-chk">
            <div class="funds-leftbar">
                <h3>Apply Available Karmora Kash</h3>
                <p>You have <span>$<?php echo number_format($available_karmora_cash, 2, '.', ','); ?></span> of Karmora Kash available. You can use up to <span>$<?php echo number_format($redum_value, 2, '.', ','); ?></span> towards this purchase. Would you like to apply Karmora Kash?</p>
            </div>
        </div>
        <div class="col-3 order1-chk">
            <div class="switch">
                <input id="karmora_kash_checkBox" name="karmora_kash_checkBox" value="1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                <label for="karmora_kash_checkBox"></label>
            </div>
            <input type="hidden" name="karmora_kash" id="karmora_kash" value="<?php echo $redum_value; ?>">
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-9 order2-chk">
            <div class="funds-leftbar">
                <h3>Apply eWallet Funds</h3>
                <p>You have <span>$<?php echo number_format($available_commsion, 2, '.', ','); ?></span> of Karmora Kash available. You can use up to <span>$<?php echo number_format($commsion_value, 2, '.', ','); ?></span> towards this purchase. Would you like to apply Karmora Kash?</p>
            </div>
        </div>
        <?php if (isset($commsion_value) && $commsion_value > 0 ) { ?>
        <div class="col-3 order1-chk">
            <div class="switch">
                <input id="karmora_commsion_checkBox" name="karmora_commsion_checkBox" value="1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                <label for="karmora_commsion_checkBox"></label>
            </div>
            <input type="hidden" name="karmora_commsion" id="karmora_commsion" value="<?php echo $commsion_value; ?>">
        </div>
        <?php } ?>
    </div>
</div>