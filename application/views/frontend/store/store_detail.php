<section class="karmora-store-detail">
    <div class="container">
        <div class="row">
            <?php $this->load->view('frontend/layout/partials/category'); ?>


            <div class="col-md-10">
                <!-- store detail -->
                <div class="desc-top">
                    <h1><?php echo $title; ?></h1>
                    <span class="line-spc"></span><span class="line-spc"></span>
                    <?php if (!$this->session->userdata('front_data')) { ?>
                        <div class="favBR">Cash Back Up to 30%</div>
                        <span class="line-spc"></span>
                        <?php } else { ?>
                        <div class="favBR">Cash Back <?php echo $comm_percentage; ?></div>
                        <span class="line-spc"></span>
                    <?php } ?>
                        <?php if(!empty($tripple_karmora)){ ?>
                            <p style="font-weight: 600;">Triple Karmora Kash until February 28, 2017!</p>
                        <?php } ?>
                        <span class="line-spc"></span><span class="line-spc"></span>
                    
                        <?php if($category_id!=76 && $category_id!=77){ ?>
                        <?php if (!$this->session->userdata('front_data')) { }else{?>
                        <span id="fav-<?php echo $storeId; ?>">
                        <?php if ($favoriteStore) { ?>
                            <a href="javascript:void(0)" onClick="favourtie(<?php echo $storeId ?>, 'unfvrt')" class="store-fav-icon active"><i class="fa fa-heart"></i></a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" onClick="favourtie(<?php echo $storeId ?>, 'fvrt')" class="store-fav-icon"><i class="fa fa-heart-o"></i></a>
                        <?php } ?>
                    </span>
                    <?php } ?>
                        <?php } ?>
                    <img src="<?php echo $themeUrl ?>/images/<?php echo $image; ?>">
                    <span class="line-spc"></span>
                    <p><?php echo $description; ?></p>
                    <span class="line-spc"></span><span class="line-spc"></span>
                    <?php if (!$this->session->userdata('front_data')) { ?>
                     <a href="<?php echo base_url() . 'karmora-join-now'; ?>" class="unregister-join btn-def tool-baas-hover" style="margin: 0px 45px 0 25px;  padding: 25px 35px; font-size: 30px; font-weight: 600;">Join Today!</a>
                        
                    <?php } else { ?>
                        <a href="<?php echo base_url('store-visit/' . $storeId) ?>" target="_blank" id="shop-now-btn" class="btn-def tool-baas-hover"  style="margin: 0px 45px 0 25px;  padding: 25px 35px; font-size: 30px; font-weight: 600;">Shop
                            Now</a>
                    <?php } ?>
                    <div style="display: inline-block;"><!-- 
                        <a href="<?php // echo base_url() . 'kash-back-toolbar'; ?>" target="_blank" id="shop-now-btn" class="btn-def"><img src="<?php echo $themeUrl ?>/images/settings-icon1.png" style="height: 23px; margin-top: -4px;">  Get Our ToolBar</a>
                        <p style="margin-left: 30px;">Earn $25 Karmora Kash!</p> -->
                        <a href="<?php echo base_url() . 'kash-back-toolbar'; ?>" style="padding: 0px;" target="_blank" class="tool-bar-hover">
                            <img src="<?php echo $themeUrl ?>/images/toot-bar-banner3.jpg">
                        </a>
                    </div>

                </div>

                <span class="line-spc"></span><span class="line-spc"></span>
                <?php
                //$count = 0;
                if (!empty($coupon)) {
                    ?>
                        <div class="" style="clear: both;">
                            <h3 class="text-left strore-head-copen">Top Deals</h3>
                        </div>
                        <span class="line-spc"></span>
                    <?php
                    foreach ($coupon as $coupon) {
                        //if ($count <= 2) {
                        ?>
                        <div class="offer" id="offer">
                            <div class="col-md-9">
                                <p><?php echo $coupon['coupons_storedescription']; ?> </p>
                                <p><a href="#">Coupon No: <span  class="coupon">  <?php //echo $coupon['coupons_code'];    ?> <?php echo ($coupon['coupons_code'] === '') ? 'Not Required' : $coupon['coupons_code']; ?></span></a></br>
                                </p>
                                <p><a href="#"><?php echo $comm_percentage; ?></a></p>
                            </div>
                            <div class="col-md-2" style="float: right;">
                                <?php if (!$this->session->userdata('front_data')) {
                                    ?>
                                <a href="<?php echo base_url().'login'; ?>" target="_blank"  class="btn btn-primary">Shop Now</a>
                                <?php } else {
                                    ?>
                                    <a class="btn btn-primary" data-toogle="modal" href="<?php echo base_url('coupon-visit/' . $coupon['pk_coupons_id']) ?>" target="_blank"  id="shop-now-btn">Shop Now</a>
                                <?php } ?>
                            </div>
                            <div class="col-xm-1" style="float: right; margin-top: 8px;">
                                <?php
                                if (!$this->session->userdata('front_data')) {
                                    ?>
                                    <a href="#" id="addfav-button" data-toggle="modal" data-target="#signupModal">add</a>
                                    <?php
                                } else {
                                    if ($coupon['pk_favortie_coupon_id'] != '') {
                                        ?>
                                        <a href="<?php echo base_url() . 'CoUnfavourtie/' . $coupon['pk_coupons_id'] . '/' . $storeId ?>" id="addfav-button" class="active">add</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url() . 'Cofavourtie/' . $coupon['pk_coupons_id'] . '/' . $storeId ?>" id="addfav-button" >add</a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        //}
                        //$count++;
                    }
                } else {
                    ?>
                    <div style="margin-bottom: 20%;"></div>
                <?php }
                ?>
            </div>


            <div class="clearfix"></div>


        </div>
    </div>
</section>

<script>
    function favourtie(storeId, option_type) {

        jQuery.ajax({
            type: 'POST',
            url: baseurl + 'storefavourtie/' + storeId + '/' + option_type,
            context: document.body,
            error: function (data, transport) {
                alert("Sorry, the operation is failed.");
            },
            success: function (data) {
                $('#fav-' + storeId).html('');
                if (option_type === 'fvrt') {
                    var onclick_condation = "favourtie(" + storeId + ",'unfvrt')";
                    $('#fav-' + storeId).html('<a href="javascript:void(0)" onClick=' + onclick_condation + ' id="' + storeId + '" class="fav-icon active"><i class="fa fa-heart"></i></a>');
                } else {
                    var onclick_condation = "favourtie(" + storeId + ",'fvrt')";
                    $('#fav-' + storeId).html('<a href="javascript:void(0)" onClick=' + onclick_condation + ' id="' + storeId + '" class="fav-icon"><i class="fa fa-heart-o"></i></a>');
                }
            }
        });
    }
</script>



