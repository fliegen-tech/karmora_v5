<section class="calick2win-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="click2win-cover-header">
              <img src="<?php echo $themeUrl ?>/images/click2winheader.png">
            </div>
            <span class="line-spc"></span>
          </div>
          
          <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div class="click2win-title">
              <?php if (!isset($this->session->userdata['front_data']['id'])) {  ?>
                        <p>Premier Shoppers can win Cash & Prizes simply by surfing their personal Karmora Website in our Click2Win Program! &nbsp;  <a href="<?php echo base_url().'premier-shopper-signup'; ?>"> Click Here</a> to become a Premier Shopper TODAY!</p>
                        <span class="line-spc"></span>
              <?php }else if ($this->session->userdata['front_data']['user_account_type_id'] != 5){?>
                        <p>Premier Shoppers can win Cash & Prizes simply by surfing their personal Karmora Website in our Click2Win Program! &nbsp; Premier Shoppers TODAY!</p>
                        <span class="line-spc"></span>
              <?php  } else if ($this->session->userdata['front_data']['user_account_type_id'] == 5){?>
                        <p>Win great Cash & Prizes by surfing retail stores on your personal Karmora Website! &nbsp; Simply click through to any store to see if you have found Cash or Prizes! &nbsp; You can only win  one prize per day. &nbsp; Good Luck!</p>
              <?php  } ?>          
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <span class="line-spc"></span><span class="line-spc"></span>
<?php if (!empty($Win_Cold_Hard_Cash)) { ?>
    <section class="gift-box-sec">
      <div class="container">
        <div class="row">
          <h2>Win Cold Hard Cash!</h2>
          <span class="line-spc"></span>
          <div class="col-md-12 gift-boxes-main-cover">
            <?php foreach ($Win_Cold_Hard_Cash as $cash) { ?>   
            <div class="col-md-2 col-sm-3 col-xs-4">
              <div class="box-cover-gift">
                <h1>$<?php echo $cash['winner_chest_gift_amount']; ?></h1>
                <span class="line-spc"></span>
                <h5>CASH</h5>
                <span class="line-spc"></span>
                <div class="gift-box-cover">
                  <img src="<?php echo $themeUrl ?>/images/gift-box.png">
                </div>
                <span class="line-spc"></span>
                <p><?php echo $cash['quantity']; ?> Remaining</p>
              </div>
              <div class="clearfix"></div> 
            <span class="line-spc"></span><span class="line-spc"></span>
            </div>

            <?php } ?>  

          </div>
        </div>
      </div>
    </section>
    <hr>
    <span class="line-spc"></span><span class="line-spc"></span>
 <?php } ?> 
    
    <?php if (!empty($Win_karmora_cash)) { ?>
        <section class="gift-box-sec">
      <div class="container">
        <div class="row">
          <h2>Win Karmora Kash!</h2>
          <span class="line-spc"></span><span class="line-spc"></span>
          <div class="clearfix"></div>
          <div class="col-md-12  gift-boxes-main-cover">
             <?php foreach($Win_karmora_cash as $karmora_cash){ ?> 
                <div class="col-md-2 col-sm-3 col-xs-4">
              <div class="box-cover-gift">
                <h1>$<?php echo $karmora_cash['winner_chest_gift_amount']; ?></h1>
                <span class="line-spc"></span>
                <h5>KARMORA KASH</h5>
                <span class="line-spc"></span>
                <div class="gift-box-cover">
                  <img src="<?php echo $themeUrl ?>/images/gift-box.png">
                </div>
                <span class="line-spc"></span>
                <p><?php echo $karmora_cash['quantity']; ?> Remaining</p>
              </div>
              <span class="line-spc"></span><span class="line-spc"></span>
            </div>
             <?php } ?> 
            
          </div>
        </div>
      </div>
    </section>
    <hr>
    <span class="line-spc"></span><span class="line-spc"></span>
    <?php  }?>
    
