<div class="bodyWrap">
  <div> 
    <h1><?php echo $storeTitle;?></h1>
    
    <img alt="<?php echo $storeTitle?>" src="<?php echo $this->themeUrl; ?>/images<?php echo $storeImage; ?>">
    
  </div>
</div>

<?php 
header("refresh:0.001;url=".base_url()); 
?>