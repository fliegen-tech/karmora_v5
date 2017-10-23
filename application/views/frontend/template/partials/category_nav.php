<?php if (!empty($categories)) { ?>
    <div class="col-3">
        <div class="collapse in show sidebar" id="sidebar">
            <div class="list-group panel">
                <a href="<?php echo base_url('special-offer/cash_o_palooza') ?>"
                   class="list-group-item important-cashback collapsed" data-parent="#sidebar">Double Take</a>
                <a href="<?php echo base_url('special-offer/smokin_hot_deals') ?>"
                   class="list-group-item important-cashback collapsed" data-parent="#sidebar">Smokin Hot Deals</a>
                <a href="<?php echo base_url('store/all'); ?>" class="list-group-item important-cashback collapsed"
                   data-parent="#sidebar">View All Stores</a>
                <?php if (!$this->session->userdata('front_data')) { ?>
                    <a href="<?php echo base_url() . 'login'; ?>" class="list-group-item important-cashback collapsed">My
                        Favorites </a>
                <?php } else { ?>
                    <a href="<?php echo base_url('my-favorite'); ?>"
                       class="list-group-item important-cashback collapsed">My Favorites </a>
                <?php } ?>

                <?php foreach ($categories as $cat) { ?>
                    <a href="<?php echo base_url('store/' . $cat['alias']); ?>" class="list-group-item collapsed"
                       data-toggle="collapse" data-parent="#sidebar"
                       aria-expanded="false"><?php echo $cat['title']; ?></a>
                    <?php if (!empty($top_stores)) {
                        foreach ($top_stores as $k => $v) {
                            if ($cat['alias'] === $k) {
                                foreach ($top_stores[$cat['alias']] as $store) { ?>
                                    <a href="<?php echo base_url('store-detail/' . $store['store_id']) ?>"
                                       class="list-group-item"
                                       data-parent="#menu3"><?php echo $store['store_title']; ?></a>
                                    <?php
                                }
                                next($top_stores);
                            }
                        } ?>
                        <a href="<?php echo base_url('store/' . $cat['alias']); ?>" class="list-group-item">View All</a>
                    <?php }
                } ?>
            </div>
        </div>
        <!-- <main class="col-md-9 col-xs-11 p-l-2 p-t-2">
            <a href="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-lg"></i></a>
        </main> -->
    </div>
<?php } ?>

