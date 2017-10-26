<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1>Cash Me Out</h1>
                </div>
            </div>
            <?php $this->load->view('frontend/user/dashboard_nav_bar'); ?>
        </div>
    </div>
    <?php $this->load->view('frontend/user/dashboard_info_bar'); ?>
</section>
<!--====  End of Dashbaord====-->

<section class="cash-me-out-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="step-heading">
                    <h2>Step 1: CONFIRM PAYMENT DESTINATION</h2>
                </div>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" id="cmo" name="cmo">
            <div class="cash-me-out-payment">
                <div class="row">
                    <?php $this->load->view('frontend/cashmeout/partial_destination'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="step-heading">
                        <h2>Step 2: MAKE A CHARITABLE GIFT?</h2>
                    </div>
                </div>
            </div>
            <div class="cash-me-out-payment charitable-gift">
                <p>You are under no obligation to do so, but before you Cash Out would you consider making a contribution to one of our Good Karmora Fundraising Organizations? <strong>Karmora will match 5% of every contribution in cash and you will receive $2 Karmora Kash for every dollar that you gift!</strong></p>
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Available Cash:</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="0.00" class="form-control" disabled=""  value="<?php echo '$'.number_format($TotalAvailable, 2, '.',','); ?>" name="total_available" id="total_available"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Recipient:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="charity" id="charity_data">
                                <option selected="selected" value=''>Select Organization</option>
                                <?php foreach ($charityList as $charity) { ?>
                                    <option id="<?php echo $charity['pk_charity_id'] ?>" value="<?php echo $charity['pk_charity_id'] ?>"><?php echo $charity['charity_name'] ?></option>
                                <?php } ?>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Don’t see a charity you support? <a href="<?php echo base_url() . 'karmora-my-charities'; ?>">Click Here</a> to nominate a cause or charity that is close to your heart!</small>
                        </div>
                        <?php if (form_error('charity') != FALSE) { ?>
                            <div class="alert alert-danger"><?php echo form_error('charity'); ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Gift Amount:</label>
                        <div class="col-sm-6">
                            <?php if (form_error('amount') != FALSE) { ?>
                                <div class="alert alert-danger"><?php echo form_error('amount'); ?></div>
                            <?php } ?>
                            <input type="text" placeholder="0.00" class="form-control for-amount" value="<?php
                            if (set_value('amount') != FALSE) {
                                echo set_value('amount');
                            }
                            ?>" name="amount" id="amount"/>
                            <span class="dollar-sign"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="step-heading">
                        <h2>Step 3: CASH ME OUT!</h2>
                    </div>
                </div>
            </div>
            <div class="cash-me-out-payment">
                <p>Now it’s time to Cash Out!   Please review your check request and click Cash Me Out!</p>
                <input type="hidden"  name="fname" class="form-control" placeholder="Sender Name" value="<?php if (isset($userData['fullName'])) { echo $userData['fullName']; } ?>" />
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Available Balance:</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo isset($TotalAvailable) ? number_format(abs($TotalAvailable), 2) : '0.00'; ?>"  class="form-control for-amount" placeholder="">
                            <span class="dollar-sign"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Gift Amount:</label>
                        <div class="col-sm-6">
                            <input readonly="readonly" type="text" placeholder="0.00" class="form-control" value="<?php
                            if (set_value('amount') != FALSE) {
                                echo set_value('amount');
                            }
                            ?>"  id="amountr"/>
                            <span id="error_donate_amount"></Span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 input-field-label">Check Amount:</label>
                        <div class="col-sm-6">
                            <input type="text"  class="form-control" name="check_out_amount_rz" id="check_out_amount_rz"  readonly="readonly"  value="<?php
                            if (isset($TotalAvailable)) {
                                echo number_format(abs($TotalAvailable), 2);
                            }
                            ?>" />
                        </div>
                    </div>
                </div>
                <input type="hidden" name="check_out_amount" id="check_out_amount" value="<?php
                if (isset($TotalAvailable)) {
                    echo round($TotalAvailable, 2);
                }
                ?>" />
                <span id="error_check_amount"></span>
                <?php if (form_error('check_out_amount') != FALSE) { ?>
                    <div class="alert alert-danger"><?php echo form_error('check_out_amount'); ?></div>
                <?php } ?>
                <?php if ($TotalAvailable > 0) { ?>
                    <div class="col-8 charitable-btns text-center">
                        <button type="button" style="border: none;" onclick="approveForm()" class="btn btn-joinnow left-right-hover">Submit</button>
                        <button type="reset" style="border: none;" class="btn btn-joinnow left-right-hover">Clear</button>
                    </div>

                <?php } ?>

            </div>
            <!-- Check Request -->
            <?php if (!empty($CashMeMember)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="check-request">
                        <h3>CHECK REQUEST</h3>
                        <div class="karmora-table" id="request-table">
                            <!-- My Cummunity Table -->
                            <?php $this->load->view('frontend/cashmeout/partial_cashout_history'); ?>
                            <!-- End My Cummunity Table -->
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- Gifts -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <div class="modal fade popup-gift-fai" id="showpopupformdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content model-save-money">
                        <div class="modal-header">
                            <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                            <h4 class="modal-title karmora-save-title" id="myModalLabel">ALMOST DONE!</h4>
                        </div>
                        <div class="modal-body">
                            <h3>Please confirm your request:</h3>
                            <div class="panel-body">
                                <div class="row">
                                    <div class=" col-md-12 ">
                                        <table class="table table-user-information" id="summaryTable">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="con-btn-cash">
                                <input class="btn btn-joinnow left-right-hover " type="submit" name="submit" value="Approve" />
                                <button type="button" class="btn btn-joinnow left-right-hover" data-dismiss="modal" aria-hidden="true">Back</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php $this->load->view('frontend/cashmeout/cashmeout_js'); ?>

<!--====  End of Dashbaord====-->

