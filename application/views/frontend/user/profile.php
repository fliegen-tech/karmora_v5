<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="images/profile.png" class="img-fluid">My Profile</h1>
                </div>
            </div>
            <?php $this->load->view('frontend/user/dashboard_nav_bar'); ?>
        </div>
    </div>
    <?php $this->load->view('frontend/user/dashboard_info_bar'); ?>
</section>
<!--====  End of Dashbaord====-->


<!--=========================================
=            Dashbaord          =
==========================================-->
<section class="user-profile page-spacing">
    <div class="container">
        <div class="row">
            <!-- Basis Info -->
            <?php if (!empty($userData)) { ?>
            <div class="col-6">
                <form method="post" action="<?php echo base_url() ?>editprofile">
                <h3>Basic Information</h3>
                    <div class="profile-cover">
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-info" role="alert">Profile Saved</div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('profile_err')) { ?>
                        <div class="alert alert-danger" role="alert">Complete the details</div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">First Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" name="fname" value="<?php echo $userData['user_first_name'] ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Last Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" name="lname" value="<?php echo $userData['user_last_name'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Email:</label>
                            <div class="col-sm-8">
                                <input type="email" required="required" class="form-control" id="staticEmail" name="email" value="<?php echo $userData['user_email']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <button type="submit" class="btn btn-joinnow left-right-hover">Update</button>
                            <button type="reset" class="btn btn-joinnow left-right-hover">Cancel</button>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="action" value="edit_profile" />
                    <input type="hidden" name="userId" value="<?php echo $userData['pk_user_id'] ?>" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>
            <?php } ?>
            <!-- Changing Password  -->
            <div class="col-6">
                <h3>Change Password</h3>
                <form class="form-horizontal" method="post" action="<?php echo base_url() ?>editprofile">
                    <div class="profile-cover">
                    <?php if ($this->session->flashdata('pass_err')) { ?>
                        <div class="alert alert-danger" role="alert">Password Mismatch</div>
                    <?php  } else if ($this->session->flashdata('pass_succ')) { ?>
                        <div class="alert alert-info" role="alert">Password Changed</div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Current Password:</label>
                            <div class="col-sm-8">
                                <input type="text" required="required" class="form-control" id="inputPassword" name="curr_password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">New Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="inputPassword" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Confirm Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="inputPassword" name="confirm_password">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <button type="submit" class="btn btn-joinnow left-right-hover">Update</button>
                            <button type="reset" class="btn btn-joinnow left-right-hover">Cancel</button>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="userId" value="<?php echo $userData['pk_user_id'] ?>" />
                    <input type="hidden" name="action" value="change_password" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>

            <!-- Mailing Address -->
            <div class="col-6">
                <h3>Mailing Address</h3>
                <form class="form-horizontal" method="post" action="<?php echo base_url() ?>editprofile">
                    <div class="profile-cover">
                        <?php if ($this->session->flashdata('address_success')) { ?>
                            <div class="alert alert-info" role="alert"><?php echo $this->session->flashdata('address_success'); ?></div>
                        <?php  } elseif ($this->session->flashdata('address_err')) { ?>
                            <div class="alert alert-danger" role="alert"> <?php echo $this->session->flashdata('address_err'); ?></div>
                        <?php } ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Address 1</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" name="street_address" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['street_address']; ?>"<?php } ?> placeholder="12148 E. San Simeon Drive">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Address 2:</label>
                            <div class="col-sm-8">
                                <input type="text" name="street_address_2" class="form-control" id="staticEmail" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['street_address_2']; ?>"<?php } ?> placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">City:</label>
                            <div class="col-sm-8">
                                <input type="text" name="city" class="form-control" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['city']; ?>"<?php } ?> id="staticEmail" placeholder="Scottsdale">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">State:</label>
                            <div class="col-sm-8">
                                <select id="statesList"  required="" name="state" class="form-control" >
                                    <?php if ($address === false) { ?>
                                        <option selected="selected" disabled="disabled">--- Select State ---</option>
                                    <?php  }
                                    if ($statesList !== false) {
                                        $first = true;
                                        foreach ($statesList as $state) {
                                            if ($first) {
                                                reset($statesList);
                                                $first = false;
                                            }
                                            ?>
                                            <option value="<?php echo $state['optionVal'] ?>" <?php if ($state['pk_user_address_state_id'] === $address['state_id']) { ?> selected="selected" <?php } ?>> <?php echo $state['user_address_state_code'] . ' - ' . $state['user_address_state_title']; ?> </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Zip Code:</label>
                            <div class="col-sm-8">
                                <input type="text" name="zipcode" class="form-control" id="staticEmail" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['zipcode']; ?>"<?php } ?> placeholder="85259">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Country:</label>
                            <div class="col-sm-8">
                                <select name="country" class="form-control" id="exampleFormControlSelect2">
                                    <?php if ($address === false) { ?>
                                        <option selected="selected" disabled="disabled">--- Select Country ---</option>
                                    <?php }
                                    if ($countriesList !== false) {
                                        $first = true;
                                        foreach ($countriesList as $country) {
                                            if ($first) {
                                                reset($countriesList);
                                                $first = false;
                                            } ?>
                                            <option value="<?php echo $country['pk_user_address_country_id'] ?>" <?php if ($address !== false && $country['pk_user_address_country_id'] === $address['country_id']) { ?> selected="selected" <?php } ?>> <?php echo $country['user_address_country_code'] . ' - ' . $country['user_address_country_title'] ?> </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Phone No:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" name="phone" value="<?php echo $userData['user_phone_no']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <button type="submit" class="btn btn-joinnow left-right-hover">Update</button>
                            <button type="reset" class="btn btn-joinnow left-right-hover">Cancel</button>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="action" value="address_update" />
                    <input type="hidden" name="userId" value="<?php echo $userData['pk_user_id'] ?>" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>
            <!-- Upload W9 Form -->
            <div class="col-6">
                <h3>Upload your W9 Form</h3>
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>profile/w9form">
                <div class="profile-cover w9-form">
                    <p>Karmora requests that all Premier Shoppers that are building Shopping Communities to submit a completed IRS Form W-9 so that we can report your Shopping Commissions.</p>
                    <p>The Cash Out page, where you collect your Cash Back and Shopping Commissions, will automatically lock after you have earned $100 in Shopping Commissions until we have received the completed form. <a target="_blank" href="https://www.irs.gov/pub/irs-pdf/fw9.pdf">Click here</a> to open a fillable .pdf version of IRS Form W-9.   Please print and sign the completed form and either scan and upload the form or fax it to Karmora toll free at (866) 538-6734.</p>
                    <?php if ($this->session->flashdata('w9form_sucess')) { ?>
                        <div class="alert alert-info" role="alert">File Upload Sucefully</div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('w9form_err')) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('w9form_err'); ?></div>
                    <?php } ?>
                    <div class="from-group">
                        <label class="custom-file">
                            <input type="file" name="w9form" id="file2" class="custom-file-input">
                            <span class="custom-file-control"></span>
                        </label>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <input type="submit" class="btn btn-joinnow left-right-hover" name="submit" value="Submit Your Form">
                            <button type="reset" class="btn btn-joinnow left-right-hover">Clear</button>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>
            <!-- Manage Karmora Emails -->
            <div class="col-6">
                <h3>Manage Karmora Emails</h3>
                <form class="form-horizontal" method="post" action="<?php echo base_url() ?>profile/emails">
                    <div class="profile-cover manage-emails">
                    <div class="form-group">
                        <?php if ($this->session->flashdata('email_succ')) { ?>
                            <div class="alert alert-info" role="alert">Changes Saved</div>
                        <?php } ?>
                        <div class="row">
                            <?php foreach ($email_types as $email_types) { ?>
                            <div class="col-6">
                                <label class="form-check-label">
                                    <input class="form-check-input check" type="checkbox" name="emails[]" value="<?php echo $email_types->fk_email_type_id; ?>" <?php if ($email_types->email_type_to_user_relation_status === "Active") {  echo "checked = checked"; } ?> value="">
                                    <span><?php echo ucfirst($email_types->email_type_description); ?></span>
                                </label>
                            </div>
                            <?php } ?>
                            <div class="col-6">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="uncheck" value="uncheck" id="uncheck" type="checkbox" style="width: 22px; height: 40px; margin-right: 0;">
                                    <span>Please STOP all Karmora emails</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <button type="submit" class="btn btn-joinnow left-right-hover">Update</button>
                            <button type="submit" class="btn btn-joinnow left-right-hover">Cancel</button>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="userId" value="<?php echo $email_types->fk_user_id; ?>" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>
            <!-- Change Credit/Debit Card -->
            <div class="col-6">
                <h3>Change or Update Credit/Debit Card</h3>
                <form class="form-horizontal" method="POST" action="<?php echo base_url('profile/update_subscription'); ?>">
                 <div class="profile-cover">
                    <?php if ($this->session->flashdata('subscription')) {
                         echo $this->session->flashdata('subscription');
                    } ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="cardnumber" class="col-sm-4 col-form-label">Card Number:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="card_number" required="required" id="cardNumber" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Expiration Date:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="month" required="required" placeholder="MM">
                            </div>
                            <div class="col-sm-4 p-l-0">
                                <input type="text" class="form-control" name="year" required="required" placeholder="YYY">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">CVV:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="card_code" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="profile-btn-group">
                            <input type="submit" class="btn btn-joinnow left-right-hover" name="submit" value="Submit">
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </form>
            </div>

        </div>
    </div>
</section>
<?php $this->load->view('frontend/user/profile_js'); ?>

