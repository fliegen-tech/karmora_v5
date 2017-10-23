<?php if(!empty($smokin_hot_deals)){ ?>
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
            <div class="col-12">
                <div class="smoking-deal-slider">
                    <?php foreach ($smokin_hot_deals as $sat_sdeal){ ?>
                        <div class="smoking-deal-cover">
                            <img src="<?php echo $themeUrl.'/images/'.$sat_sdeal['store_image']?>" alt="">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>