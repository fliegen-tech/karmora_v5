<div class="row">
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="address1">Address 1 <span class="important-input">*</span></label>
        <input type="text" required="required" name="biling_detail[street_address]" class="form-control" id="address1" placeholder="Address1">
        <span class="error_message_class"><?php echo form_error('biling_detail[street_address]'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="address2">Address 2 </label>
        <input type="text" name="biling_detail[street_address_2]" class="form-control"  placeholder="Address2">
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="city">City <span class="important-input">*</span></label>
        <input required="required" type="text" name="biling_detail[city]" class="form-control" placeholder="City">
        <span class="error_message_class"><?php echo form_error('biling_detail[city]'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="state">State <span class="important-input">*</span></label>
        <select required="required" id="statesList" name="biling_detail[state]" class="form-control">
            <option selected="selected" disabled="disabled">--- Select State --- </option>
                <?php if ($statesList !== false) {
                            $first = true;
                        foreach ($statesList as $state) {
                            if ($first) {
                                reset($statesList);
                                $first = false;
                            }
                    ?>
                    <option value="<?php echo $state['optionVal'] ?>" > <?php echo $state['user_address_state_code'] . ' - ' . $state['user_address_state_title']; ?> </option>
                <?php } } ?>
        </select>
        <span
            class="error_message_class"><?php echo form_error('biling_detail[state]'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label required="required" for="zipcode">Zip Code <span  class="important-input">*</span></label>
        <input type="text" name="biling_detail[zipcode]" class="form-control" value="<?php echo set_value('biling_detail[zipcode]'); ?>" id="zipcode" placeholder="Zip Code">
        <span class="error_message_class"><?php echo form_error('biling_detail[zipcode]'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="country">Country <span class="important-input">*</span></label>
        <select required="required" id="countriesList" name="biling_detail[country]" placeholder="Country" class="form-control"
        <option selected="selected" disabled="disabled">--- Select Country ---</option>
        <?php
        if ($countriesList !== false) {
            $first = true;
            foreach ($countriesList as $country) {
                if ($first) {
                    reset($countriesList);
                    $first = false;
                }
                ?>
                <option value="<?php echo $country['pk_user_address_country_id'] ?>" > <?php echo $country['user_address_country_code'] . ' - ' . $country['user_address_country_title'] ?> </option>
        <?php } } ?>
        </select>
        <span class="error_message_class"><?php echo form_error('biling_detail[country]'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="phone">Phone <span class="important-input">*</span></label>
        <input type="text" required="required" name="biling_detail[phone]" class="form-control"  value="<?php echo set_value('biling_detail[phone]'); ?>" placeholder="Phone">
        <span class="error_message_class"><?php echo form_error('biling_detail[phone]'); ?></span>
    </div>
</div>