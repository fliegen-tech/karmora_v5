<?php
if(isset($address) && $address){
    $street_address     =  ($address['street_address'] != '' ? $address['street_address'] : '');
    $street_address_2   =  ($address['street_address_2'] != '' ? $address['street_address_2'] : '');
    $city           =  ($address['city'] != '' ? $address['city'] : '');
    $zipcode        =  ($address['zipcode'] != '' ? $address['zipcode'] : '');
    $state_id       =  ($address['state_id'] != '' ? $address['state_id'] : '');
}
?>
<div class="col-12">
    <div class="row">

        <?php
        if (isset($askName) && $askName) {
            ?>
            <div class="col-6">
                <div class="form-group">
                    <label class="input-field-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="<?php echo $addressForm ?>[name]" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Full Name">
                </div>
            </div>
            <?php
        }
        ?>

        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">Address 1 <span class="text-danger">*</span></label>
                <input type="text" name="<?php echo $addressForm ?>[address1]" class="form-control" id="address" value="<?php echo $street_address; ?>" aria-describedby="addresHelp" placeholder="Address1">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">Address 2 <span class="text-danger">*</span></label>
                <input type="text" name="<?php echo $addressForm ?>[address2]" class="form-control" id="address" value="<?php echo $street_address_2; ?>" aria-describedby="addresHelp" placeholder="Address2">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">City <span class="text-danger">*</span></label>
                <input type="text" name="<?php echo $addressForm ?>[city]" class="form-control" id="city" value="<?php echo $city; ?>" aria-describedby="addresHelp" placeholder="City">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">State <span class="text-danger">*</span></label>
                <select class="form-control" name="<?php echo $addressForm ?>[state]" id="exampleFormControlSelect2">
                    <option selected="" disabled=""> --- Select State --- </option>
                    <?php
                    foreach ($statesList as $state) {
                        ?>
                        <option value="<?php echo $state['pk_user_address_state_id']; ?>" <?php if($state['pk_user_address_state_id'] == $state_id){ echo 'selected = "selected" ';}  ?>><?php echo $state['user_address_state_code'].' - '.$state['user_address_state_title']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">Zip Code <span class="text-danger">*</span></label>
                <input type="text" value="<?php echo $zipcode; ?>" name="<?php echo $addressForm ?>[zip_code]" class="form-control" id="city" aria-describedby="addresHelp" placeholder="Zip Code">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">Country <span class="text-danger">*</span></label>
                <select class="form-control" name="<?php echo $addressForm ?>[country]" id="exampleFormControlSelect2">
                    <option value="1-.-1"> US - United States </option>
                    <?php
                    foreach ($countriesList as $country) {
                        ?>
                        <option value="<?php echo $country['pk_user_address_country_id']; ?>"><?php echo $country['user_address_country_code'].' - '.$country['user_address_country_title']; ?></option>
                        <?php
                    }
                    ?>

                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="input-field-label">Phone <span class="text-danger">*</span></label>
                <input type="text" name="<?php echo $addressForm ?>[phone]" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Phone">
            </div>
        </div>                
    </div>
</div>