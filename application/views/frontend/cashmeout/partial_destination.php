<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">Name </label>
        <input type="text" class="form-control" readonly="readonly"  name="member_name" value="<?php
        if (set_value('member_name') != false) {
            echo set_value('member_name');
        } else {
            if (isset($userData['fullName'])) {
                echo $userData['fullName'];
            }
        }
        ?>" required="">
        <?php if (form_error('member_name') != FALSE) { ?>
            <span class="error_message_class" id="error_fname"><?php echo form_error('member_name'); ?></span>
        <?php } ?>
    </div>
</div>

<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">State</label>
        <?php if (!empty($state)) { ?>

            <select name="state" id="state" required="" class="form-control" >
                <?php if (!isset($userData['userAddress']['state_id'])) { ?>
                    <option selected="selected" disabled="">Select State</option>
                <?php } ?>
                <?php foreach ($state as $sta) { ?>
                    <option value="<?php echo $sta['state_id'] ?>" <?php
                    if (set_value('state') != FALSE && set_value('state') == $sta['state_id']) {
                        echo 'selected';
                    } else {
                        if (isset($userData['userAddress']['state_id']) && $userData['userAddress']['state_id'] == $sta['state_id']) {
                            echo 'selected';
                        }
                    }
                    ?>><?php echo $sta['state'] ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <?php if (form_error('state') != FALSE) { ?>
            <span class="error_message_class" id="error_state"><?php echo form_error('state'); ?></span>
        <?php } ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">Address </label>
        <input type="text" class="form-control" name="street_address" required="required"  value="<?php
        if (set_value('street_address') != false) {
            echo set_value('street_address');
        } else {
            if (isset($userData['userAddress']['address'])) {
                echo $userData['userAddress']['address'];
            }
        }
        ?>">
        <?php if (form_error('street_address') != FALSE) { ?>
            <span class="error_message_class" id="error_address"><?php echo form_error('street_address'); ?></span>
        <?php } ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">Zip Code </label>
        <input type="text" class="form-control" name="zipcode" required="required" value="<?php
        if (set_value('zipcode') != FALSE) {
            echo set_value('zipcode');
        } else {
            if (isset($userData['userAddress']['zipcode']) && $userData['userAddress']['zipcode'] != 0) {
                echo $userData['userAddress']['zipcode'];
            }
        }
        ?>" >
        <?php if (form_error('zipcode') != FALSE) { ?>
            <span class="error_message_class" id="error_zipcode"><?php echo form_error('zipcode'); ?></span>
        <?php } ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">City</label>
        <input type="text" name="city" class="form-control" required="required" value="<?php
        if (set_value('city') != FALSE) {
            echo set_value('city');
        } else {
            if (isset($userData['userAddress']['city'])) {
                echo $userData['userAddress']['city'];
            }
        }
        ?>" >
        <?php if (form_error('city') != FALSE) { ?>
            <span class="error_message_class" id="error_City"><?php echo form_error('city'); ?></span>
        <?php } ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="input-field-label">Phone</label>
        <input type="text" name="phone_no" class="form-control" value="<?php
        if (set_value('phone_no') != FALSE) {
            echo set_value('phone_no');
        } else {
            if (isset($userData['phone_no'])) {
                echo $userData['phone_no'];
            }
        }
        ?>" >
        <?php if (form_error('phone_no') != FALSE) { ?>
            <span class="error_message_class" id="error_phone"><?php echo form_error('phone_no'); ?></span>
        <?php } ?>
    </div>
</div>
