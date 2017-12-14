<section class="blog-page-sec page-spacing">
    <div class="container">
        <?php $this->load->view( 'frontend/blog/partials/blog-category-menu' ) ?>
        <div class="row">
            <div class="col-12">
                <div class="category-detail-cover">
                    <div class="top-heading-cover">
                        <h1><?php echo $category_blog[0]['cats']; ?></h1>
                    </div>
                    <?php if ( ! empty( $category_blog ) ) { ?>
                        <?php foreach ( $category_blog as $cat_d ) { ?>
                            <div class="posts-details">
                                <a href="<?php echo base_url() . 'blog/post-detail/' . $cat_d['pk_post_id']; ?>">
                                    <h3><?php echo $cat_d['post_title']; ?></h3></a>
                                <a href="<?php echo base_url() . 'blog/post-detail/' . $cat_d['pk_post_id']; ?>"><img
                                            src="<?php echo $themeUrl . '/images/blog/' . $cat_d['blog_image']; ?>"
                                            alt=""></a>
                                <p><?php echo preg_replace( '/\s+?(\S+)?$/', '', substr( $cat_d['post_content'], 0, 201 ) ) . '......'; ?></p>
                                <a href="<?php echo base_url() . 'blog/post-detail/' . $cat_d['pk_post_id']; ?>"
                                   target="_blank" class="btn btn-blog btn-blog-hover">Read More</a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view( 'frontend/blog/partials/blog-sub-footer' ) ?>


