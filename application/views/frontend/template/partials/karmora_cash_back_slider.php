<?php if (!empty($sliders)) { ?>
<div class="cash-back-banner">
    <?php foreach ($sliders as $slide) { ?>
        <?php
        echo "<pre style='display:none'>";
        print_r($slide);
        echo "</pre>";
        ?>
        <div class="cash-back-cover">
            <img src="<?php echo $themeUrl ?>/images/banner/<?php echo $slide['image'] ?>" alt="">
        </div>
    <?php } ?>
</div>
<?php } ?>
