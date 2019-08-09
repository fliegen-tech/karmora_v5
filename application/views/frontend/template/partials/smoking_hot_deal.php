<?php if ( ! empty( $smokin_hot_deals ) ) { ?>
    <section class="cash-o-palooza-sec page-spacing">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="top-heading-cover">
                        <h1>Smokin Hot Deals</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="smoking-deal-slider">
                        <?php foreach ( $smokin_hot_deals as $sat_sdeal ) { ?>
                            <div class="smoking-deal-cover">
                                <a href="<?php echo base_url( 'store-detail/' . $sat_sdeal['store_id'] ) ?>">
                                    <img src="<?php echo $themeUrl . '/images/' . $sat_sdeal['store_image'] ?>" alt="">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
