<?php if (!empty($sliders)) { ?>
<div class="cash-back-banner">
    <?php foreach ($sliders as $slide) { ?>
        <div class="cash-back-cover">
            <a target="_blank" href="<?php echo base_url().$slide['url'];  ?>"><img src="<?php echo $themeUrl ?>/images/banner/<?php echo $slide['image'] ?>" alt=""></a>
        </div>
    <?php } ?>
</div>
<?php } ?>
