<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/community.png" class="img-fluid">My Community</h1>
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
<section class="community-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="karmora-table community-table" id="my-community">
                    <!-- My Cummunity Table -->
                    <?php if (!empty($community)) { ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Join Date</th>
                            <th>Name</th>
                            <th>Membership Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($community as $c) { ?>
                        <tr>
                            <td scope="row"><?php echo $c['join_date']; ?></td>
                            <td><?php echo $c['name']; ?></td>
                            <td><?php echo $c['membership_status']; ?></td>
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

