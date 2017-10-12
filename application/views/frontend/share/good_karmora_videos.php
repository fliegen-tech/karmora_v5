
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
                        <h1>Karmora Videos!</h1>
                    </div>
                    <p>Media rich content is what gets shared most often on social media. The below are carefully crafted viral formatted videos that you can use to help build the largest, most profitable Shopping Community possible! For step-by-step instructions on how, when and where to post our videos <a href="">Click Here!</a></p>
                </div>
            </div>
        </div>
        <?php if (!empty($videos)) { ?>
        <div class="ads-cover-img">
            <div class="row">
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
                                    <a onClick="sharepost('<?php echo $caption ?>','<?php echo $url ?>','<?php echo $picture ?>','<?php echo $description ?>')"
                                       target="_parent" href="javascript: void(0)">
                                        <img src="<?php echo $themeUrl; ?>/frontend/images/share-on-facebook.jpg">
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><img src="<?php echo $themeUrl; ?>/frontend/images/pinit.png" alt="Facebook"></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><img src="<?php echo $themeUrl; ?>/frontend/images/tweeticons.png" alt="Facebook"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
    <!--====  End of Make money Ads ====-->
<div id="fb-root"></div>
<?php $this->load->view('frontend/share/share_js'); ?>