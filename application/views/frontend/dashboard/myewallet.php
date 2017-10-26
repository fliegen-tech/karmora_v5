<?php $this->load->view('frontend/layout/partials/reporting_nav_bar'); ?>
<?php
$CI = &get_instance();
$CI->load->model('cartmodel');
$data['CI'] = $CI;
?>
<span class="line-spc"></span><span class="line-spc"></span>
<section class="ewallet-table-sec" id="my_cash_back_table">
    <?php $this->load->view('frontend/dashboard/partial_mycashback'); ?>
</section>
<span class="line-spc"></span><span class="line-spc"></span>
<div class="my_commsion_focus"></div>
<?php if (!empty($commsion)) {
    ?>

    <section class="ewallet-table-sec" id="my_commsion_table" style="display:none;">
        <div class="container">
            <h2 class="ewallet-heading">EXCLUSIVE PRODUCT COMMISSIONS</h2>
            <span class="line-spc"></span>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="example" class="table my-ewallet-devlp expc-tab" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Shopper</th>
                            <!--<th>Floor</th>-->
                            <th>Order</th>
                            <th>Purchase Price</th>
                            <th>Commission</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;
                        foreach ($commsion as $c) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $c['date']; ?></td>
                                <td><?php //echo $c['description']; ?><?php echo is_numeric($c['floor']) ? 'Commission' : 'Profit Sharing Payment'; ?></td>
                                <td><?php echo $c['shopper']; ?></td>
                                <!--<td align="center"><?php echo $c['floor']; ?></td>-->
                                <?php $userOrder = $CI->cartmodel->getOrderDetailTotalsSummery_row($c['fk_order_id']); ?>
                                <?php $Orderproduct = $CI->cartmodel->getOrderProduct($c['fk_order_id']);
                                //echo '<pre>'; print_r($Orderproduct); //die;?>
                                <td align="center"><a href="#" data-toggle="modal"
                                                      data-target="#orderpopup_<?php echo $c['fk_order_id']; ?>">Order
                                        Detail</a>
                                    <div class="modal fade" id="orderpopup_<?php echo $c['fk_order_id']; ?>"
                                         tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog order-modal" role="document">
                                            <div class="modal-content model-save-money">
                                                <div class="modal-header">
                                                    <button type="button" class="close popup-close order-close"
                                                            data-dismiss="modal" aria-label="Close"><i
                                                            class="fa fa-times"></i></button>

                                                    <!-- <h4 class="modal-title karmora-save-title" id="myModalLabel">Orders</h4> -->
                                                </div>
                                                <div class="modal-body">

                                                    <section class="shopping-car-sect edit-shopping-cart">


                                                        <div class="edit-table-border">
                                                            <div class="order-summery-fai">
                                                                <div class="col-md-6 text-left">
                                                                    <h2>Order Detail:</h2>
                                                                </div>
                                                                <div class="col-md-6 text-right">
                                                                    <h2 style="font-size: 24px;">
                                                                        #<?php echo $userOrder->order_numbr; ?></h2>
                                                                    <h2 class="date-order-fa"
                                                                        style="font-size: 16px;"><?php echo $userOrder->order_create_date; ?></h2>
                                                                </div>
                                                            </div>


                                                            <span class="line-spc"></span>
                                                            <div class="clearfix"></div>

                                                            <span class="line-spc"></span>
                                                            <div class="clearfix"></div>

                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="order-table-box table table-hover">
                                                                        <thead class="table-head-header">
                                                                        <tr>
                                                                            <th><i class="table-head-icons">#</i>Product
                                                                                Line
                                                                            </th>
                                                                            <th>
                                                                                <i class="fa fa-info table-head-icons"></i>Product
                                                                                Description
                                                                            </th>
                                                                            <th><i class="table-head-icons">#</i>Qty
                                                                            </th>
                                                                            <th style="font-size: 14px;"><i
                                                                                    class="fa fa-dollar table-head-icons"></i>Extended
                                                                                Price
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $total_amount = 0;
                                                                        $i = 0;
                                                                        foreach ($Orderproduct as $pr) {
                                                                            $i++;
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $i; ?></td>
                                                                                <td><?php echo $pr['product_title']; ?></td>
                                                                                <td><?php echo $pr['order_line_qty']; ?></td>
                                                                                <td>$<?php
                                                                                    if ($pr['order_line_notes'] == 'Free Gifts') {
                                                                                        echo 19.95 . ' (Limted time offer)';
                                                                                    } else {
                                                                                        echo number_format($pr['order_line_price'] * $pr['order_line_qty'], 2, ".", ",");
                                                                                    }
                                                                                    ?></td>
                                                                            </tr>
                                                                            <?php $sum_total = number_format($pr['order_line_price'] * $pr['order_line_qty'], 2, ".", ","); ?>
                                                                            <?php $total_amount = $sum_total + $total_amount; ?>
                                                                            <?php
                                                                            if ($pr['order_line_notes'] == 'Free Gifts') {
                                                                                $total_amount = 19.95;
                                                                            }
                                                                            ?>
                                                                        <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <span class="line-spc"></span>
                                                                <div class="clearfix"></div>
                                                                <div
                                                                    class="col-md-6 col-sm-4 col-xs-12 col-md-offset-3">
                                                                    <ul class="invoice-sum list-unstyled">
                                                                        <li>
                                                                            <?php if ($total_amount != 0) { ?>
                                                                                <span class="text-right">
                                                                                        Exclusive Product Total
                                                                                    </span>
                                                                                <span class="stump-font">
                                                                                <?php echo '$' . number_format($total_amount, 2, '.', ','); ?>
                                                                                    </span>
                                                                            <?php } ?>
                                                                        </li>
                                                                        <?php if ($userOrder->order_karmora_cash_price != 0) { ?>
                                                                            <li>
                                                                                    <span class="text-right">
                                                                                        Karmora Kash
                                                                                    </span>
                                                                                <span class="stump-font"
                                                                                      style="color: red;">
                                                                                        -$<?php echo number_format($userOrder->order_karmora_cash_price, 2, '.', ','); ?>
                                                                                    </span>

                                                                            </li>
                                                                        <?php } ?>
                                                                        <li>
                                                                                <span class="text-right">
                                                                                    Commissionable Value
                                                                                </span>
                                                                            <span class="stump-font">
        <?php echo '$' . number_format($total_amount - $userOrder->order_karmora_cash_price, 2, '.', ','); ?>
                                                                                </span>
                                                                        </li>
                                                                        <div class="clearfix"></div>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <!--  Product Box -->

                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td align="center"><?php echo '$ ' . number_format($c['purchase_price'], 2); ?></td>
                                <td align="center"><?php echo '$ ' . number_format($c['commission'], 2); ?></td>
                                <td><?php echo $c['status']; ?></td>
                            </tr>


                        <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


    <?php /* cash me out tables */ ?>

    <section id="mycashmeout-table" style="display: none;">
        <?php if (!empty($CashMeMember)) { ?>
            <span class="line-spc product640"></span><span class="line-spc product480"></span>
            <?php
            $this->load->view('frontend/cashmeout/partial_cashout_history');
        }
        ?>
    </section>


    <?php
}
$this->load->view('frontend/layout/partials/reporting_click_to_win_table');
?>


<?php /*
  <section class="karmora-kash-awards">
  <div class="container award-container">
  <div class="row">
  <div class="col-md-12">
  <div class="award-key">
  <img src="<?php echo $themeUrl; ?>/images/award.png">
  <h2>Report Key</h2>
  </div>
  </div>
  <div class="col-md-12">
  <div class="toolbar-row toolbar-row1">
  <div class="col-xs-5  no-padding pull-left">
  <div class="ttolbar-reward">
  <h3>Paid</h3>
  <p>The total amount of Cash Back and Good Karmora Bonuses paid.</p>
  </div>
  </div>
  <div class="col-xs-5 no-padding pull-right">
  <div class="ttolbar-reward">
  <h3>Pending</h3>
  <p>The total amount of purchases that have been reported for that month that are pending payment by the advertisers, which typically takes 60�?90 days. </p>
  </div>
  </div>
  <div class="clearfix"></div>
  </div>
  </div>
  <div class="col-md-12">
  <div class="toolbar-row toolbar-row1">
  <div class="col-xs-5 no-padding pull-left">
  <div class="ttolbar-reward">
  <h3>Cashed Out</h3>
  <p>The total amount that you elected Cash Out for that month. </p>
  </div>
  </div>
  <div class="col-xs-5 no-padding pull-right">
  <div class="ttolbar-reward">
  <h3>Returned</h3>
  <p>The amount deducted from your account once your Return of any exclusive or retail product is processed.</p>
  </div>
  </div>
  <div class="clearfix"></div>
  </div>
  </div>







  </div>
  </div>
  </section>
 */ ?>
<!--<script>
  $(document).ready(function() {
    var dataTable = $('#my_commsion').dataTable({
        iDisplayLength: 10,
        sPaginationType: "full_numbers"
    });
    function my_commsionScroll() {
        $('html, body').animate({
           scrollTop: $(".my_commsion_focus").offset().top
        }, 100);
        $(".paginate_button").unbind('click', my_commsionScroll);
        $(".paginate_button").bind('click', my_commsionScroll);
    }
    my_commsionScroll();
});
</script>
<script>
  $(document).ready(function() {
    var dataTable = $('#my_cash_back').dataTable({
        iDisplayLength: 10,
        sPaginationType: "full_numbers"
    });
    function paginateScroll() {
        $('html, body').animate({
           scrollTop: $("#my_cash_back_table").offset().top
        }, 100);
        $(".paginate_button").unbind('click', paginateScroll);
        $(".paginate_button").bind('click', paginateScroll);
    }
    paginateScroll();
});
</script>-->

