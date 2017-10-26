<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/tracker.png" class="img-fluid">Ad Tracker</h1>
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
<section class="adtracker-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Posting Karmora advertisements on social media is a fantastic way to build a strong and profitable Shopping Community.   Track your ads to see which are creating the highest traffic to your website.</h4>
                <div class="karmora-table community-table" id="ad-tracker">
                    <!-- My Cummunity Table -->
                    <?php if(!empty($adtracker)){ ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Time Stamp</th>
                            <th>Advertisement</th>
                            <th>IP Address</th>
                            <th>Media Source</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Karmora Kash</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($adtracker as $track){ if($track['tracker_ip']!='66.220.145.246' &&  $track['tracker_address'] != 'IE , ' && $track['tracker_address'] != 'US , Menlo Park' && $track['tracker_referer_page']!=''){ ?>
                        <tr>
                            <td scope="row"><?php $old_date_timestamp = strtotime($track['tracker_date']); echo $new_date = date('m-d-Y H:i:s', $old_date_timestamp); ?></td>
                            <td class="text-center"><img class="img-fluid w50" src="<?php echo $track['tracker_advertisement']; ?>" ></td>
                            <td><?php echo $track['tracker_ip']; ?></td>
                            <td>
                                <?php
                                if ( strpos($track['tracker_referer_page'],'facebook') !== false ) {
                                    echo 'Facebook';
                                } elseif ( strpos($track['tracker_referer_page'],'pintrist') !== false ) {
                                    echo 'Pintrist';
                                } elseif ( strpos($track['tracker_referer_page'],'twitter') !== false ) {
                                    echo 'Twitter';
                                }elseif ( strpos($track['tracker_referer_page'],'google') !== false ) {
                                    echo 'Google';
                                } else {
                                    echo 'Unknown Source';
                                } ?>
                            </td>
                            <?php $address = explode(",",$track['tracker_address']); ?>
                            <td><?php if(isset($address[1])){ echo $address[1]; } ?></td>
                            <td><?php if(isset($address[2])){ echo $address[2]; } ?></td>
                            <td><?php if(isset($address[0])){ echo $address[0]; } ?></td>
                            <td>$0.10</td>

                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                    <?php }  ?>
                    <!-- End My Cummunity Table -->
                </div>
            </div>
        </div>
    </div>
</section>
