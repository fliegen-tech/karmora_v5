<?php if(!empty($sliders)){ ?>
<section class="slider-section">
<div class="container">
  <div class="row">
    <div class="col">
        <div class="home-page-slider">
        <?php foreach ($sliders as $slide) { ?>
            <div class="slider-cover">
                <a target="_blank" href="<?php echo base_url().$slide['url'];  ?>"><img src="<?php echo $themeUrl ?>/images/banner/<?php echo $slide['image'] ?>" alt="<?php echo $slider['title'];?>"></a>
            </div>
        <?php } ?>
        </div>
    </div>
  </div>
</div>
</section>
<?php } ?>