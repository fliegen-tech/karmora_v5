<?php if (!empty($sliders)) { ?>
<div class="cash-back-banner">
    <?php foreach ($sliders as $slide) { ?>
        <div class="cash-back-cover">
            <img src="<?php echo $themeUrl ?>/images/banner/<?php echo $slide['image'] ?>" alt="">
        </div>
    <?php } ?>
</div>
<?php } ?>