<?php if (!empty($Win_Gift_Cards)) { ?>
    <section class="karmora-giftcards-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              <h2>Win Gift Cards!</h2>
              <div class="gifts-cards-main-cover">
                  <?php foreach ($Win_Gift_Cards as $card) { ?> 
                <div class="col-md-2">
                  <div class="gift-image-cover">
                    <img src="<?php echo $themeUrl ?>/images/promotions/winner_chest/<?php echo $card['winner_chest_gift_picture']; ?>">
                    <h4><?php echo $card['quantity']; ?> remaining</h4>
                  </div>
                </div>
                  <?php } ?> 
                
              </div>
          </div>
        </div>
      </div>
    </section>
        <?php } ?>

    <?php if (!empty($Win_Exclusive_Products)) { ?>
    <section class="remaing-product-slider">
      <div class="container">
        <div class="row">
          <h2>Win Exclusive Products!</h2>

          <div class="customNavigation  clicknav col-md-1 col-sm-1 col-xs-1">
            <a class="btn prev custom-arrow"><i class="fa fa-angle-left"></i></a>
          </div>

            <div class="col-md-10 col-sm-10 col-xs-9">

              <div id="owl-click2" class="owl-carousel">
                <?php foreach ($Win_Exclusive_Products as $prod) { ?> 
                <div class="col-md-12 click4-cover">
                  <div class="click4-cover2">
                      <?php 
                        if($prod['fk_product_id'] !=NULL){ 
                                $imagesrc = 'product/'.$prod['winner_chest_gift_picture'];
                        }else{
                                $imagesrc = 'promotions/winner_chest/'.$prod['winner_chest_gift_picture'];
                        } 
                        ?>
                    <img src="<?php echo $themeUrl ?>/images/<?php echo $imagesrc; ?>">
                    <div class="flawesl-click-hading">
                        <?php echo $prod['winner_chest_gift_title']; ?> - <small><?php echo $prod['quantity']; ?> Remaining</small>
                    </div>
                  </div>
                  
                </div>
                <?php } ?>    
              </div>
        </div>
          <div class="customNavigation clicknav col-md-1 col-sm-1 col-xs-1">
                 <a class="btn next custom-arrow"><i class="fa fa-angle-right"></i></a>
          </div>
              

        </div>
      </div>
    </section>
    <?php } ?>


<?php if (!empty($winner)) { ?>
    <section class="data-stump-sec">
        <h2>Winner Board!</h2>
        <span class="line-spc"></span>
        <div class="clearfix"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 table-responsive"> 
            <table class="table table-striped">
              <thead class="bluebac">
                <tr>
                  <th>Data Stamp</th>
                  <th>Name</th>
                  <th>Store</th>
                  <th>Prize Found</th>
                  <th>Prize Type</th>
                </tr>
              </thead>
              <tbody class="font-family-body">
                  <?php foreach ($winner as $w) { ?>
                  <tr>
                    <td class="heading-tabel"><?php echo $w['winning_date']; ?></td>
                    <td><?php echo $w['user_first_name'] . ' ' . $w['user_last_name']; ?></td>
                    <td><?php echo $w['store_title']; ?></td>
                    <td>$<?php echo number_format($w['amount'],2); ?></td>
                    <td><?php if($w['fk_winner_chest_gift_type_id'] == 4 ){ echo 'Karmora Kash';}elseif($w['fk_winner_chest_gift_type_id'] == 1){ echo 'Cold Hard Cash';} ?></td>
                  </tr>
                  <?php } ?>
              </tbody>
        </table>
          </div>
        </div>
      </div>
    </section>
<?php } ?>
<script>
  $(window).load(function(e) {
        $("#bn1").breakingNews({
      effect    :"slide-h",
      autoplay  :true,
      timer   :8000,
      color   :"red"
    }); 
    });
  $(document).ready(function() {

      
   


      var owl = $("#owl-click2");

      owl.owlCarousel({

      items : 3, //10 items above 1000px browser width
      itemsDesktop : [1000,3], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,2], // 3 items betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0;
      itemsMobile : [600,1],  // itemsMobile disabled - inherit from itemsTablet option
         pagination : true,
    paginationNumbers: false,
      });

      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      })

      $('#testnav li').mouseover(function(){
        $(this).addClass('open');
      });

      $('#testnav li').mouseout(function(){
        $(this).removeClass('open');
      });

$('.single-item').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000
    });




    });
 </script>
<?php $this->load->view('frontend/layout/partials/premier_shopper_reviews'); ?>