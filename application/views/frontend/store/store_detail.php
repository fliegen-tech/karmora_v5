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
                            <h1><?php echo $store_detail->title; ?></h1>
                        </div>
                    </div>
                    <div class="stores-detail-cover border-none">
                        <div class="row">
                            <div class="col-12">
                                <?php if (!$this->session->userdata('front_data')) { ?>
                                    <h2>Cash Back Up to 30%</h2>
                                <?php } else { ?>
                                    <h2>Cash Back <?php echo $comm_percentage; ?></h2>
                                <?php } ?>

                            </div>
                            <div class="stores-cover">
                                <div class="col-12">
                                    <?php if ($this->session->userdata('front_data')){ ?>
                                        <?php if ($favoriteStore) { ?>
                                            <a href="javascript:void(0)" onClick="favourtie(<?php echo $store_detail->store_id ?>, 'unfvrt')"><i class="fa fa-heart"></i></a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)" onClick="favourtie(<?php echo $store_detail->store_id ?>, 'fvrt')" ><i class="fa fa-heart-o"></i></a>
                                            <?php } ?>
                                    <?php } ?>
                                    <img src="<?php echo $themeUrl ?>/images/<?php echo $store_detail->store_image; ?>" alt="">
                                    <p><?php echo $store_detail->store_description; ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="stores-btn">
                                    <div class="text-center">
                                        <?php if (!$this->session->userdata('front_data')) { ?>
                                            <a href="<?php echo base_url() . 'karmora-join-now'; ?>" class="btn btn-joinnow left-right-hover" >Join Today!</a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url('store-visit/' . $store_detail->store_id) ?>" target="_blank" class="btn btn-joinnow left-right-hover" >Shop Now</a>
                                        <?php } ?>
                                    </div>
                                    <div class="text-center">
                                        <a href="#">
                                            <img src="<?php echo $themeUrl ?>/frontend/images/tool-bar-strore-banner.jpg" alt="">
                                        </a>
                                    </div>
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





