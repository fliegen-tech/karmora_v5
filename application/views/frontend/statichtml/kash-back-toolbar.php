<section class="karmora-tool-bar page-spacing">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2>Karmora Cash Back Toolbar</h2>
        <p>The easiest way to earn Cash Back & Commissions!</p>
      </div>
    </div>
    <div class="toobar-cover">
      <div class="row">
        <div class="col-12">
          <div class="tool-img-cover">
            <img src="<?php echo $themeUrl ?>/frontend/images/toolbar-banner.jpg" alt="">
          </div>
          <div class="tool-bar-content">
            <h3>Never Miss Out on Cash Back or Commissions Again!</h3>
            <p>“I love the Karmora Kash Back Toolbar!   No matter where I shop online if Karmora has that store I get the cash back.   It’s awesome!” <span>Jane S. - Boise, ID</span></p>
            <p>“I encourage all the Shoppers in my Shopping Community to download the toolbar on all of their computers.   Not only do they earn $5 Karmora Kash for every download it ensures that I won’t miss out on commissions or matching Karmora Kash if they forget to start their shopping at their Karmora Website.   Brilliant!” <span>Julia P. - Jacksonville, FL</span></p>
            <p>“Sometimes I just forget to start my online shopping on my Karmora Website.   I downloaded the toolbar on my PC at work, my PC at home and my tablet and earned $75 Karmora Kash!   Now it’s near impossible for me to miss out on cash back!” <span>Kelly Q. - San Jose, CA</span></p>
          </div>
          <div class="tool-bar-content">
            <h3>Earn $5 Karmora Kash!</h3>
            <div class="col-6 mx-auto toolbar-video">
              <a href="#" data-toggle="modal" data-target="#karmora-kash-video">
                <img src="<?php echo $themeUrl ?>/frontend/images/karmora-kash-toolbar-video-popup.png" alt="">
              </a>
            </div>
            <div class="text-center">
              <?php if($broswer_detail['name'] == 'Mozilla Firefox'){ ?>
                <?php if ($this->session->userdata('front_data')) { ?>
                  <a href="<?php echo base_url().'download-extension/mozila'; ?>" target="_blank" class="btn btn-joinnow left-right-hover">Get the Toolbar!</a>
                <?php }else{ ?>
                  <a href="<?php echo base_url().'join-today'; ?>" class="btn btn-joinnow left-right-hover">Get the Toolbar!</a>
                <?php } ?>
              <?php }else if($broswer_detail['name'] == 'Google Chrome'){ ?>
                <?php if ($this->session->userdata('front_data')) { ?>
                  <a href="<?php echo base_url('download-extension/chorme'); ?>"  target="_blank" class="btn btn-joinnow left-right-hover">Get the Toolbar!</a>
                  <img src="<?php echo $themeUrl ?>/frontend/images/available-chrome.png" alt="">
                <?php }else{ ?>
                  <a href="<?php echo base_url().'join-today'; ?>" class="btn btn-joinnow left-right-hover">Get the Toolbar!</a>
                <?php } ?>
              <?php }else{ echo 'Not Avaialable';} ?>
            </div>
            <p>The Karmora Cash Back Toolbar is a non-invasive plugin for your internet browser allowing us to help ensure that you, or your Shoppers, never miss out on Cash Back opportunities. It does not allow Karmora access to your computer or any of its files. If you have any questions or concerns please <a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)">click here</a> to speak with a Good Karmora Specialist.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
