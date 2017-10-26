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
<!--=========================================
=            Dashbaord          =
==========================================-->
<section class="training-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="training-cover">
                    <div class="training-img">
                        <a href="<?php echo base_url().'karmora-about-training' ?>">
                            <img src="<?php echo $themeUrl ?>/frontend/images/training1.png" alt="">
                        </a>
                    </div>
                    <div class="traing-desp">
                        <a href="<?php echo base_url().'karmora-about-training' ?>">
                            <h3>About Karmora</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="training-cover">
                    <div class="training-img">
                        <a href="<?php echo base_url().'karmora-exclusive-products-training' ?>">
                            <img src="<?php echo $themeUrl ?>/frontend/images/training2.png" alt="">
                        </a>
                    </div>
                    <div class="traing-desp">
                        <a href="<?php echo base_url().'karmora-exclusive-products-training' ?>">
                            <h3>Exclusive Products</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="training-cover">
                    <div class="training-img">
                        <a href="<?php echo base_url().'karmora-training-making-money' ?>">
                            <img src="<?php echo $themeUrl ?>/frontend/images/training3.png" alt="">
                        </a>
                    </div>
                    <div class="traing-desp">
                        <a href="<?php echo base_url().'karmora-training-making-money' ?>">
                            <h3>Making Money</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====  End of Dashbaord====-->
