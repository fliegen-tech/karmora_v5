
<section class="ads-page-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-ads-categories">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/making-money-ads'; ?>"><div class="money-ofers">Making  <br>Money Ads</div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/saving-money-ads'; ?>"><div class="money-ofers">Saving <br>Money Ads </div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/winning-money-ads'; ?>"><div class="money-ofers">Winning <br>Money Ads </div></a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url().'share/exclusive-product-ads'; ?>"><div class="money-ofers">Exclusive <br>Product Ads </div></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="ads-desp">
                    <div class="top-heading-cover before-animated" id="top-heading-cover">
                        <h1>Karmora Videos!</h1>
                    </div>
                    <p>Media Rich content is what gets shared most often on social media. The below are carefully crafted viral formatted videos that you can use to help build the largest, most profitable Shopping Community possible! For step-by-step instructions on how, when and where to post our videos <a href="">Click Here!</a></p>
                </div>
            </div>
        </div>
        <?php if (!empty($videos)) { ?>
        <div class="ads-cover-img">
            <div class="row">
                <?php foreach ($videos as $vidVal){?>
                <div class="col-4">
                    <div class="leftbarads-cover">
                        <iframe src="<?php echo $vidVal['video_url']; ?>" frameborder="0" allowfullscreen=""></iframe>
                        <div class="social-media-icon">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <?php
                                    $title = $vidVal['video_title'];
                                    $caption = $title;

                                    $url_p = $vidVal['video_url'];
                                    $url = $url_p.'/'.$vidVal['pk_video_id'];
                                    $description = 'Karmora Cash-O-Palooza Deals are special cash back deals on name brand advertisers.  You won’t find higher cash back anytime, anywhere, ever!  Join Karmora for FREE and get cash back on over 1,700 stores!';
                                    $picture = $themeUrl . '/images/video_cover_image/' . $vidVal['video_cover_photo'];
                                    ?>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('join-today') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="sharepost('<?php echo $caption ?>','<?php echo $url ?>','<?php echo $picture ?>','<?php echo $description ?>')"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } ?>

                                </li>
                                <li class="list-inline-item">
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('join-today') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li class="list-inline-item">
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('join-today') ?>">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/tweeticons.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo urlencode($caption); ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/frontend/images/tweeticons.png">
                                        </a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
    <!--====  End of Make money Ads ====-->
<div id="fb-root"></div>
<?php $this->load->view('frontend/share/share_js'); ?>