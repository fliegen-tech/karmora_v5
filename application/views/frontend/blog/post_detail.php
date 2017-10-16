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
<section class="blog-innerpage-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="bloginner-heading">
                    <?php //print_r($blog_detail);?>
                    <h2><?php echo $blog_detail->post_title;?></h2>
                    <h3><?php echo date('M d.Y',strtotime( $blog_detail->post_create_datetime))?> By Taylor Rae<?php //echo $blog_detail->username;?></h3>
                </div>
                <div class="innerblog-cover">
                    <img src="<?php echo $themeUrl ?>/images/blog/<?php echo $blog_detail->blog_image;?>">
                </div>
                <div class="blog-detail">
                <?php echo $blog_detail->post_content;?>
                </div>
                
            </div>
        </div>
    </div>
</section>

<section class="karmora-stay-asome">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 stay-asmose-container">
                <h2>Stay awesome,</h2>
                <h3>Team Karmora</h3>
            </div>
        </div>
    </div>
</section>



<section class="after-blog-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5 shop-exc-prod">
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
            <div class="col-md-5 train-vids text-center">
                <iframe width="487" height="260" src="https://www.youtube.com/embed/1VbqAs9cCoE?rel=0" frameborder="0" allowfullscreen></iframe>
                <h3>Learn all about building a shopping community</h3>
                <a href="https://www.youtube.com/user/ShopKarmora/videos?sort=dd&view=0&shelf_id=0" target="_blank" class="train-vids-btn">Watch Training Videos</a>
            </div>
        </div>
    </div>
</section>

                <section class="blog-social-icons">
                    <div class="container">
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
                </section>
