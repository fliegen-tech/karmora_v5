<?php
if ($productList) {
    ?>
    <div class="exclusive-products">
        <div class="row">
            <?php
            foreach ($productList as $product) {
                ?>
                <div class="col-3 no-padding">
                    <div class="exclusive-cover">
                        <div class="form-check form-check-inline">
                            <h5>Select</h5>
                            <label class="form-check-label">
                                <input class="form-check-input product-radio" required="" type="radio" name="product" id="inlineRadio1" value="<?php echo $product['pk_product_id']; ?>">
                            </label>
                        </div>
                        <div class="img-cover-exclusive">
                            <img src="<?php echo $themeUrl.'/images/product/'.$product['product_image']; ?>" class="img-fluid">
                        </div>
                        <div class="exclusive-dep">
                            <h3><a href=""><?php echo $product['product_title']; ?></a></h3>
                            <p>Suggested Retail Price: <span>$<?php echo number_format($product['product_price'], 2, '.', ','); ?></span></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}