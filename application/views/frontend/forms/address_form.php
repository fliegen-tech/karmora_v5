<div class="join-now-step-cover">
    <div class="row">
        <?php if (isset($billingAddress) && $billingAddress) { ?>
            <div class="col-12">
                <div class="form-group">
                    <div class="form-check">
                        <label class="input-field-label">
                            <input name="same_as_shipping" id="sameshipaddress" onclick="makeRequieedOnSameAs()"  type="checkbox" value="1">
                            Same As Shipping Address
                        </label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div id="address-form-<?php echo $addressForm ?>">
            <?php $this->load->view($viewForm.'address_fields'); ?>
        </div>
    </div>
</div>