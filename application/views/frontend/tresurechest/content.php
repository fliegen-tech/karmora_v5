<section class="click2-win-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center before-animated" id="top-img-cover">
                <img src="<?php echo $themeUrl ?>/frontend/images/click2win.png" class="img-fluid" alt="...">
            </div>
            <div class="click2win-desp">
                <div class="col-10 mx-auto">
                    <?php if (!isset($this->session->userdata['front_data']['id'])) {  ?>
                        <p>Premier Shoppers can win Cash & Prizes simply by surfing their personal Karmora Website in our Click2Win Program! <a href="<?php echo base_url('join-today-premier'); ?>">Click Here</a> to become a Premier Shopper TODAY!</p>
                        <span class="line-spc"></span>
                    <?php }else if ($this->session->userdata['front_data']['user_account_type_id'] != 5){?>
                        <p>Premier Shoppers can win Cash & Prizes simply by surfing their personal Karmora Website in our Click2Win Program! &nbsp; Premier Shoppers TODAY!</p>
                        <span class="line-spc"></span>
                    <?php  } else if ($this->session->userdata['front_data']['user_account_type_id'] == 5){?>
                        <p>Win great Cash & Prizes by surfing retail stores on your personal Karmora Website! &nbsp; Simply click through to any store to see if you have found Cash or Prizes! &nbsp; You can only win  one prize per day. &nbsp; Good Luck!</p>
                    <?php  } ?>
                </div>
            </div>
<?php if (!empty($Win_Cold_Hard_Cash)) { ?>
<div class="col-12">
    <div class="click2win-hardcash">
        <div class="hardcash-desp">
            <h3>Win Cold Hard Cash!</h3>
        </div>
        <div class="click2win-hardcash-types">
            <div class="row">
                <?php foreach ($Win_Cold_Hard_Cash as $cash) { ?>
                    <div class="col">
                        <div class="hardcash1 text-center">
                            <h4><?php echo $cash['winner_chest_gift_amount']; ?></h4>
                            <h5>Cash</h5>
                            <img src="<?php echo $themeUrl ?>/frontend/images/gift-box.png" class="img-fluid">
                            <p><?php echo $cash['quantity']; ?> Remaining</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if (!empty($Win_karmora_cash)) { ?>
<div class="col-12">
    <div class="click2win-hardcash">
        <div class="hardcash-desp">
            <h3>Win Karmora Kash!</h3>
        </div>
        <div class="click2win-hardcash-types">
            <div class="row">
                <?php foreach($Win_karmora_cash as $karmora_cash){ ?>
                    <div class="col">
                        <div class="hardcash1 text-center">
                            <h4>$<?php echo $karmora_cash['winner_chest_gift_amount']; ?></h4>
                            <h5>KARMORA KASH</h5>
                            <img src="<?php echo $themeUrl ?>/frontend/images/gift-box.png">
                    <p><?php echo $karmora_cash['quantity']; ?> Remaining</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php  } ?>

<?php if (!empty($Win_Gift_Cards)) { ?>
<div class="col-12">
<div class="click2win-hardcash">
    <div class="hardcash-desp">
        <h3>Win Gift Cards!</h3>
    </div>
    <div class="click2win-hardcash-types">
        <div class="row">
            <?php foreach ($Win_Gift_Cards as $card) { ?>
                        <div class="col">
                        <div class="hardcash1 text-center">
                        <img src="<?php echo $themeUrl ?>/images/promotions/winner_chest/<?php echo $card['winner_chest_gift_picture']; ?>">
                        <h4><?php echo $card['quantity']; ?> remaining</h4>
                        </div>
                        </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<?php } ?>

<?php if (!empty($Win_Exclusive_Products)) { ?>
<div class="col-12">
<div class="click2win-hardcash">
    <div class="hardcash-desp">
        <h3>Win Exclusive Products!</h3>
    </div>
    <div class="click2win-hardcash-types">
        <div class="row">
            <?php foreach ($Win_Exclusive_Products as $prod) { ?>
            <div class="col">
            <div class="hardcash1 text-center">
            <?php
                if($prod['fk_product_id'] !=NULL){
                      $imagesrc = 'product/'.$prod['winner_chest_gift_picture'];
                }else{
                    $imagesrc = 'promotions/winner_chest/'.$prod['winner_chest_gift_picture'];
                }
                ?>
                <img src="<?php echo $themeUrl ?>/images/<?php echo $imagesrc; ?>">
                <p>
                <?php echo $prod['winner_chest_gift_title']; ?> - <small><?php echo $prod['quantity']; ?> Remaining</small>
                </p></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<?php } ?>

</div>
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
</div>
</section>
    <!--====  End of Make money page ====-->

