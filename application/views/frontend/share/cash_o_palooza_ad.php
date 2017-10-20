<section class="karmora-share-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12 karmora-share-content text-center">
                <h1 class="main-heading">Cash-o-Palooza Ads</h1>

                <div class="col-md-10 col-md-offset-1"><?php echo $description; ?></div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<div class="col-md-12 extra-links-share">
    <div class="text-center gk-1 gk-right">
        <a href="<?php echo base_url('share/good-karmora-emails')?>" class="gk-icon"><i class="fa fa-envelope"></i></a>
        <div class="gk-right-title gk-title">Good Karmora Emails</div>
    </div>
    <div class="text-center gk-2 gk-right">
        <a href="<?php echo base_url('share/good-karmora-videos');?>" class="gk-icon"><i class="fa fa-camera"></i></a>
        <div class="gk-right-title gk-title">Good Karmora Vidoes</div>
    </div>
    <div class="text-center gk-1 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/cash-back-ads')?>" class="gk-icon">
        <i class="flaticon-road-ad"></i> 
        <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"> -->
        </a>
        <a href="<?php echo base_url('share/good-karmora-ads/cash-back-ads')?>" class="gk-right-title gk-title">Cash Back Ads</a>
    </div>
    <div class="text-center gk-3 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-icon">
        <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"> -->
        <i class="flaticon-road-ad"></i> 
        </a>
        <a href="<?php echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-right-title gk-title">Smokin Hot Deals Ads</a>
    </div>
    <div class="text-center gk-4 gk-right">
        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-icon">
        <!-- <img src="<?php //echo $themeUrl; ?>/images/ads.png"> -->
        <i class="flaticon-road-ad"></i> 
        </a>
        <a href="<?php echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-right-title gk-title">Custom Ads</a>
    </div>

</div>
<div class="clearfix"></div>
<section class="cashpalooza-sec pt0">
    <div class="container">
        <div class="cop-deals row">
            <?php if (!empty($deals)) { ?>
                <?php foreach($deals as $deal){?>
                <div class="col-md-3 cop-d">


                    <img src="<?php echo base_url('share/cash-o-palooza-ad/'.$deal['store_id'])?>" alt="as"/>

                    <div class="socialmediaicons">
                        <ul class="inline">
                            <li>
                                <?php
                                $title = 'Special Deals - ' . $deal['store_title'];
                                $caption = $title;

                                $url_p = base_url('store-detail/' . $deal['store_id']);
                                $url = $url_p;
                                $description = 'Karmora Cash-O-Palooza Deals are special cash back deals on name brand advertisers.  You won’t find higher cash back anytime, anywhere, ever!  Join Karmora for FREE and get cash back on over 1,700 stores!';
                                $picture = base_url('share/cash-o-palooza-ad/'.$deal['store_id']) ;
                                ?>
                                <a onClick="sharepost('<?php echo $caption?>','<?php echo $url?>','<?php echo $picture?>','<?php echo $description?>')" target="_parent" href="javascript: void(0)">
                                    <img src="<?php echo $themeUrl;?>/images/share-on-facebook.jpg">
                                </a>
                            </li>

                            <li>
                                <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $picture; ?>&description=<?php echo $caption; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <img src="<?php echo $themeUrl;?>/images/pinit.png">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php }?>
            <?php }else{
                echo "No Record Found!";
            } ?>
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
    <div class="text-center gk-1 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/cash-back-ads')?>" class="gk-icon">
        <i class="flaticon-road-ad"></i> 
        <img src="<?php //echo $themeUrl; ?>/images/ads.png">
        </a>
        <a href="<?php //echo base_url('share/good-karmora-ads/cash-back-ads')?>" class="gk-right-title gk-title">Cash Back Ads</a>
    </div>
    <div class="text-center gk-3 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-icon">
        <img src="<?php //echo $themeUrl; ?>/images/ads.png">
        <i class="flaticon-road-ad"></i> 
        </a>
        <a href="<?php //echo base_url('share/good-karmora-ads/smokin-hot-deal-ads');?>" class="gk-right-title gk-title">Smokin Hot Deals Ads</a>
    </div>
    <div class="text-center gk-4 gk-right">
        <a href="<?php //echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-icon">
        <img src="<?php //echo $themeUrl; ?>/images/ads.png">
        <i class="flaticon-road-ad"></i> 
        </a>
        <a href="<?php //echo base_url('share/good-karmora-ads/custom-ads');?>" class="gk-right-title gk-title">Custom Ads</a>
    </div>

</section> -->
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function() {
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
    function sharepost(name,url,img,des) {

        FB.ui({
            method: 'feed',
            name: name,
            link: url,
            picture: img,
            description: des,
        }, function(response){});
    }
</script>