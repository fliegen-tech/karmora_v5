<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/charities.png" class="img-fluid">My Charities</h1>
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
<?php
$total = 0;
foreach($totalContribution as $tota){
    $total = $total + $tota['community_donation'];
}
?>
<?php if (isset($msg)) { ?>
    <script type="text/javascript">
        $(window).load(function () {
            $('#Successmessage').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        });
    </script>
<?php } ?>
<section class="my-cahrities-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="karmora-cares-cover">
                <div class="cares-righbar">
                    <img src="<?php echo $themeUrl ?>/frontend/images/help-karmora.jpg" alt="">
                </div>
                <div class="cares-leftbar">
                    <h3>Karmora Cares!</h3>
                    <p>Karmora pays our Shoppers $2 in Karmora Kash for every dollar that they contribute to an approved Karmroa Fundraising Organization! Plus, Karmora will add a 5% Good Karmora Match to every contribution made by every Shopper! Total Contributed to Karmora Fundraising Organizations as of <span><?php echo date('M d , Y'); ?> &nbsp;&nbsp;$<?php echo number_format($total, 2, ".", ","); ?></span></p>
                </div>
            </div>
            <div class="col-12">
                <div class="charities-desp">
                    <p>Do you know of a Club, Charity or Religious Organization that would like to receive contributions from Karmora Shoppers?   Simply fill out the questionnaire and once approved they will be eligible to receive gifts from every Karmora Shopper!</p>
                    <p><span>Please enter the name and mailing address that will be used for delivery of the gift checks that will be sent to your prospective fundraising organization.</span></p>
                </div>
                <div class="charities-form">
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Name of Organization <span class="text-danger">*</span></label>
                                    <input type="text" required="required" class="form-control" name="charity_name" id="name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Address 1 <span class="text-danger">*</span></label>
                                    <input type="text" required="required" name="charity_street_address" class="form-control" id="name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Address 2 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="charity_street_address_2" id="name" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">City <span class="text-danger">*</span></label>
                                    <input required="required" type="text" name="charity_city_name" class="form-control" id="name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_city_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">State <span class="text-danger">*</span></label>
                                    <select  required="required" name="fk_state_id" class="form-control" id="exampleFormControlSelect2">
                                        <option value="0" selected="" disabled="disabled">Select State</option>
                                        <?php foreach ($allstate as $stat) { ?>
                                            <option value="<?php echo $stat['pk_user_address_state_id']; ?>"><?php echo $stat['user_address_state_title']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('fk_state_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Zip Code <span class="text-danger">*</span></label>
                                    <input type="text" required="required" name="charity_zip_code" class="form-control" id="name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_zip_code'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Point of Contact First Name <span class="text-danger">*</span></label>
                                    <input type="text" required="required" class="form-control" id="name" name="charity_first_name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_first_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Point of Contact Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="charity_last_name" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Point of Contact Phone <span class="text-danger">*</span></label>
                                    <input type="text" required="required" class="form-control" id="name" name="charity_phone_no" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_phone_no'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Point of Contact Email <span class="text-danger">*</span></label>
                                    <input type="email" required="required" class="form-control" name="charity_email_adrress" id="name" placeholder="">
                                    <span class="error_message_class"><?php echo form_error('charity_email_adrress'); ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-field-label">Web Address or Facebook Page <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="charity_socail_link" id="name" placeholder="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-my-charitess">
                                    <input type="submit" name="saveraise" value="Submit" class="btn btn-joinnow left-right-hover">
                                    <input type="reset" class="btn btn-joinnow left-right-hover" value="Clear">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    </form>
                </div>
                <div class="notice">
                    <p>* Applicants must have an active Website or Facebook Page to be eligible for approval.   Karmora reserves the right to accept or deny any organization in our sole discretion.   It will typically take up to 72 hours to process each complete application and both you and the organization will be notified once the application has been processed.  </p>
                </div>
                <?php if (($myContribution) != FALSE && is_array($myContribution)) { ?>
                    <div class="contribution-cover">
                        <h3>My Contributions</h3>
                        <div class="karmora-table" id="contribution-table">
                            <!-- My Cummunity Table -->
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Organization Name</th>
                                    <th>My Contribution</th>
                                    <th>Contribution Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($myContribution as $key => $valueRow) { ?>
                                <tr>
                                    <td scope="row"><?php echo $valueRow['org_name']; ?></td>
                                    <td><?php echo '$' . number_format($valueRow['my_contirbution'], 2, ".", ","); ?></td>
                                    <td><?php echo $valueRow['contribution_date']; ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <!-- End My Cummunity Table -->
                        </div>
                    </div>
                    <?php } if ($totalContribution != FALSE and is_array($totalContribution)) { ?>

                    <div class="contribution-cover">
                        <h3>Total Contribution <small>(As of: <?php echo date('M d , Y'); ?>)</small></h3>
                        <div class="karmora-table" id="contribution-table">
                            <!-- My Cummunity Table -->
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Organization Name</th>
                                    <th>Karmora Shoppers</th>
                                    <th>Karmora Cares 5% Match</th>
                                    <th>Karmora Corporate</th>
                                    <th>Karmora Kash Awarded</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($totalContribution as $tKey => $tValue) { ?>
                                <tr>
                                    <td scope="row"><?php echo $tValue['org_name'];?></td>
                                    <td><?php echo '$'.number_format($tValue['community_donation'], 2,'.',',') ;?></td>
                                    <td><?php echo '$'.number_format($tValue['karmora_care'], 2,'.',','); ?></td>
                                    <td><?php echo '$'.number_format($tValue['corporate_donation'], 2,'.',','); ?></td>
                                    <td><?php echo '$'.number_format($tValue['kash_award'], 2,'.',','); ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <!-- End My Cummunity Table -->
                        </div>
                    </div>
                    <?php } ?>



            </div>
        </div>
    </div>
</section>
<!--====  End of Dashbaord====-->
<div class="modal fade" id="Successmessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content model-save-money" style="height: 170px;">
            <div class="modal-header">
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                <h4 class="modal-title karmora-save-title karmora-uppercase" id="myModalLabel">Congratulations!</h4>
            </div>
            <div class="modal-body">
                <!-- <h5 class="kamora-save-desp-a">Karmora Guarantees that our Premier Shoppers will earn the highest Cash Back available on the internet!The process is simple:</h5> -->
                <div class="box-cover-gift karmora-box-popup-gft">
                    <h2>Charity created successfully!</h2>
                </div>

            </div>
        </div>
    </div>
</div>
