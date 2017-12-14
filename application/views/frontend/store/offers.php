<section class="cash-back-sec page-spacing">
    <div class="container">
        <div class="cashback-cover">
            <div class="row">
                <div class="col-3">
                    <?php $this->load->view('frontend/template/partials/category_nav'); ?>
                </div>
                <div class="col-9 p-l-0">
                    <div class="cash-o-palooza-page-cover">
                        <div class="cash-o-palooza-header">
                            <img src="<?php echo $themeUrl.'/images/categories/'.$category_detail['category_image']?>" alt="">
                        </div>
                        <?php if(!empty($deals)){ ?>
                        <div class="cop-deals-cover">
                            <div class="row">
                                <?php foreach($deals as $deal) { ?>
                                    <?php
                                    if (!$this->session->userdata('front_data')) {
                                        $loadimage = $deal['store_not_login_banner'];
                                        $link = base_url('join-today');
                                        $caption = 'Join Now';
                                    }else{
                                        $loadimage = $deal['store_image'];
                                        $link = base_url('store-detail/'.$deal['store_id']);
                                        $caption = 'Visit Store';
                                    }
                                    ?>
                                    <div class="col-4">
                                        <div class="shd-cover">
                                            <a href="<?php echo $link;?>">
                                                <img src="<?php echo $themeUrl?>/images/<?php echo $loadimage;?>" alt="">
                                            </a>
                                            <div class="text-center">
                                                <a href="<?php echo $link;?>" class="btn btn-joinnow left-right-hover"><?php echo $caption;?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
