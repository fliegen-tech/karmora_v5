<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/home.png" class="img-fluid">My EWallet</h1>
                </div>
            </div>
            <?php $this->load->view('frontend/user/dashboard_nav_bar'); ?>
        </div>
    </div>
    <?php $this->load->view('frontend/user/dashboard_info_bar'); ?>
</section>
<!--====  End of Dashbaord====-->
<section class="my-ewallet-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-4 mx-auto">
                <?php $this->load->view('frontend/dashboard/partials/download_report'); ?>
            </div>
            <div class="col-12">
                <div class="ewallet-tabs">
                    <div class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                        <a class="nav-link active" id="cashback-commissions" data-toggle="pill" href="#cb-commissions" role="tab" >Cash Back & Commissions</a>
                        <a class="nav-link" id="excluive-comission" data-toggle="pill" href="#ep-commission" role="tab" >Exclusive Product Commissions</a>
                        <a class="nav-link" id="v-pills-summery" data-toggle="pill" href="#summary" role="tab">Summary</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="cb-commissions" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="col-8 mx-auto">
                        <div class="topbar-things">
                            <ul class="list-inline">
                                <li class="list-inline-item"><span>Cash Back Paid:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->cash_back_ytd;} ?></li>
                                <li class="list-inline-item"><span>Commission Paid:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->cash_back_paid;} ?></li>
                                <li class="list-inline-item"><span>Pending:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->cash_back_pending;} ?></li>
                                <li class="list-inline-item"><span>Returned:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->cash_back_returned;} ?></li>
                            </ul>
                        </div>
                    </div>
                    <?php $this->load->view('frontend/dashboard/partials/mycashback_summary'); ?>
                </div>

                <div class="tab-pane fade" id="ep-commission" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="col-8 mx-auto">
                        <div class="topbar-things">
                            <ul class="list-inline">
                                <li class="list-inline-item"><span>Commission Paid: </span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->exclusive_commissions_paid;} ?></li>
                                <li class="list-inline-item"><span>Pending:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->exclusive_commissions_pending;} ?></li>
                                <li class="list-inline-item"><span>Returned:</span>$<?php if(!empty($exectivesummery)){ echo $exectivesummery->exclusive_commissions_returned;} ?></li>
                            </ul>
                        </div>
                    </div>
                    <?php $this->load->view('frontend/dashboard/partials/product_commsion'); ?>
                </div>

                <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="col-8 mx-auto">
                        <div class="topbar-things">
                            <ul class="list-inline">
                                <li class="list-inline-item"><span> Cashed Out: </span>$<?php if(!empty($exectivesummery)){ echo number_format($exectivesummery->cashed_out_ytd, 2, '.', ',');} ?></li>
                                <li class="list-inline-item"><span>Redeemed:</span> $<?php if(!empty($exectivesummery)){ echo number_format($exectivesummery->redeemed_ytd, 2, '.', ',');} ?> </li>
                                <li class="list-inline-item"><span>Gifted:</span>$<?php if(!empty($exectivesummery)){ echo number_format($exectivesummery->cashed_out_ytd_gifted, 2, '.', ',');} ?></li>
                            </ul>
                        </div>
                    </div>
                    <?php $this->load->view('frontend/dashboard/partials/check_request'); ?>
                    <?php $this->load->view('frontend/dashboard/partials/gift_section'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
