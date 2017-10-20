<section class="ads-page-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-ads-categories">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/saving-money-ads'; ?>"><div class="money-ofers">Saving <br>Money Ads </div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/winning-money-ads'; ?>"><div class="money-ofers">Winning <br>Money Ads </div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/exclusive-product-ads'; ?>"><div class="money-ofers">Exclusive <br>Product Ads </div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/good-karmora-videos'; ?>"><div class="money-ofers">Karmora  <br>Videos</div></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="ads-desp">
                    <div class="top-heading-cover before-animated" id="top-heading-cover">
                        <h1>Saving Money Ads!</h1>
                    </div>
                    <p>Over 200 Million US Consumers will spend More than $300 Billion shopping online and some of them are your friends and followers!   Snap ‘em up into your Shopping Community before someone else does! For more information on how, when, and where to post Good KarmorAds™ to build your Shopping Community <a href="">Click Here!</a></p>
                </div>
            </div>
        </div>
        <?php if (!empty($custom_ads)) { ?>
        <div class="ads-cover-img">
            <div class="row">
                <?php foreach ($custom_ads as $custom_ad) { ?>
                <div class="col-6">
                    <div class="leftbarads-cover">
                        <a href="<?php echo base_url($custom_ad->banner_ads_redirect_url);?>">
                            <img src="<?php echo $themeUrl; ?>/images/banner/<?php echo $custom_ad->banner_ads_image; ?>" />
                        </a>
                        <div class="social-media-icon">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <?php
                                    $title = addslashes('EARN UP TO 30% CASH BACK!');
                                    $caption = $title;
                                    $url_p = $custom_ad->banner_ads_redirect_url;
                                    $url = base_url() .$url_p.'/banner--'.$custom_ad->banner_ads_image;
                                    $url2= base_url() . 'track/'.$url_p.'/banner/'.$custom_ad->pk_banner_ads_id;
                                    $description = addslashes('Earn up to 30% Cash Back at over 2,000 Name Brand Stores at Karmora.com!  Karmora offers much more than just Cash Back for our Shoppers. Click the Ad to learn more about the next generation of online shopping at Karmora.com!');
                                    $picture = $themeUrl . '/images/banner/' . $custom_ad->banner_ads_image;
                                    ?>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('premier-shopper-signup') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="sharepost('<?php echo $caption ?>', '<?php echo $url2 ?>', '<?php echo $picture ?>', '<?php echo $description ?>')"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li class="list-inline-item">
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('premier-shopper-signup') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url2; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li class="list-inline-item">
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('premier-shopper-signup') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend//images/tweeticons.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url2; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend//images/tweeticons.png">
                                        </a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section
    <!--====  End of Make money Ads ====-->
<div id="fb-root"></div>
<?php $this->load->view('frontend/share/share_js'); ?>