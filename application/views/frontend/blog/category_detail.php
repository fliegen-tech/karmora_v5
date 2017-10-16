<section class="blog-header">
    <div class="container">
        <div class="row">
            <?php if(!empty($category)){ ?>
            <div class="col-md-12">
                <ul class="list-unstyled blog-header-list">
                    <li><a href="<?php echo base_url().'blog'; ?>">Home</a></li>
                    <?php foreach ($category as $c){ ?>
                    <li><a href="<?php echo base_url().'blog/category-detail/'.$c['pk_category_id']; ?>"><?php echo $c['category_title']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
</section>



                <section class="recent-blog-posts">
                    <div class="container">
                        <div class="col-md-12 text-center">
                            <?php if(empty($category_blog) && $category_id = 137){ ?>
                                <h2>B3 SUPPLEMENTS </h2>
                                <div class="clearfix"></div>
                                <span class="blog-sep1"></span>
                            <?php }else{ ?>
                            <h2><?php echo $category_blog[0]['cats']; ?></h2>
                            <?php } ?>
                        </div>
                        <?php if(!empty($category_blog) && $category_id != 137){ ?>
                        <div class="clearfix"></div>
                        <span class="blog-sep1"></span>
                        <div class="col-md-12">

                            <?php foreach($category_blog as $cat_d){ ?>
                            <!-- Post Start -->
                            <div class="blog-single-post text-center">
                                <a href="<?php echo base_url().'blog/post-detail/'.$cat_d['pk_post_id']; ?>"><img src="<?php echo $themeUrl.'/images/blog/'.$cat_d['blog_image']; ?>" alt="<?php echo $cat_d['post_title']; ?>"></a>
                                <h3><a href="<?php echo base_url().'blog/post-detail/'.$cat_d['pk_post_id']; ?>"><?php echo $cat_d['post_title']; ?></span></a></h3>
                                <p class="fazi">
                                    <?php echo preg_replace('/\s+?(\S+)?$/', '', substr($cat_d['post_content'], 0, 201)).'......';?>
                                </p>
                                <a href="<?php echo base_url().'blog/post-detail/'.$cat_d['pk_post_id']; ?>" class="blog-permalink">Read More</a>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </section>


<?php if($category_id == 137){ ?>
<?php if(!empty($category_blog)){ ?>

    <section class="b3supplements-blog-cover">
        <div class="container">
            <div class="row row-blog">
                <?php
                foreach($category_blog as $cat_d){
                    if($cat_d['pk_post_id'] == 26){
                        $detail_link = base_url().'blog/post-detail/34';
                    }elseif ($cat_d['pk_post_id'] == 25){
                        $detail_link = base_url().'blog/post-detail/37';
                    }
                    else{
                        $detail_link = base_url().'blog/post-detail/'.$cat_d['pk_post_id'];
                    }
                    ?>

                <div class="col-md-4 col-md-offset-1">
                    <div class="blog-coching-cover1">
                        <a href="<?php  echo $detail_link;//base_url().'blog/post-detail/'.$cat_d['pk_post_id']; ?>"><img src="<?php echo $themeUrl.'/images/blog/'.$cat_d['blog_image']; ?>"></a>
                        <div class="blogin-artical">
                            <h3><a href="<?php echo $detail_link;//base_url().'blog/post-detail/'.$cat_d['pk_post_id']; ?>"><?php echo $cat_d['post_title']; ?></a></h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        </div>
    </section>

<?php }} ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <span class="blog-sep"></span>
                        </div>
                    </div>
                </div>

    <?php if($category_id != 137){ ?>
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
    <?php } ?>


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
