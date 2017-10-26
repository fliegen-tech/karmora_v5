<?php $this->load->view('frontend/layout/partials/reporting_nav_bar'); ?>
<span class="line-spc"></span><span class="line-spc"></span>  
<section class="minmium-cash-out-deatail">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p><strong>Charitable Contributions </strong>– Karmora will give you $2 Karmora Kash for every dollar that you donate to an approved Karmora Charity. &nbsp; To nominate a Charity please click on the “My Charities” tab above and submit the request form. &nbsp; It will be approved within 48 hours. &nbsp; Karmora sends the contributions to the charities on the last day of each calendar month. &nbsp; The selected charity will receive an immediate email acknowledging your contribution. &nbsp; Please check with your independent tax advisor on the potential deductibility of your generous gift. </p>
                <span class="line-spc"></span>
                <div class="have-question">
                    <ul class="list-inline">
                        <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)" class="live-chat gift-live"><img src="<?php echo $themeUrl ?>/images/question-compostation.png" />&nbsp; &nbsp; Have Questions?</a></li>
                        <li><span  id="support-form"> <a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)" class="live-chat gift-live"><img src="<?php echo $themeUrl ?>/images/chat.png" /> &nbsp; &nbsp; Chat with Us</a></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<span class="line-spc"></span><span class="line-spc"></span>  
