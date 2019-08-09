<?php if ( ! empty( $cash_o_palooza ) ) { ?>
    <section class="cash-o-palooza-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="top-heading-cover before-animated">
                        <h1>Double Take</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="cash-o-palooza-slider">
                        <?php foreach ( $cash_o_palooza as $cat_deal ) { ?>
                            <div class="cash-o-palooza-cover">
                                <a href="<?php echo base_url( 'store-detail/' . $cat_deal['store_id'] ) ?>">
                                    <img src="<?php echo $themeUrl . '/images/' . $cat_deal['store_image'] ?>" alt="">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
