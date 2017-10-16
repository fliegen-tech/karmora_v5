<div class="bodyWrap">
    <div class="containerH">
        <!--breadDiv -->
        
        <div class="logo-bg" style="width: 100%; margin: 0 auto; text-align: center; background: url(http://staging3.karmora.com/public/images/loading-banner.png); background-repeat: no-repeat; background-position: center center;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody><tr>
                        <td width="650" height="608" align="center" valign="middle" class="bg"><table width="530" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                        <td align="center" valign="middle"><p class="heading2" style="margin-top: 50px;"><strong>One  moment please </strong> <img src="<?php echo $themeUrl; ?>/images/loader.gif" alt="..."></p>
                                            <span class="heading2">You are being transferred to one of our Premier Advertisers<br>
                                            </span><span class="heading3"><strong><?php echo $title; ?></strong></span><span class="heading2"><br>
                                                to complete your Karmora Shopping Experience.</span></td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle" class="border">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="middle"><table width="400" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <!-- <td width="114"> <img width="50" height="50" src="<?php echo $themeUrl; ?>/images/profile-pic/<?php echo $profilePic; ?>" class="memberPic border-img"></td> -->
                                                        <!--<td style="text-align: center" colspan="2" width="286" class="heading3"><strong>Shopping from a desktop or laptop computer is the safest way to ensure you receive credit for your purchase, as not all advertisers are able to track purchases from smart phones and tablet computers. Have a great day... and thanks for shopping with Karmora!</strong></td>-->
                                                    </tr>
                                                </tbody></table></td>
                                    </tr>
                                </tbody></table></td>
                         </tr>
                    </tbody>
                </table>
            </div>

    </div>
    <!--containerH -->
</div>
<div class="modal fade" id="Success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content model-save-money" style="height: 556px;">
      <div class="modal-header">
          <button type="button" class="close popup-close" data-dismiss="modal" onclick="redirectOnClose()" aria-label="Close"><i class="fa fa-times"></i></button>
        <div class="karmora-logo-save-money karmora-click-2-win-margin">
          <img src="<?php echo $themeUrl ?>/images/click-2-win-popup.png">
        </div>
        <h4 class="modal-title karmora-save-title karmora-uppercase" id="myModalLabel">Congratulations!</h4>
      </div>
      <div class="modal-body">
        <!-- <h5 class="kamora-save-desp-a">Karmora Guarantees that our Premier Shoppers will earn the highest Cash Back available on the internet!The process is simple:</h5> -->
        <div class="box-cover-gift karmora-box-popup-gft">
            <h1>$<?php echo $prizefound; ?></h1>
            <h5><?php if(isset($amount_type)){ echo $amount_type;}else{ echo 'Cold Hard Cash'; } ?></h5>
            <div class="gift-box-cover">
              <img src="<?php echo $themeUrl ?>/images/gift-box.png">
            </div>
        </div>
        <p class="pop-up-p">
          You have found a hidden treasure in our Click2Win Promotion! Your <?php if(isset($amount_type)){ echo $amount_type;}else{ echo 'Cold Hard Cash'; }?> has been deposited into your e�?Wallet! You can only win once per day, so come back tomorrow and try your luck!
        </p>
    
      </div>
        <div  style="text-align: center;"><a class="btn btn-default btn-add-product" href="<?php echo $url; ?>">Continue Shopping</a></div>
      </div>
  </div>
</div>

<?php if(isset($prizefound) && $prizefound!='') { ?>  
    <script type="text/javascript">
        $(window).load(function() {
            $('#Success').modal('show');
        });
    </script>
<?php }?>
<?php if((!isset($casualdata) || $casualdata == '' ) && $prizefound == ''){ ?>
<script>
    location.href='<?php echo $url; ?>';
</script>
<?php } ?>

<?php if (isset($casualdata) && $casualdata!='') { ?>
<script type="text/javascript">
    $(window).load(function() {
        $('#Successcasual').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });
</script>
<?php } ?>


<div class="modal fade" id="Successcasual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content model-save-money" style="height: 630px;">
      <div class="modal-header">
        <button type="button" class="close popup-close" onclick="redirectOnClose()" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
<!--         <div class="karmora-logo-save-money karmora-click-2-win-margin">
          <img src="<?php // echo $themeUrl ?>/images/click-2-win-popup.png">
        </div> -->
        <h4 class="modal-title karmora-save-title karmora-uppercase" id="myModalLabel">You Found a Karmora Buried Treasure!</h4>
      </div>
      <div class="modal-body">
        <!-- <h5 class="kamora-save-desp-a">Karmora Guarantees that our Premier Shoppers will earn the highest Cash Back available on the internet!The process is simple:</h5> -->
        <div class="box-cover-gift karmora-box-popup-gft">
            <h1>$<?php echo $casualdata->amount; ?></h1>
            <h5>CASH</h5>
            <div class="gift-box-cover">
              <img src="<?php echo $themeUrl ?>/images/gift-box.png">
            </div>
        </div>
        <p class="desp-stro-p">
          You have found a hidden treasure in our Click2Win Promotion.  Unfortunately, you are not a Premier Shopper so you are unable to claim your prize.  The prize can still be yours:
        </p>
          <ul class="desp-stro-list">
            <li><strong><span>Step 1: &nbsp;</span> Upgrade to Premier Shopper by clicking the button below…</strong></li>
            <li><strong><span>Step 2: &nbsp;</span> Now go back to this store and click the shop now button to win the prize…</strong></li>
          </ul>
        </p>
    
      <div class="poprp-rating-btn karmora-popup-btn-gft">
          <a href="<?php echo base_url('karmora-upgrade'); ?>" class="upgrade-btn-pop">Upgrade</a>
          <a href="<?php echo base_url(); ?>" class="upgrade-btn-pop">No Thanks</a>
      </div>
        
        <p style="font-weight: 600; font-size: 8px; font-style: italic; padding-left: 10px; padding-right: 10px; margin-top: 18px; line-height: 12px;">It is possible that by the time you return to the Cash Back Store and click Shop now another Premier Shopper may have found your prize.  You can check the Winner Board on the Click2Win home page to view the winner.  You can always start surfing to find different prize and you can win once per day!  Your new Premier Shopper Membership is backed by our 30 Day – No Questions Asked – Money Back Guarantee!</p>
        
      </div>

    </div>
  </div>
</div>
<script>
function redirectOnClose() {
    location.href='<?php echo $url; ?>';
}
</script>
