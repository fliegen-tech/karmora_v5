<section class="product-detail page-spacing">
    <div class="container">
        <?php echo $product_detail->product_header; ?>
        <div class="product-deail-cover">
            <div class="row">
                <div class="col-5">
                    <div class="product-leftbar">
                        <div class="app-figure" id="zoom-fig">
                            <a id="Zoom-1" class="MagicZoom" title="Show your product in stunning detail with Magic Zoom." href="<?php echo $themeUrl ?>/frontend/images/day3.jpg" >
                                <img src="<?php echo $themeUrl ?>/upload/images/product/<?php echo $product_detail->product_image; ?>?scale.height=400" alt=""/>
                            </a>
                            <?php if(!empty($product_album)){ ?>
                            <div class="selectors">
                                <?php foreach ($product_album as $pl){ ?>
                                <a
                                    data-zoom-id="Zoom-1"
                                    href="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pl['product_album_image']; ?>"
                                    data-image="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pl['product_album_image']; ?>?scale.height=400"
                                >
                                    <img srcset="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pl['product_album_image']; ?>?scale.width=112 2x" src="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pl['product_album_image']; ?>?scale.width=56"/>
                                </a>
                                <?php } ?>
                            </div>
                           <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="col-7">
                    <div class="product-detail-rightbar">
                        <h2>Flawless Days</h2>
                        <div class="price-offers">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Introductory offer $19.95
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" type="button">Premier Shopper (Save 40%) $71.95</button>
                                    <button class="dropdown-item" type="button">Casual Shopper (Save 20%) $95.95</button>
                                </div>
                            </div>
                        </div>
                        <div class="about-product">
                            <?php echo $product_detail->product_detail; ?>
                        </div>
                        <div class="product-quanity">
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                              <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </span>
                                        <input type="text" name="quant[2]" class="form-control input-number" value="1" min="1" max="100">
                                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </span>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <a href="" class="btn btn-add-bag left-right-hover"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add To Bag</a>
                                </div>
                            </div>
                        </div>
                        <?php echo $product_detail->product_tabs_content; ?>
                    </div>
                </div>
            </div>
        </div>
</section>
<!--====  End of Detail Page  ====-->

<!--===========================================
=            What our clients Says            =
============================================-->
<?php echo $product_detail->product_static_html; ?>
<!--====  End of What our clients Says  ====-->
<?php
if(!empty($perfect_paring)){
        $this->load->view('frontend/product/perfect_paring');
    }
?>




