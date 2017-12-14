<!--====================================
=            paring section            =
=====================================-->

    <?php $supplement_id = reset($perfect_paring)->fk_category_id;//print_r( $perfect_paring );?>

<section class="perfect-paring-sec page-spacing <?php echo (isset($supplement_id) && $supplement_id == '114')?'supplemnts-paring-sec':'';?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-heading">
                    <h2>perfect parings</h2>
                </div>
            </div>
        </div>
        <div class="paring-cover">
            <div class="row">
                <?php foreach ($perfect_paring as $pro){ ?>
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">
                            <div class="paring-leftbar">
                                <img src="<?php echo $themeUrl ?>/images/product/<?php echo $pro->product_image; ?>" class="before-animated">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="paring-rightbar">
                                <h3><?php echo $pro->product_title; ?></h3>
                                <h5><?php echo $pro->product_detail; ?></h5>
                                <div class="product-quanity">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="<?php echo base_url().'product-detail/'.$pro->pk_product_id; ?>" class="btn btn-joinnow left-right-hover">View More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<!--====  End of paring section  ====-->