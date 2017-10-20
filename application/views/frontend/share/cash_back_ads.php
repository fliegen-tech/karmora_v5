<section class="karmora-store-detail">
    <div class="container">
        <div class="row">

            <?php $this->load->view('frontend/layout/partials/category'); ?>


            <div class="col-md-10 table-responsive">
                <div class="col-md-12 extra-links-share">
                 <span class="line-spc"></span>       
            <div class="clearfix"></div>
                    <div class="text-center gk-6 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-emails') ?>" class="gk-icon"><i
                                class="fa fa-envelope"></i></a>

                        <div class="gk-right-title gk-title" style="padding: 5px 0;">Good Karmora Emails</div>
                    </div>
                    <div class="text-center gk-7 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-videos'); ?>" class="gk-icon"><i
                                class="fa fa-camera"></i></a>

                        <div class="gk-right-title gk-title" style="padding: 5px 0;">Good Karmora Vidoes</div>

                    </div>
                    <div class="text-center gk-2 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-ads/cash-o-palooza-ads') ?>" class="gk-icon">
                            <i class="flaticon-road-ad"></i>
                            <a href="<?php echo base_url('share/good-karmora-ads/cash-o-palooza-ads') ?>"
                               class="gk-right-title gk-title" style="padding: 5px 0;">Cash-o-Palooza Ads</a>
                    </div>
                    <div class="text-center gk-3 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-ads/smokin-hot-deal-ads'); ?>" class="gk-icon">
                            <i class="flaticon-road-ad"></i>
                            <a href="<?php echo base_url('share/good-karmora-ads/smokin-hot-deal-ads'); ?>"
                               class="gk-right-title gk-title" style="padding: 5px 0;">Smokin Hot Deals Ads</a>
                    </div>
                    <div class="text-center gk-4 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>" class="gk-icon">
                            <i class="flaticon-road-ad"></i>
                            <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>"
                               class="gk-right-title gk-title" style="padding: 5px 0;">Custom Ads</a>
                    </div>
                    <div class="text-center gk-5 gk-right" style="width: 146px;">
                        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>" class="gk-icon">
                        <i class="flaticon-road-ad"></i>
                        <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"></a> -->
                        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads'); ?>" class="gk-right-title gk-title" style="padding: 5px 0;">Triple Karmora Kash</a>
                     </div>
                    <div class="clearfix"></div>
                <span class="line-spc"></span>  
                </div>
                <div class="clearfix"></div>
                <span class="line-spc"></span><span class="line-spc"></span>
                <h1 class=" text-left" style="margin: 0px;">Share Cash Back Ads</h1>
                <span class="line-spc"></span>
                <div>Consistently share different Cash Back Ads up to 3 times a day and
                    watch how they will drive traffic to your website and grow your Shopping Community! &nbsp; You can share a
                    different Cash Back Ad every day for 5 years and never place the same ad twice! &nbsp; It will only take 5
                    minutes of your time each day and is the most dynamic direct sales social media marketing campaign
                    ever created!
                </div>
                <span class="line-spc"></span>
            <div class="table-responsive">
                <table class="table table-responsive table-striped " id="hunt-table">
                    <thead>
                    <tr>
                        <th>Store Name</th>
                        <th>Cash Back</th>
                        <th>Favorites</th>
                        <th>Shop</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="store-table">
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <a href="#" name="top"></a>
                            <?php
                            $first = true;
                            foreach ($storeArray as $nouseVars) {
                                if ($first) {
                                    reset($storeArray);
                                    $first = false;
                                }
                                ?>
                                <a href="#<?php echo key($storeArray); ?>"><?php echo key($storeArray); ?></a>
                                <?php

                                next($storeArray);
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                    $first = true;
                    foreach ($storeArray as $storeIn) {
                        if ($first) {
                            reset($storeArray);
                            $first = false;
                        }

                        ?>
                        <tr>
                            <td colspan="3" style=" background-color: #CC2161;" align="left"><a style="color: white; "
                                                                                                href="#"
                                                                                                name="<?php echo key($storeArray); ?>"><b><?php echo key($storeArray); ?></b></a>
                            </td>
                            <td style=" background-color: #CC2161;"></td>
                            <td style=" background-color: #CC2161; vertical-align: middle;"><a style="color: white; "
                                                                                               href="#top">Back to
                                    Top</a></td>

                        </tr>
                        <?php
                        foreach ($storeIn as $store) {
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url() ?>store-detail/<?php echo $store['store_id'] ?>"><?php echo $store['store_title']; ?></a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="pop-up-on-page"
                                       data-id="<?php echo $store['store_id'] ?>" data-toggle="modal"
                                       data-target="#cashback-share-ad-popup_<?php echo $store['store_id'] ?>"
                                       target="_blank">See Ad</a>

                                    <div class="modal fade"
                                         id="cashback-share-ad-popup_<?php echo $store['store_id'] ?>" tabindex="-1"
                                         role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content model-save-money" style="padding-bottom: 30px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close popup-close" data-dismiss="modal"
                                                            aria-label="Close"><i class="fa fa-times"></i></button>
                                                    <div class="karmora-logo-save-money">
                                                        <img src="<?php echo $themeUrl; ?>/images/karmora-logo.png">
                                                    </div>
                                                    <h4 class="modal-title karmora-save-title" id="myModalLabel">Karmora
                                                        Cash Back Ad</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- <h5 class="kamora-save-desp-a">Karmora Guarantees that our Premier Shoppers will earn the highest Cash Back available on the internet!The process is simple:</h5> -->
                                                    <p class="text-center">
                                                        <img
                                                            src="<?php echo base_url('share/karmora-ad-image/' . $store['store_id']); ?>"
                                                            alt="Karmora Cash Back Ad Title"/>
                                                    </p>


                                                    <!-- <div class="poprp-rating-btn">
                                                        <a href="#" class="btn btn-primary pop-btn"
                                                           data-dismiss="modal">Close Ad</a>
                                                    </div> -->

                                                    <!-- <ul class="ksm-list">
                                                      <li>The guarantee only applies to everyday cash back rates and not Special Offers.</li>
                                                      <li>The funds will be “available” during the normal Cash Back time frame explained in our <a href="#">Terms of Use</a> and <a href="#">Cash Back Disclosure Statement</a>.</li>
                                                    </ul> -->
                                                </div>
                                                <!-- <div class="modal-footer">
                                                  <div class="desc-top">
                                                    <a href="#" data-dismiss="modal">Close</a>
                                                  </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php

                                $title = 'It Pays to Share Good Karmora!';
                                $caption = $title;

                                $url_p = base_url('store-detail/' . $store['store_id']);
                                $url = $url_p;
                                $description = 'Up to 30% Cash Back at over 2,000 name brand stores!, Earn top commissions on 5 Floors of Shoppers!, Profit Sharing Program!, Win Cash & Prizes surfing stores on your website!, Up to $100 Karmora Kash Welcome Bonus!';
                                $picture = base_url('share/karmora-ad-image/' . $store['store_id']);
                                //https://www.facebook.com/dialog/feed?app_id=786030961474411&description=Karmora%20Smokin%20Hot%20Deals%20make%20ya%20jump%20back%20and%20want%20to%20kiss%20yourself!%20%20Check%20out%20these%20great%20deals%20combined%20with%20special%20online%20coupons%20for%20extra%20savings!%20%20Join%20Karmora%20for%20FREE%20and%20get%20cash%20back%20on%20over%201%2C700%20stores!&display=popup&e2e=%7B%7D&link=http%3A%2F%2Flocalhost%2Fkarmora%2Fstore-detail%2F42&locale=en_US&name=Special%20Deals%20-%20Seven%20Everyday%20Slings&next=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D42%23cb%3Dfb2bad82c688a8%26domain%3Dlocalhost%26origin%3Dhttp%253A%252F%252Flocalhost%252Ff2551112404e634%26relation%3Dopener%26frame%3Df591dcbaecd3f8%26result%3D%2522xxRESULTTOKENxx%2522&picture=http%3A%2F%2Flocalhost%2Fkarmora%2Fshare%2Fkarmora-ad-image%2F42&sdk=joey
                                ?>
                                <td>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('karmora-join-now') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="sharepost('<?php echo $caption ?>','<?php echo $url ?>','<?php echo $picture ?>','<?php echo $description ?>')"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-facebook.jpg">
                                        </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('karmora-join-now') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/tweeticons.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>&amp;hashtags=TrendingOnKarmora&amp;text=<?php echo $caption; ?>&amp;via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/tweeticons.png">
                                        </a>
                                    <?php } ?>

                                </td>
                                <td>
                                    <?php if (!isset($this->session->userdata['front_data'])) { ?>
                                        <a href="<?php echo base_url('karmora-join-now') ?>">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-pinterest.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                                           target="_parent" href="javascript: void(0)">
                                            <img src="<?php echo $themeUrl; ?>/images/share-on-pinterest.png">
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                        next($storeArray);
                    } ?>

                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="karmora-emails-sec-fixed">
    <div class="text-center gk-1 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-emails')?>" class="gk-icon"><i class="fa fa-envelope"></i></a>
        <div class="gk-right-title gk-title">Good Karmora Emails</div>
    </div>
    <div class="text-center gk-2 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-videos');?>" class="gk-icon"><i class="fa fa-camera"></i></a>
        <div class="gk-right-title gk-title">Good Karmora Vidoes</div>

    </div>
    <div class="text-center gk-2 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/cash-o-palooza-ads')?>" class="gk-icon">
        <i class="flaticon-road-ad"></i>  
        <a href="<?php //echo base_url('share/good-karmora-ads/cash-o-palooza-ads')?>" class="gk-right-title gk-title">Cash-o-Palooza Ads</a>
    </div>
    <div class="text-center gk-3 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-icon">
        <i class="flaticon-road-ad"></i>  
        <a href="<?php //echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-right-title gk-title">Smokin Hot Deals Ads</a>
    </div>
    <div class="text-center gk-4 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-icon">
        <i class="flaticon-road-ad"></i>  
        <a href="<?php //echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-right-title gk-title">Custom Ads</a>
    </div>

</section> -->

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

