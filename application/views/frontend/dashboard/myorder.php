<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/orders.png" class="img-fluid">My Orders</h1>
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

<?php if(!empty($userOrder)){ ?>
<section class="my-order-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="karmora-table community-table" id="my-orders">
                    <!-- My Cummunity Table -->
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Date</th>
                            <th>Order#</th>
                            <th>Ship To</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0;foreach ($userOrder as $order) { $i++;?>
                        <tr>
                            <td scope="row"><?php echo $i; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo '<a href="'.base_url('my-orders/'.$order['order_no']).'" title="#'.$order['order_no'].'">'.$order['order_no'].'</a>'; ?></td>
                            <td><?php echo $order['ship_to']; ?></td>
                            <td>$<?php echo number_format($order['order_cal_total'],2,'.',','); ?></td>
                            <td><?php if($order['status'] == 'declined'){ echo 'Payment Awaited'; }else if($order['status'] == 'canceled'){ echo 'Cancelled'; }else{ echo ucwords($order['status']);}?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <!-- End My Cummunity Table -->
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>