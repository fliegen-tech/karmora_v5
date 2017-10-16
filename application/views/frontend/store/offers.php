<style>

#hd-header{ background:#015781;}
#border-box{ border: solid 5px #015781;; margin-top: 3px;}
/*#deals{ margin-bottom:50px;}*/
/*#deal-item{}*/
#hd-header{padding: 0px; border-bottom: solid 5px #015781;}
.hot-list{ padding-left:60px; background:url(<?php //echo $themeUrl?>/images/mix/hot-note.png) no-repeat left top; min-height:50px; margin:40px 0px;}

</style>

<?php 
    if(isset($alias) && $alias == 'cash_o_palooza') { ?>

        <style type="text/css">
            #border-box {
                border: 5px solid #EB0F00 !important;
            }
            #hd-header {
                border-bottom: 5px solid #EB0F00 !important;
            }
        </style>
    <?php } else { ?>
        <style type="text/css">
            #border-box {
                border: 5px solid #015781 !important;
            }
            #hd-header {
                border-bottom: 5px solid #015781 !important;
            }
        </style>
    <?php }
?>

<script>
var chk = '<?php echo $this->input->get('post_id',true)?>';
console.info(chk);
if(chk !== ''){
	self.close();
}
</script>
<div class="container">
<!-- <div class="layout-category-new-smoking"> -->
    <?php $this->load->view('frontend/layout/partials/category'); ?>
<!-- </div> -->
<div class="col-md-10 col-sm-12 col-xs-12 cash-plaooza-boxes"  <?php if(isset($alias) && $alias == 'cash_o_palooza'){ ?><?php } ?>>
<div id="border-box">
        <div id="hd-header" <?php if(isset($alias) && $alias == 'cash_o_palooza'){ ?> <?php } ?>>
            <img src="<?php echo $themeUrl?>/images/categories/<?php echo $category_detail['category_image']?>" class="img-responsive col-centered" />
            <div class="row ">

            </div>
        </div>
        <span class="line-spc"></span>
        <div class="clearfix"></div>

    <?php if($category_detail['category_description'] !== ''){ ?>
    <div class="row">
        <div class="col-md-12 col-centered">
            <p >
                <?php echo $category_detail['category_description'];?>
            </p>
            <br/><br/>

        </div>

    </div>
    <?php } ?>
    <div id="deals">
        <?php
        $count = 1;
        foreach($deals as $deal) {
        $urlredirect = base_url().'trending-store/'.$deal['store_id'];
        $urlImage = $themeUrl.'/images/'.$deal['store_image'];
        $title = urlencode('Special Deals - ' . $deal['store_title']);
        $url = urlencode($urlredirect);
        $summary = urlencode('Trending on Karmora - ' . $deal['store_title']);
        $image = urlencode($urlImage);
               ?>
        <div class="col-md-3 col-sm-4 col-xs-6" id="deal-item"> 
            <?php if ($this->session->userdata('front_data')) {  ?>
                <a href="<?php echo base_url('store-visit/'.$deal['store_id']) ?>" target="_blank">
            <?php }else{ ?>
                 <a href="<?php echo base_url('store-detail/'.$deal['store_id']) ?>" target="_blank">
            <?php } ?>        
                <?php
                    if (!$this->session->userdata('front_data')) { 
                         $loadimage = $deal['store_not_login_banner']; 
                    }else{
                         $loadimage = $deal['store_image'];
                    }
                ?>
                <img src="<?php echo $themeUrl?>/images/<?php echo $loadimage;?>"  class="img-responsive"/>
            </a>
            <?php if(isset($alias) && $alias == 'cash_o_palooza'){ ?>
               <?php /*?> <div class="btn-cash-click-new">
                    <a class="btn-click-hare-cah btn-click-deals-new"><img src="<?php echo $themeUrl.'/images/click-here-btn.png' ?> "></a>
                </div><?php */ ?>
                <?php }?>
                <span class="line-spc"></span>
            <div class="socialmediaicons">
                            <?php
                            $r_url = base_url('special-offer/'.$this->uri->segment(2));
                            $r_url = urlencode($r_url);
                            $url_p = base_url('store-detail/'.$deal['store_id']);
                            $url = urlencode($url_p);
                            $caption = $title;
                            $store = $this->uri->segment(2);
                            if($store === 'smokin_hot_deals'){
                                $description = urlencode('Karmora Smokin Hot Deals make ya jump back and want to kiss yoself!  Check out these great deals combined with special online coupons for extra savings!  Join Karmora for FREE and get cash back on over 1,700 stores!');
                                $img = $themeUrl.'/images/'.$deal['store_fb_image'];
                            }else if ($store === 'cash_o_palooza'){
                                $description = urlencode('Karmora Cash-O-Palooza Deals are special cash back deals on name brand advertisers.  You won’t find higher cash back anytime, anywhere, ever!  Join Karmora for FREE and get cash back on over 1,700 stores!');
                            $img = $themeUrl.'/images/'.$deal['store_image'];
                                
                            }
                            $picture = urlencode($img);
                            $fb ='https://www.facebook.com/dialog/feed?app_id=1455287054704424&display=popup&name='.$caption.'&caption=&link='.$url.'&redirect_uri='.$r_url.'&description='.$description.'&picture='.$picture;
                            ?>
                            
                            <?php if (!$this->session->userdata('front_data')) { ?>
                                <a href="<?php echo base_url().'karmora-join-now'; ?>" >Join Today</a>
                            <?php }/*else{*/ ?>
                               <!-- <a onClick="window.open('<?php /*echo $fb; */?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <img class="imgSocialIcon" src="<?php /*echo $themeUrl.'/images/share-on-facebook.jpg';*/?>" alt="share on facebook">
                                </a>

                                <a onClick="window.open('https://twitter.com/intent/tweet?url=<?php /*echo $urlredirect; */?>&hashtags=TrendingOnKarmora&text=<?php /*echo $title; */?>&via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <img class="imgSocialIcon" alt="tweet" src="<?php /*echo $themeUrl.'/images/tweeticons.png';*/?>">
                                </a>

                                <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php /*echo $urlredirect; */?>&media=<?php /*echo $image; */?>&description=<?php /*echo $title; */?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <img class="imgSocialIcon" alt="Pin it" src="<?php /*echo $themeUrl.'/images/pinit_fg_en_rect_gray_20.png';*/?>">
                                </a>-->
                            <?php /*}*/ ?>
            </div>
        </div>
        <?php
        if($count % 4 === 0 && $count !== 1) {
            ?>
    </div><div id="deals">
        <?php
        }
        $count++;
            }
        ?>
        
    </div>

    <div class="clearfix"></div>
    </div>
    </div>
    </div>