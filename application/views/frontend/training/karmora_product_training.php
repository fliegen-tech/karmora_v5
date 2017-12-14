<section class="user-dashboard page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h1><img src="<?php echo $themeUrl ?>/frontend/images/training.png" class="img-fluid">My Training</h1>
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
                        <a href="<?php echo base_url().'karmora-about-training' ?>">About Karmora</a>
                    </li>
                    <li class="list-inline-item active">
                        <a href="<?php echo base_url().'karmora-exclusive-products-training' ?>">Exclusive Products</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo base_url().'karmora-training-making-money' ?>">Making Money</a>
                    </li>
                </ul>
            </div>
        </div>

        <?php if(!empty($productGeneralInformation)){ ?>
        <div class="row">
            <div class="col-12">
                <div class="training-table" id="training-table">
                    <h2>Exclusive Products</h2>
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
                            <?php foreach($productGeneralInformation as $gernal){ ?>
                                <tr>
                                <td scope="row"><?php $date=date_create($gernal['training_date']); echo date_format($date,"M d,Y"); ?>/td>
                                <td>
                                    <?php if($gernal['training_type'] == 'youtube' && $gernal['training_url']!=''){ ?>
                                        <a href="<?php echo $gernal['training_url']; ?>" target="_blank">
                                            <?php echo $gernal['training_title']; ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo base_url().'download-training/karmora-exclusive-products-training/'.$gernal['training_content']; ?>">
                                            <?php echo $gernal['training_title']; ?>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><?php echo $gernal['training_author']; ?></td>
                                <td>
                                    <?php if($gernal['training_type'] == 'youtube' && $gernal['training_url']!=''){ ?>
                                        <a href="<?php echo $gernal['training_url']; ?>" target="_blank">
                                            <img src="<?php echo $themeUrl ?>/frontend/images/<?php echo $gernal['training_type']; ?>.png">
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo base_url().'download-training/karmora-exclusive-products-training/'.$gernal['training_content']; ?>">
                                            <img src="<?php echo $themeUrl ?>/frontend/images/<?php echo $gernal['training_type']; ?>.png">
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
        <?php if(!empty($productfalwesSkincare)){ ?>
        <div class="row">
            <div class="col-12">
                <div class="training-table" id="training-table">
                    <h2>Flawless Skincare</h2>
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
                            <?php foreach($productfalwesSkincare as $pro){ ?>
                                <tr>
                                <td scope="row"><?php $date=date_create($pro['training_date']); echo date_format($date,"M d,Y"); ?></td>
                                <td>
                                    <?php if($pro['training_type'] == 'youtube' && $pro['training_url']!=''){ ?>
                                        <a href="<?php echo $pro['training_url']; ?>" target="_blank">
                                            <?php echo $pro['training_title']; ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo base_url().'download-training/karmora-exclusive-products-training/'.$pro['training_content']; ?>">
                                            <?php echo $pro['training_title']; ?>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><?php echo $pro['training_author']; ?></td>
                                <td>
                                    <?php if($pro['training_type'] == 'youtube' && $pro['training_url']!=''){ ?>
                                        <a href="<?php echo $pro['training_url']; ?>" target="_blank">
                                            <img src="<?php echo $themeUrl ?>/frontend/images/<?php echo $pro['training_type']; ?>.png">
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo base_url().'download-training/karmora-exclusive-products-training/'.$pro['training_content']; ?>">
                                            <img src="<?php echo $themeUrl ?>/frontend/images/<?php echo $pro['training_type']; ?>.png">
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
