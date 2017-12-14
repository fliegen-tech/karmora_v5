<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/images/my-kash.png" class="img-fluid">My Karmora Kash Rewards</h1>
                </div>
            </div>
            <?php $this->load->view('frontend/user/dashboard_nav_bar'); ?>
        </div>
    </div>
    <?php $this->load->view('frontend/user/dashboard_info_bar'); ?>
</section>

<!--=========================================
=            Dashbaord          =
==========================================-->
<section class="my-karmora-kash-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="karmora-table community-table table-responsive" id="my-karmora-kash">
                    <!-- My Cummunity Table -->
                    <?php if (is_array($karmoraKash)) { ?>
                        <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shopper</th>
                            <th>Amount</th>
                            <th>Reward</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($karmoraKash as $key => $value) { ?>
                            <tr>
                                <td scope="row"><?php echo $value['date']; ?></td>
                                <td><?php echo $value['shopper']; ?></td>
                                <td><?php echo $amount = $value['amount'] > 0 ? '$' . number_format($value['amount'], 2) : '-$' . number_format(abs($value['amount']), 2); ?></td>
                                <td><?php echo $value['description']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>
                    <!-- End My Cummunity Table -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--====  End of Dashbaord====-->


<section class="karmora-kash-sec">
    <div class="container">
        <div class="karmora-kash-ways">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="kash-ways-leftbar">
                        <span class="ways-number">1</span>
                    </div>
                </div>
                <div class="col-10">
                    <div class="kash-ways-rightbar">
                        <h3>Membership Rewards!</h3>
                        <p>Earn limitless Karmora Kash Rewards while building a Shopping Community!</p>
                    </div>
                    <div class="karmora-ways-table">
                        <div class="karmora-table table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Karmora Kash Reward</th>
                                    <th>Premier Shopper</th>
                                    <th>Casual Shopper</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">Personal Welcome Reward</td>
                                    <td>$20</td>
                                    <td>$10</td>
                                </tr>
                                <tr>
                                    <td scope="row">Premier Shopper Membership Reward</td>
                                    <td>$10</td>
                                    <td>None</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="karmora-kash-ways">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="kash-ways-leftbar">
                        <span class="ways-number">2</span>
                    </div>
                </div>
                <div class="col-10">
                    <div class="kash-ways-rightbar">
                        <h3>Activity Rewards!</h3>
                        <p>Our Shoppers can earn Karmora Kash without spending a single penny!   Engage in the below activities and earn Karmora Kash for huge discounts on our Exclusive Products!</p>
                    </div>
                    <div class="karmora-ways-table">
                        <div class="karmora-table table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Karmora Kash Reward</th>
                                    <th>Premier Shopper</th>
                                    <th>Casual Shopper</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">Karmora Care</td>
                                    <td>$2 for every $1 Gifted</td>
                                    <td>$2 for every $1 Gifted</td>
                                </tr>
                                <tr>
                                    <td scope="row">Pay-Per-Click</td>
                                    <td>$0.10 per a Click</td>
                                    <td>$0.05 per a Click</td>
                                </tr>
                                <tr>
                                    <td scope="row">Click2Win Rewards</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="karmora-kash-ways">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="kash-ways-leftbar">
                        <span class="ways-number">3</span>
                    </div>
                </div>
                <div class="col-10">
                    <div class="kash-ways-rightbar">
                        <h3>Shopping Rewards!</h3>
                        <p>Earn Matching Karmora Kash on every purchase made by your entire Global Shopping Community!</p>
                    </div>
                    <div class="karmora-ways-table">
                        <div class="karmora-table table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Karmora Kash Reward</th>
                                    <th>Premier Shopper</th>
                                    <th>Casual Shopper</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">Personal Cash Back Match</td>
                                    <td>$2 for $1 Match</td>
                                    <td>None</td>
                                </tr>
                                <tr>
                                    <td scope="row">Community Cash Back Match</td>
                                    <td>$1 for $1 Match</td>
                                    <td>None</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	$(document).ready(function(){
		//$(".table").DataTable();
	});
</script>