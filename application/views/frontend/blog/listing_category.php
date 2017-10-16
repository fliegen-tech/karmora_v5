<section class="blog-header">
    <div class="container">
        <div class="row">
            <?php if(!empty($category)){ ?>
            <div class="col-md-12">
                <ul class="list-unstyled blog-header-list">
                    <li><a href="javascript:void(0)">Home</a></li>
                    <?php foreach ($category as $c){ ?>
                    <li><a href="<?php echo base_url().'blog/category-detail/'.$c['pk_category_id']; ?>"><?php echo $c['category_title']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="blog-section">
    <div class="container">
        <div class="row">
            <?php if(!empty($category)){ ?>
            <div class="row box-row-sep">

                <?php $i = 1; foreach ($category as $cat){ ?>
                    <div class="box col-md-4 col-sm-offset-1 col-sm-4 col-md-offset-<?php echo $i;?>">
                        <a href="<?php echo base_url().'blog/category-detail/'.$cat['pk_category_id']; ?>">
                            <img src="<?php echo $themeUrl ?>/images/categories/<?php echo $cat['category_image']; ?>" alt="" />
                            <h3><span><?php echo $cat['category_title']; ?></span></h3>
                        </a>
                    </div>
                <?php $i++; if($i == 3){ $i = 1; echo '</div><div class="row box-row-sep">';} ?>

                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <span class="blog-sep"></span>
        </div>
    </div>
</div>

<section class="recent-blog-posts">
    <div class="container">
        <div class="col-md-12 text-center">
            <h2>Most Recent Posts</h2>
        </div>

        <?php if(!empty($resent_blog)){ ?>
        <div class="col-md-12">

            <!-- Post Start -->
            <?php foreach($resent_blog as $re){
                if($re['categories'] !=''){?>
            <div class="blog-single-post text-center">
                <a href="<?php echo base_url().'blog/post-detail/'.$re['pk_post_id']; ?>"><img src="<?php echo $themeUrl.'/images/blog/'.$re['blog_image']; ?>" alt="<?php echo $re['post_title']; ?>"></a>
                <h3><a href="<?php echo base_url().'blog/post-detail/'.$re['pk_post_id']; ?>"><?php echo $re['post_title']; ?></a></h3>
                <a href="<?php echo base_url().'blog/post-detail/'.$re['pk_post_id']; ?>" class="blog-permalink">Read More</a>
            </div>
            <?php }} ?>
            <!-- Post End -->

        </div>
    <?php } ?>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <span class="blog-sep"></span>
        </div>
    </div>
</div>

<section class="after-blog-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-6 shop-exc-prod">
                <a href="<?php echo base_url().'karmora-cash-back' ?>">
                <div class="s-e-p-box">
                    <h3>Shop Our <br /> Cash Back Stores</h3>
                    <img src="<?php echo $themeUrl ?>/images/s-e-p.jpg" alt="Shop Our Exclusive Products" />
                </div>
                </a>
            </div>
            <div class="col-md-2 vert-sep">
                <span></span>
            </div>
            <div class="col-md-5 col-sm-6 train-vids text-center">
                <iframe width="487" height="260" src="https://www.youtube.com/embed/1VbqAs9cCoE?rel=0" frameborder="0" allowfullscreen></iframe>
                <h3>Learn all about building a shopping community</h3>
                <a href="https://www.youtube.com/user/ShopKarmora/videos?sort=dd&view=0&shelf_id=0" target="_blank" class="train-vids-btn">Watch Training Videos</a>
            </div>
        </div>
    </div>
</section>

<section class="blog-social-icons">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="b-s-i-wrap">
                    <h3>Let's Be Friends</h3>
                    <ul class="list-inline">
                        <li><a href="https://www.facebook.com/karmora" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                        <li><a href="https://www.instagram.com/shopkarmora" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://twitter.com/Shopkarmora" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
                        <li><a href="https://www.pinterest.com/shopkarmora/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="https://www.youtube.com/user/ShopKarmora" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

