<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/training.png" class="img-fluid">My Training
                    </h1>
                </div>
            </div>
            <?php $this->load->view('frontend/user/dashboard_nav_bar'); ?>
        </div>
    </div>
    <?php $this->load->view('frontend/user/dashboard_info_bar'); ?>
</section>
<!--====  End of Dashbaord====-->
<section class="training-categories page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="list-inline training-types">
                    <li class="list-inline-item">
                        <a href="<?php echo base_url() . 'karmora-about-training' ?>">About Karmora</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo base_url() . 'karmora-exclusive-products-training' ?>">Exclusive
                            Products</a>
                    </li>
                    <li class="list-inline-item active">
                        <a href="<?php echo base_url() . 'karmora-training-making-money' ?>">Making Money</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php if (!empty($ProfitableShoppingCommunity)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="training-table" id="training-table">
                        <h2>Making Money</h2>
                        <!-- My Cummunity Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>File Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ProfitableShoppingCommunity as $shoping) { ?>
                                    <tr>
                                        <td scope="row"><?php $date = date_create($shoping['training_date']);
                                            echo date_format($date, "M d,Y"); ?></td>
                                        <td>
                                            <?php if ($shoping['training_type'] == 'youtube' && $shoping['training_url'] != '') { ?>
                                                <a href="<?php echo $shoping['training_url']; ?>" target="_blank">
                                                    <?php echo $shoping['training_title']; ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shoping['training_content']; ?>">
                                                    <?php echo $shoping['training_title']; ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $shoping['training_author']; ?></td>
                                        <td>
                                            <?php if ($shoping['training_type'] == 'youtube' && $shoping['training_url'] != '') { ?>
                                                <a href="<?php echo $shoping['training_url']; ?>" target="_blank">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shoping['training_type']; ?>.png">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shoping['training_content']; ?>">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shoping['training_type']; ?>.png">
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End My Cummunity Table -->
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($MakingCompensationPlan)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="training-table" id="training-table">
                        <h2>Compensation Plan</h2>
                        <!-- My Cummunity Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>File Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($MakingCompensationPlan as $shopingz) { ?>
                                    <tr>
                                        <td scope="row"><?php $date = date_create($shopingz['training_date']);
                                            echo date_format($date, "M d,Y"); ?></td>
                                        <td><?php if ($shopingz['training_type'] == 'youtube' && $shopingz['training_url'] != '') { ?>
                                                <a href="<?php echo $shopingz['training_url']; ?>" target="_blank">
                                                    <?php echo $shopingz['training_title']; ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shopingz['training_content']; ?>">
                                                    <?php echo $shopingz['training_title']; ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $shopingz['training_author']; ?></td>
                                        <td>
                                            <?php if ($shopingz['training_type'] == 'youtube' && $shopingz['training_url'] != '') { ?>
                                                <a href="<?php echo $shopingz['training_url']; ?>" target="_blank">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shopingz['training_type']; ?>.png">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shopingz['training_content']; ?>">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shopingz['training_type']; ?>.png">
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End My Cummunity Table -->
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($MakingMoneyRetailSales)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="training-table" id="training-table">
                        <h2>Retail Sales</h2>
                        <!-- My Cummunity Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>File Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($MakingMoneyRetailSales as $shopingS) { ?>
                                    <tr>
                                        <td scope="row"><?php $date = date_create($shopingS['training_date']);
                                            echo date_format($date, "M d,Y"); ?></td>
                                        <td><?php if ($shopingS['training_type'] == 'youtube' && $shopingS['training_url'] != '') { ?>
                                                <a href="<?php echo $shopingS['training_url']; ?>" target="_blank">
                                                    <?php echo $shopingS['training_title']; ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shopingS['training_content']; ?>">
                                                    <?php echo $shopingS['training_title']; ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $shopingS['training_author']; ?></td>
                                        <td>
                                            <?php if ($shopingS['training_type'] == 'youtube' && $shopingS['training_url'] != '') { ?>
                                                <a href="<?php echo $shopingS['training_url']; ?>" target="_blank">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shopingS['training_type']; ?>.png">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url() . 'download-training/karmora-training-making-money/' . $shopingS['training_content']; ?>">
                                                    <img
                                                        src="<?php echo $themeUrl ?>/frontend/images/<?php echo $shopingS['training_type']; ?>.png">
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End My Cummunity Table -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<!--====  End of Dashbaord====-->


