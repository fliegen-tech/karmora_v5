

<script>

/// code for close fb share popup don't remove this code thanks NR
var chk = '<?php echo $this->input->get('post_id',true)?>';

if(chk !== ''){
	self.close();
}
</script>
<div class="container"> </div>

    
    <div class="container ">
        <div style="margin-bottom:20px;" class="row row-offset-control">
        <div id="tranding-nav">
        <?php $this->load->view('frontend/layout/partials/category');?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10" id="tranding-box">
    
        <div class="col-md-12" id="hd-header"> <img src="<?php echo $themeUrl?>/images/categories/<?php echo $category_detail['category_image']?>" class="img-responsive col-centered" />
            <div class="row "> </div>
        </div>   
    
        <div class="col-md-11 col-centered">
            <p>
                <?php /*?><?php echo $category_detail['category_description'];?><?php */?>
                
                <span class="tranding-text">
                    <?php echo $category_detail['category_description'];?>
                </span>
                
            </p>
        </div>
          <div class="clearfix"></div>
                  <br /><br />
    
    <div class="col-md-12" id="deals" style="margin-top:-9px;">
        
        <?php
        $count = 1;
            foreach($TrendingStore as $deal) {
                $urlredirect = base_url().'trending-store/'.$deal['store_id'];
        $urlImage = $themeUrl.'/images/'.$deal['store_image'];
        $title = urlencode('Trending On Karmora - ' . $deal['store_title']);
        $url = urlencode($urlredirect);
        $summary = urlencode('Trending on Karmora - ' . $deal['store_title']);
        $image = urlencode($urlImage);
               ?>
        <div class="col-md-4 col-sm-4 col-xs-6" id="deal-item"> 
            <a href="<?php echo base_url('store-detail/'.$deal['store_id']) ?>" target="_blank">
                <img src="<?php echo $themeUrl?>/images/<?php echo $deal['store_image'];?>"  class="img-responsive"/>
            </a>
            <div class="socialmediaicons tranding" style="text-align:center;">
                
                            <?php 
                            $r_url = base_url('trending-stores/'.$alias);
                            $r_url = urlencode($r_url);
                            $url_p = base_url('store-detail/'.$deal['store_id']);
                            $url = urlencode($url_p);
                            $caption = $title;
                            $description = $description;
                            $img = $themeUrl.'/images/'.$deal['store_image'];
                            $picture = urlencode($img);
                            
                            $fb ='https://www.facebook.com/dialog/feed?app_id=1455287054704424&display=popup&name='.$caption.'&caption='.$caption.'&link='.$url.'&redirect_uri='.$r_url.'&description='.$description.'&picture='.$picture;
                            ?>
                            
                            <a href="javascript: void(0)" onclick="window.open('<?php echo $fb; ?>','Sharer','toolbar=0,status=0,width=548,height=325');" target="_parent">
                                <img class="imgSocialIcon fb" src="<?php echo $themeUrl.'/images/share-on-facebook.jpg';?>" alt="share on facebook">
                            </a>
                            <!--/*CHANGE START HERE SYED TAUSIF 03-18-2014*/-->

                            <a onClick="window.open('https://twitter.com/intent/tweet?url=<?php echo $urlredirect; ?>&hashtags=TrendingOnKarmora&text=<?php echo $title; ?>&via=Shopkarmora', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                <img class="imgSocialIcon tw" alt="tweet" src="<?php echo $themeUrl.'/images/tweeticons.png';?>">
                            </a>

                            <a onClick="window.open('http://www.pinterest.com/pin/create/button/?url=<?php echo $urlredirect; ?>&media=<?php echo $image; ?>&description=<?php echo $title; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                <img class="imgSocialIcon pin" alt="Pin it" src="<?php echo $themeUrl.'/images/pinit_fg_en_rect_gray_20.png';?>">
                            </a> 
                            <!-- Please call pinit.js only once per page --></div>
        </div>
        <?php
        if($count % 3 === 0 && $count !== 1) {
            ?>
    </div><div class="col-md-12" id="deals" style="margin-top: 25px;" >
        <?php
        }
        $count++;
            }
        ?>
        
    </div>
    <!-- four-boxes --></div>
    </div>
    </div>
