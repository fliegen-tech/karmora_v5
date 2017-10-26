<div class="join-now-step-cover">
    <div class="row">
        <?php
        if (isset($sameAsBilling) && $sameAsBilling) {
            ?>
            <div class="col-12">
                <div class="form-group">
                    <div class="form-check">
                        <label class="input-field-label">
                            <input  type="checkbox" value="">
                            Same As Shipping Address
                        </label>
                    </div>
                </div>
            </div>
        <?php }
        ?>
        <div id="address-form-<?php echo $addressForm ?>">
            <?php $this->load->view($viewForm.'address_fields'); ?>
        </div>
    </div>
</div>