<section class="payesment-cash">
    <div class="container">
        <?php
        echo $this->session->flashdata('donation');
        if ($TotalAvailable >= 1) {
            ?>
            <?php if (!empty($charityList)) { ?>
                <form class="form-horizontal" method="post" id="cmo">
                    <div class="row">
                        <div class="col-md-12 payment-detail">
                            <div class="col-md-5 no-padding">
                                <h2>Payment Allocation</h2>
                            </div>
                            <div class="col-md-7 no-padding">
                                <h2 class="available-payment"></h2>
                            </div>
                        </div>
                        <div class="col-md-12 payemnt-form ">
                            <div class="col-md-12 no-padding">
                                <div class="col-md-7 no-padding">
                                    <?php if (form_error('fname') != FALSE) { ?>
                                        <div class="alert alert-danger"><?php echo form_error('fname'); ?></div>
                                    <?php } ?>
                                    <div class="col-md-4 no-padding">
                                        <label><a href="#" class="label-text-color" data-toggle="tooltip" data-placement="top" title="The check amount will automatically equal the total amount of funds available.  You must have at least $10 available to Cash Out.">Sender Name</a></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" required="" name="fname" placeholder="Sender Name" value="<?php
                                        if (set_value('fname') != FALSE) {
                                            echo set_value('fname');
                                        } else {
                                            if (isset($userData['fullName'])) {
                                                echo $userData['fullName'];
                                            }
                                        }
                                        ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-7 no-padding">
                                    <?php if (form_error('amount') != FALSE) { ?>
                                        <div class="alert alert-danger"><?php echo form_error('amount'); ?></div>
                                    <?php } ?>
                                    <div class="col-md-4 no-padding">
                                        <label><a href="#" class="label-text-color" data-toggle="tooltip" data-placement="top" title="You are under no obligation to do so, but before you Cash Out you have the option to gift all, or a portion, of your available funds to an approved Karmora charity.  The amount that you gift will automatically reduce the amount of the check that is issued to your address.  You will instantly receive $2 Karmora Kash for every $1 that you gift!”">Gift Amount</a></label>
                                    </div>
                                    <div class="col-md-8 dollor-sign">
                                        <input type="text" placeholder="Enter Gift Amount" value="<?php
                                        if (set_value('amount') != FALSE) {
                                            echo set_value('amount');
                                        }
                                        ?>" name="amount"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-7 no-padding">
                                    <?php if (form_error('charity') != FALSE) { ?>
                                        <div class="alert alert-danger"><?php echo form_error('charity'); ?></div>
                                    <?php } ?>
                                    <div class="col-md-4 no-padding">
                                        <label><a href="#" data-toggle="tooltip" class="label-text-color" data-placement="top" title="If you cannot locate an organization that you would like to make a gift to please go to the “My Charities” section of your website and submit an application to have the organization approved as a Good Karmora Charity.">Recipient</a></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="charity" required="required" >
                                            <option value="">Select Organization</option>
                                            <?php foreach ($charityList as $charity) { ?>
                                                <option value="<?php echo $charity['pk_charity_id'] ?>"><?php echo $charity['charity_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding"> 
                                <div class="col-md-7 no-padding">
                                    <div class="col-md-4 no-padding">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="karmora-kcash2-btn">
                                            <input type="submit" name="cashout" value="Submit" class="btn-cash-1-out">
                                            <button type="reset" class="btn-cash-1-out">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12 payment-detail">
                        <div class="alert alert-warning"><?php echo 'No organisation to send gift to.' ?></div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<?php if (!empty($donation)) { ?>
    <span class="line-spc"></span><span class="line-spc"></span>  
    <section class="table-karmora-accounting table-karmora-cash-out">
        <div class="container">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped accounting-table">
                        <thead>
                            <tr>
                                <th>Transcation Date</th>
                                <th>Transaction ID</th>
                                <th>Name</th>
                                <th>Recipient</th>
                                <th>Amount </th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donation as $mem) { ?>    
                                <tr>
                                    <td><?php echo date('F d,Y', strtotime($mem['transaction_date'])); ?></td>
                                    <td><?php echo str_pad((int) $mem['transaction_id'], 5, "0", STR_PAD_LEFT); ?></td>
                                    <td><?php echo $mem['FullName']; ?></td>
                                    <td><?php echo $mem['recipient']; ?></td>
                                    <td><?php echo '$ ' . number_format($mem['amount'], 2); ?></td>
                                    <td><?php echo $mem['status']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<span class="line-spc"></span><span class="line-spc"></span>  
<section class="karmora-kash-awards">
    <div class="container award-container">
        <div class="row">
            <div class="col-md-12">
                <div class="award-key">
                    <img src="<?php echo $themeUrl ?>/images/report1.png" />
                    <h2>Report Key</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row toolbar-row1">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Transaction Date</h3>
                            <p>The date of the Cash Out or Gift request.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Transaction ID</h3>
                            <p>The unique ID# of the request. </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Name</h3>
                            <p>The name that the check was requested to be issued in.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Address</h3>
                            <p>The address where the check was requested to be mailed.</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Cashed Out</h3>
                            <p>The amount requested to be Cashed Out by check.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Gifted</h3>
                            <p>The amount gifted to a Fundraising Organization. Gifts are immediately available to the recipient. </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Fundraiser</h3>
                            <p>The name of the Fundraising Organization that received your gift.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Ck Requested</h3>
                            <p>Your check has been requested but not processed. </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Ck Processed</h3>
                            <p>Your check has been processed and is pending payment.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Ck Shipped</h3>
                            <p>Your check has been shipped standard mail. </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row">
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-left">
                        <div class="ttolbar-reward">
                            <h3>Ck Returned</h3>
                            <p>Your check has been returned and the amount has been credited back to your account as available.</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5 no-padding pull-right">
                        <div class="ttolbar-reward">
                            <h3>Ck Cancelled </h3>
                            <p>Your check has been cancelled and the amount has been credited back to your account as available.</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="toolbar-row toolbar-width-descress center-block-cover">
                    <div class="no-padding centered-block">
                        <div class="ttolbar-reward">
                            <h3>Ck Reissued</h3>
                            <p>You have requested your check to be reissued.</p>
                        </div>
                    </div>
                    <!-- <div class="col-md-5 no-padding pull-right">
                      <div class="ttolbar-reward">
                        <h3>Karmora King</h3>
                        <p>t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                      </div>
                    </div> -->
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
    </div>
</section>
