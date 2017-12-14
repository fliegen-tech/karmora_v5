<section class="blog-page-sec page-spacing">
    <div class="container">
        <?php $this->load->view('frontend/blog/partials/blog-category-menu')?>
        <div class="blog-categories">
            <div class="row">
                <?php if ( ! empty( $category ) ) { ?>
                    <?php foreach ( $category as $cat ) { ?>
                        <div class="col-5 mx-auto">
                            <div class="blog-cat-cover">
                                <a href="<?php echo base_url() . 'blog/category-detail/' . $cat['pk_category_id']; ?>">
                                    <img src="<?php echo $themeUrl ?>/images/categories/<?php echo $cat['category_image']; ?>"/>
                                    <h3><span><?php echo $cat['category_title']; ?></span></h3>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="recent-posts">
            <h3>Most Recent Posts</h3>
        </div>
    </div>
</section>
<?php $this->load->view('frontend/blog/partials/blog-sub-footer')?>


