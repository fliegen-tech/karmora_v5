<section class="ads-page-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-ads-categories">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="<?php echo base_url() . 'share/making-money-ads'; ?>">
                                <div class="money-ofers">Making <br>Money Ads</div>
                            </a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url() . 'share/saving-money-ads'; ?>">
                                <div class="money-ofers">Saving <br>Money Ads</div>
                            </a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url() . 'share/winning-money-ads'; ?>">
                                <div class="money-ofers">Winning <br>Money Ads</div>
                            </a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url() . 'share/good-karmora-videos'; ?>">
                                <div class="money-ofers">Karmora <br>Videos</div>
                            </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="ads-desp">
                    <div class="top-heading-cover before-animated animated fadeInLeft" id="top-heading-cover">
                        <h1><?php echo $main_heading ?></h1>
                    </div>
                    <p>Love Our Exclusive Products? Tell the world regularly and watch in amazement as your Shopping
                        Community and income explodes! For more information on how, when, and where to post Good
                        KarmorAds™ to build your Shopping Community <a href="#">Click Here!</a></p>
                </div>
            </div>
        </div>
        <div class="ads-cover-img">
            <div class="row">
                <?php if ( ! empty( $custom_ads ) ) { ?>
                    <?php
                    $print_cat = array ();
                    foreach ( $custom_ads as $custom_ad ) {
                        ?>
                        <?php
                        if ( ! in_array( $custom_ad->banner_cat_id, $print_cat ) ) {
                            $print_cat[] = $custom_ad->banner_cat_id;
                            //echo "<div class='col-md-12 custom-heading'><h1>".$custom_ad->banner_cat_id."</h1></div>";
                        }
                        ?>
                        <div class="col-6">
                            <div class="leftbarads-cover">
                                <a href="<?php echo base_url( $custom_ad->banner_ads_redirect_url ) ?>">
                                    <img src="<?php echo $themeUrl; ?>/images/banner/<?php echo $custom_ad->banner_ads_image; ?>">
                                </a>
                                <div class="social-media-icon">
                                    <ul class="list-inline">
                                        <?php
                                        $title       = '' . $custom_ad->banner_ads_title;
                                        $caption     = $title;
                                        $url_p       = $custom_ad->banner_ads_redirect_url;
                                        $url         = base_url() . $url_p;
                                        $url2        = base_url() . 'track/' . str_replace( '/', '_', $url_p ) . '/product/' . $custom_ad->pk_banner_ads_id;
                                        $description = $custom_ad->banner_description;
                                        $picture     = $themeUrl . '/images/banner/' . $custom_ad->banner_ads_image;
                                        ?>
                                        <li class="list-inline-item"><?php if (!isset($this->session->userdata['front_data'])) { ?>
                                                <a href="<?php echo base_url('karmora-join-now') ?>">
                                                    <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                                </a>
                                            <?php } else { ?>
                                                <a onClick="sharepost('<?php echo $caption ?>', '<?php echo $url ?>', '<?php echo $picture ?>', '<?php echo $description ?>')"
                                                   target="_parent" href="javascript: void(0)">
                                                    <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                                </a>
                                            <?php } ?></li>
                                        <li class="list-inline-item"><?php if (!isset($this->session->userdata['front_data'])) { ?>
                                                <a href="<?php echo base_url('karmora-join-now') ?>">
                                                    <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                                </a>
                                            <?php } else { ?>
                                            <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                               target="_parent" href="javascript: void(0)">
                                                <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                            </a>
                                            <?php } ?></a>
                                        </li>
                                        <li class="list-inline-item"><?php if (!isset($this->session->userdata['front_data'])) { ?>
                                                <a href="<?php echo base_url('karmora-join-now') ?>">
                                                    <img src="<?php echo $themeUrl; ?>/frontend/images/tweeticons.png">
                                                </a>
                                            <?php } else { ?>
                                                <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                                   target="_parent" href="javascript: void(0)">
                                                    <img src="<?php echo $themeUrl; ?>/frontend/images/tweeticons.png">
                                                </a>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>