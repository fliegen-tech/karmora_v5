<form method="post" enctype="multipart/form-data" id="cart_form" name="cart_form">
<section class="product-detail page-spacing">
    <div class="container">
        <?php echo $product_detail->product_header; ?>
        <div class="product-deail-cover">
            <div id="cart_content"></div>
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
                                <select class="btn btn-secondary dropdown-toggle" id="shoper_type" name="shoper_type">
                                    <option value="<?php echo '5 ='.$product_detail->product_price; ?>">Autual Price $<?php echo $product_detail->product_price; ?></option>
                                    <option value="<?php echo $product_price_cart_premier->fk_user_account_type_id.'='.$product_price_cart_premier->one_time_price; ?>"><?php echo $product_price_cart_premier->user_account_type_title; ?>(Save <?php echo abs($product_price_cart_premier->one_time_percent); ?>%) $<?php echo $product_price_cart_premier->one_time_price; ?></option>
                                    <option value="<?php echo $product_price_cart_premier->fk_user_account_type_id.'='.$product_price_cart_casual->one_time_price; ?>"><?php echo $product_price_cart_casual->user_account_type_title; ?>(Save <?php echo abs($product_price_cart_casual->one_time_percent); ?>%) $<?php echo $product_price_cart_casual->one_time_price; ?></option>
                                </select>
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
                                        <input type="text" name="quantity" id="quantity" class="form-control input-number" value="1" min="1" max="100">
                                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantity">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </span>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <button class="btn btn-add-bag left-right-hover" type="submit">Add To Bag<i class="fa fa-cart-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <?php echo $product_detail->product_tabs_content; ?>
                    </div>
                </div>
            </div>
        </div>
</section>
<!--==== hidden fildes  ====-->
<input type="hidden" name="karmora_mikamak677" value="b2a4e24c7ba1a537195e23c911345744" />
<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_detail->pk_product_id; ?>">

</form>
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




