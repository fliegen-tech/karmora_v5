
<!--====================================
=            paring section            =
=====================================-->
<section class="perfect-paring-sec page-spacing">
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
                                <img src="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pro['product_image']; ?>" class="before-animated">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="paring-rightbar">
                                <h3><?php echo $pro['product_title']; ?></h3>
                                <h5><?php echo $pro['product_detail']; ?></h5>
                                <div class="product-quanity">
                                    <div class="row">
                                        <div class="col-5">
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
                                        <div class="col-7">
                                            <a href="<?php echo base_url().'product-detail/'.$pro['pk_product_id']; ?>" class="btn btn-add-bag left-right-hover"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add To Bag</a>
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