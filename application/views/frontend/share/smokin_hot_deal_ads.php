<section class="karmora-share-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12 karmora-share-content text-center">
                <h1 class="main-heading">Smokin Hot Deal Ads</h1>
                <span class="line-spc"></span>
                <div class="col-md-10 col-md-offset-1">
                    <?php // echo $description; ?>
                    <?php if (!isset($this->session->userdata['front_data']['id'])) {  ?>
                    <p>Share these Smokin Hot Deals daily on Social Media and watch your Shopping Community grow! &nbsp;  Our <a class="under-line-text" href="<?php echo base_url().'join-today'; ?>">Premier Shoppers</a> are building massive Shopping Communities and are earning HUGE commissions!</p>
                    <?php }else if ($this->session->userdata['front_data']['user_account_type_id'] != 5){?>
                        <p>Share these Smokin Hot Deals daily on Social Media and watch your Shopping Community grow!  Our Premier Shoppers are building massive Shopping Communities and are earning HUGE commissions!</p>
                    <?php  } else if ($this->session->userdata['front_data']['user_account_type_id'] == 5){?>
                        <p>Share these Smokin Hot Deals daily on Social Media and watch your Shopping Community grow!  Our <a class="under-line-text" href="<?php echo base_url().'join-today'; ?>">Premier Shoppers</a> are building massive Shopping Communities and are earning HUGE commissions!</p>
                    <?php  } ?> 
                </div>
                <div class="clearfix"></div>
                <span class="line-spc custom-we768"></span><span class="line-spc custom-we768"></span>
            </div>
        </div>
</section>
<div class="col-md-12 extra-links-share">

    <span class="line-spc "></span> 
    <div class="clearfix"></div>
    <div class="text-center gk-6 gk-right">
        <a href="<?php echo base_url('share/good-karmora-emails') ?>" class="gk-icon"><i class="fa fa-envelope"></i></a>

        <div class="gk-right-title gk-title">Good Karmora Emails</div>
    </div>
    <div class="text-center gk-7 gk-right">
        <a href="<?php echo base_url('share/good-karmora-videos'); ?>" class="gk-icon"><i class="fa fa-camera"></i></a>

        <div class="gk-right-title gk-title">Good Karmora Vidoes</div>
    </div>
    <div class="text-center gk-1 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/cash-back-ads') ?>" class="gk-icon">
            <i class="flaticon-road-ad"></i>
            <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"></a> -->
            <a href="<?php echo base_url('share/good-karmora-ads/cash-back-ads') ?>" class="gk-right-title gk-title">Cash
                Back Ads</a>
    </div>
    <div class="text-center gk-2 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/cash-o-palooza-ads') ?>" class="gk-icon">
            <i class="flaticon-road-ad"></i>
            <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"></a> -->
            <a href="<?php echo base_url('share/good-karmora-ads/cash-o-palooza-ads') ?>"
               class="gk-right-title gk-title">Cash-O-Palooza Ads</a>
    </div>
    <div class="text-center gk-4 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>" class="gk-icon">
            <i class="flaticon-road-ad"></i>
            <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"></a> -->
            <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>" class="gk-right-title gk-title">Custom
                Ads</a>
    </div>
    <div class="text-center gk-5 gk-right">
        <a href="<?php echo base_url('share/triple-karmora-kash-add'); ?>" class="gk-icon">
            <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"> -->
            <i class="flaticon-road-ad"></i>
        </a>
        <a href="<?php echo base_url('share/triple-karmora-kash-add'); ?>" class="gk-right-title gk-title">Triple Karmora Kash</a>
    </div>
    <div class="clearfix"></div>
    <span class="line-spc custom-we768"></span> 
    
</div>
<div class="clearfix"></div>
<span class="line-spc"></span><span class="line-spc custom-we768"></span>
<section class="cashpalooza-sec pt0">
    <div class="container">
        <div class="row">
            <div class="cop-deals">
                <?php if (!empty($deals)) { ?>
                    <!-- Deal Start -->
                    <?php foreach ($deals as $deal) { ?>
                        <div class="col-md-3 col-sm-4 col-xs-6 cop-d cop-m-resp">


                            <!--<img src="<?php /*echo base_url('share/smokin-hot-deal-ad/' . $deal['store_id']) */?>"
                                 alt="as"/>-->
                            <img src="<?php echo $this->themeUrl.'/images/'.$deal['store_not_login_banner']; ?>"
                                 alt="as"/>
                            <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                <div class="socialmediaicons custom-ads-social">
                            <ul class="inline">
                                <li>
                                    <?php
                                    $title = 'Special Offer - ' . $custom_ad->banner_ads_title;
                                    $caption = $title;

                                    $url_p = $custom_ad->banner_ads_redirect_url;
                                    $url = base_url().$url_p;
                                    $description = $custom_ad->banner_description;
                                    $picture = $themeUrl . '/images/banner/' . $custom_ad->banner_ads_image;
                                    ?>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('login') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="sharepost('<?php echo $caption ?>','<?php echo $url ?>','<?php echo $picture ?>','<?php echo $description ?>')"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('login') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/pinit.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/pinit.png">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('login') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/tweeticons.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/tweeticons.png">
                                        </a>
                                    <?php } ?>
                                </li>
                                
                            </ul>
                        </div>
                                <span class="line-spc"></span>
                            <?php } else { ?>
                                <div class="socialmediaicons">
                                    <ul class="inline">
                                        <li>
                                            <?php
                                            $title = 'KARMORA SMOKIN HOT DEAL!';
                                            $caption = $title;

                                            $url_p = base_url('store-detail/' . $deal['store_id']);
                                            $url = $url_p;
                                            $description = 'Karmora Smokin Hot Deals combine top Cash Back with great deals offered by '. $deal['store_title'].' and many of our over 2,000 name brand stores.  Click on the ad to view all of our Smokin Hot Deals!  It’s FREE to join and who doesn’t like saving money, making money, winning money and having fun?';
                                            //$picture = base_url('share/smokin-hot-deal-ad/' . $deal['store_id']);
                                            $picture = $this->themeUrl.'/images/'.$deal['store_not_login_banner'];
                                            ?>
                                            <a onClick="sharepost('<?php echo $caption ?>','<?php echo $url ?>','<?php echo $picture ?>','<?php echo $description ?>')"
                                               target="_parent" href="javascript: void(0)">
                                                <img src="<?php echo $themeUrl; ?>/images/share-on-facebook.jpg">
                                            </a>
                                        </li>
                                        <li>
                                            <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                               target="_parent" href="javascript: void(0)">
                                                <img src="<?php echo $themeUrl; ?>/images/pinit.png">
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                               target="_parent" href="javascript: void(0)">
                                                <img src="<?php echo $themeUrl; ?>/images/tweeticons.png">
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <span class="line-spc"></span>
                            <?php } ?>
                        </div>
                    <?php }
                } else {
                    echo 'No Record found!';
                } ?>
            </div>
        </div>
    </div>
</section>

<div id="fb-root"></div>
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
            appId: '1455287054704424',
            status: true,
            xfbml: true,
            cookie: true
        });
    };
    /**
     * FaceBook Share function
     */
    function sharepost(name, url, img, des) {

        FB.ui({
            method: 'feed',
            name: name,
            link: url,
            picture: img,
            description: des,
        }, function (response) {
        });
    }
</script>