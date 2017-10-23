<section class="cash-back-sec page-spacing">
    <div class="container">
        <div class="cashback-cover">
            <div class="row">
                <div class="col-3">
                    <?php $this->load->view('frontend/template/partials/category_nav'); ?>
                </div>
                <div class="col-9 p-l-0">
                    <div class="col-12">
                        <div class="top-heading-cover">
                            <h1>All Stores</h1>
                        </div>
                    </div>
                    <div class="all-stroes-cover">
                        <div class="row">
                            <div class="col-12">
                                <div class="karmora-table community-table" id="hunt-table">
                                    <!-- My Cummunity Table -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Store Name</th>
                                            <th>Cash Back</th>
                                            <th>Favorites</th>
                                            <th>Shop</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="goes-link">
                                            <td scope="row" colspan="4" class="text-center">
                                                <a id="top" class="smooth-scroll"></a>
                                                <?php
                                                $first = true;
                                                foreach ($storeArray as $nouseVars) {
                                                    if ($first) {
                                                        reset($storeArray);
                                                        $first = false;
                                                    }
                                                    ?>
                                                    <a href="#<?php echo key($storeArray); ?>"><?php echo key($storeArray); ?></a>
                                                    <?php
                                                    next($storeArray);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $first = true;
                                            foreach ($storeArray as $storeIn) {
                                            if ($first) {
                                                reset($storeArray);
                                                $first = false;
                                            }
                                        ?>
                                        <tr class="number-top">
                                            <td colspan="3">
                                                <a  class="smooth-scroll" href="#" id="<?php echo key($storeArray); ?>" name=""><b><?php echo key($storeArray); ?></b></a>
                                            </td>
                                            <td class="text-center"><a href="#top">Back to Top</a></td>
                                        </tr>
                                        <?php foreach ($storeIn as $store) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url() ?>store-detail/<?php echo $store['store_id'] ?>"><?php echo $store['store_title']; ?></td>
                                            <td>
                                                <?php if (!$this->session->userdata('front_data')) {
                                                    echo 'Up to 30%';
                                                } else {
                                                    echo $store['cash_back_percentage'];
                                                } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php  if (!$this->session->userdata('front_data')) { ?>
                                                    <a href="<?php echo base_url() . 'login' ?>" id="addfav-button">Login</a>
                                                    <?php } else {
                                                        if ($store['fk_store_id'] != '') {
                                                    ?>
                                                    <span id="fav-<?php echo $store['store_id'] ?>"><a href="javascript:void(0)" onClick="favourtie(<?php echo $store['store_id'] ?>, 'unfvrt')" id="<?php echo $store['store_id']; ?>" ><i class="fa fa-heart"></i></a></span>
                                                    <?php } else { ?>
                                                        <span id="fav-<?php echo $store['store_id'] ?>"><a href="javascript:void(0)" onClick="favourtie(<?php echo $store['store_id'] ?>, 'fvrt')" id="<?php echo $store['store_id']; ?>" ><i class="fa fa-heart-o"></i></a></span>
                                                    <?php } } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!$this->session->userdata('front_data')) {
                                                    ?>
                                                    <a  class="btn btn-joinnow left-right-hover" href="<?php echo base_url() . 'premier-shopper-signup' ?>">Join Today</a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url() ?>store-visit/<?php echo $store['store_id'] ?>" target="_blank" class="btn btn-joinnow left-right-hover">Shop Now</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                            <?php } next($storeArray); } ?>
                                        </tbody>
                                    </table>
                                    <!-- End My Cummunity Table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('frontend/store/store_js'); ?>

