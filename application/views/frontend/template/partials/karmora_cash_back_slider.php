<style type="text/css">
    .slick-slider-works {
        overflow: hidden;
        height: 138px;
    }
</style>
<section class="cash-back-slider-sect">
    <div class="container">
       
            <?php $this->load->view('frontend/layout/partials/category'); ?>


            <!-- Slider -->
            <div class="col-md-8 slider-section col-sm-8">
                <?php if (!empty($sliders)) { ?>

                    <div class="slider-cover cash-back-slider">
                        <div class="slider single-item test">
                            <?php foreach ($sliders as $slide) { ?>
                                <div class="slide">
                                    <a target="_blank" href="<?php echo base_url() .$slide['url']; ?>"><img
                                            src="<?php echo $themeUrl ?>/images/banner/<?php echo $slide['image'] ?>"></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php /* ?><div class="cash-back-banner">
                    <?php
                    if (is_array($banner)) {
                        ?>
                        <div class="<?php if (isset($this->session->userdata('front_data')['id'])) {  echo 'vertical-slider'; }else{ echo 'vertical-slider'; }//'wol-cash'; } ?>">
                            <!-- Carousel items -->
                            <ul>
                                <?php $i =0;
                                foreach ($banner as $singleBanner => $bannerElements) {
                                    ?>
                                    <li>
                                        <a target="_blank" href="<?php echo base_url($bannerElements['banner_ads_redirect_url']); ?>">
                                            <img src="<?php echo $themeUrl . "/images/banner/" . $bannerElements['banner_ads_image']; ?>" alt="<?php echo $bannerElements['banner_ads_title']; ?>" />
                                        </a>
                                    </li>
                                    <?php
                               $i++; }
                                ?>
                            </ul>

                        </div>
                        <?php
                    }
                    ?>

                </div> <?php */ ?>
            </div>
            <div class="col-md-2 karmora-right-bnn col-sm-2">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
            <style type="text/css">
          /*      .no-anim {
                    display: none;
                }
                .do-anim {
                    display: inline-block;
                }*/
            </style>
         <!--    <script type="text/javascript">
             jQuery(window).load(function () {
                 $('.right-banner .small-right-banners').removeClass('no-anim');
                 $('.right-banner .small-right-banners').addClass('do-anim');
                 $('.right-banner .small-right-banners').addClass('animated');
                 $('.right-banner .small-right-banners').addClass('slideInRight');
             });
             jQuery(document).ready(function(){
                 $('.deal-close-btn').click(function(){
                     $('.right-banner .small-right-banners').removeClass('slideInRight');
                     $('.right-banner .small-right-banners').addClass('fadeOut');
                     
                 });
             });
         </script> -->


                <div class="right-banner kcb-right-banner">

                    <ul class="small-right-banners" id="list_data_ajax">
                    <?php if(!empty($tripplekarmorastore)){ $count = 0; ?>
                        <?php foreach ($tripplekarmorastore as $t){ $count ++;
                            if ( $count<=5 ) { 

                            if ( $count == 1 ) {
                                $delay = 'data-wow-delay="1s"';
                            } elseif ( $count == 2 ) {
                                $delay = 'data-wow-delay="1.5s"';
                            } elseif ( $count == 3 ) {
                                $delay = 'data-wow-delay="2s"';
                            } elseif ( $count == 4 ) {
                                $delay = 'data-wow-delay="2.5s"';
                            } elseif ( $count == 5 ) {
                                $delay = 'data-wow-delay="4s"';
                            } else {
                                $delay = '';
                            }

                            ?>
                            <li id="hide_id_<?php echo $t['store_id']; ?>" class="fadeInRight wow" <?php echo $delay; ?>>
                                <?php 
                                    if ($this->session->userdata('front_data')) {
                                    $link = base_url().'/store-visit/'.$t['store_id'];
                                    }else{
                                    $link = base_url().'/store-detail/'.$t['store_id'];
                                    }
                                ?>
                                <a href="<?php echo $link; ?>">
                                    <img src="<?php echo $themeUrl ?>/images/<?php echo $t['triple_karmora_kash_image']; ?>">
                                </a>
                                <a href="javascript:void(0)" onclick="shownext('<?php echo $t['store_id']; ?>')" class="banner-close-btn"> <i class="fa fa-times"></i> </a>
                            </li>
                            <?php }} } ?>
                    </ul>

                <?php /*
                    <?php if (!empty($sidebar)) { ?>
                                                        <!-- <a href="<?php //echo base_url().$link;         ?>"> -->
                        <a href="<?php echo base_url($sidebar->banner_ads_redirect_url) ?>">
                            <img src="<?php echo $themeUrl ?>/images/banner/<?php echo $sidebar->banner_ads_image; ?>" <?php if ($this->session->userdata['front_data']['user_account_type_id'] == 5) { echo 'class="cb-right-img"'; } ?> />
                        </a>
                    <?php } ?>

                    <?php
                    if (isset($this->session->userdata('front_data')['id']) && $this->session->userdata('front_data')['user_account_type_id'] == 5) {
                        
                    } else {


                        $url = 'https://www.youtube.com/watch?v=RLgKOs995Iw';
                        ?>
                        <div class="kcb-video-cover">
                            <!-- <iframe width="269" height="" src="https://www.youtube.com/embed/RLgKOs995Iw"
                                    frameborder="0"
                                    allowfullscreen></iframe> -->
                           <iframe width="269" height="" src="https://www.youtube.com/embed/tY5Zoz5iKuw" frameborder="0" allowfullscreen></iframe>

                            <div class="socialmediaicons cashback-socialmedia">
                                <ul class="inline">
                                    <li>
                                        <a  onClick="sharepost('Enter The Karmora Zone!', '<?php echo $url ?>')"
                                            target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl ?>/images/share-on-facebook.jpg">
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl ?>/images/tweeticons.png">
                                        </a>
                                    </li>
                                    <li>
                                        <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl ?>/images/pinit.png">
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    <?php } ?>

                    */ ?>
                </div>
            </div>

    
    </div>
</section>



<div class="clearfix"></div>
<!-- Karmora Specials -->
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function () {
        FB.init({
            appId: '786030961474411',
            status: true,
            xfbml: true,
            cookie: true
        });
    };
    /**
     * FaceBook Share function
     */
    function sharepost(name, url) {

        FB.ui({
            method: 'feed',
            name: name,
            link: url,
        }, function (response) {
        });
    }
</script>
<script>
    function shownext(store_id){
        $("#hide_id_"+store_id).hide();
        jQuery.ajax({
                url: baseurl+"karmora-cash-back/getajaxtripplestore/"+store_id,
                context: document.body,
                error: function(data, transport) { alert("Sorry, the operation is failed."); },
                success: function(data){
                        //alert(data);
                        console.info(data);
                        jQuery('#list_data_ajax').html(data);			
                }
            });
    }
</script>    