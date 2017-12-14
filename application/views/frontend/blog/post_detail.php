<section class="blog-page-sec page-spacing">
    <div class="container">
        <?php $this->load->view('frontend/blog/partials/blog-category-menu')?>
        <div class="row">
            <div class="col-12">
                <div class="category-detail-cover">
                    <div class="top-heading-cover">
                        <h1><?php echo $blog_detail->post_title; ?></h1>
                    </div>
                    <div class="posts-details inner-posts">
                        <a href=""><h3><?php echo date( 'M d.Y', strtotime( $blog_detail->post_create_datetime ) ) ?> By Taylor
                                Rae</h3></a>
                        <a href=""><img src="<?php echo $themeUrl ?>/images/blog/<?php echo $blog_detail->blog_image; ?> alt=""></a>
                        <?php echo $blog_detail->post_content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('frontend/blog/partials/blog-sub-footer')?>
