<section class="karmora-store-detail">
    <div class="container">
        <div class="row">
            <?php $this->load->view('frontend/layout/partials/category'); ?>

            <div class="col-md-9 table-responsive">
                <h1 class="text-left" style="margin: 0px;">All Stores</h1>
                <span class="line-spc"></span>

                <table class="table table-responsive table-striped " id="hunt-table">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Cash Back</th>
                            <th>Favorites</th>
                            <th>Shop</th>
                        </tr>
                    </thead>
                    <tbody class="store-table">
                        <tr>
                            <td colspan="4" style="text-align: center">
                                <a href="#" id="top"></a>

                                <?php
                                $first = true;
                                foreach ($storeArray as $nouseVars) {
                                    if ($first) {
                                        reset($storeArray);
                                        $first = false;
                                    }
                                    ?>
                                    <a href="#<?php echo key($storeArray); ?>"><?php echo key($storeArray); ?></a>
                                    <?php
                                    next($storeArray);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $first = true;
                        foreach ($storeArray as $storeIn) {
                            if ($first) {
                                reset($storeArray);
                                $first = false;
                            }
                            ?>
                            <tr>
                                <td class="store_offset" colspan="3" style=" background-color: #CC2161;" align="left"><a style="color: white; " href="#" id="<?php echo key($storeArray); ?>" name=""><b><?php echo key($storeArray); ?></b></a></td>
                                <td style=" background-color: #CC2161; vertical-align: middle;"><a style="color: white; " href="#top">Back to Top</a></td>
                            </tr>
    <?php
    foreach ($storeIn as $store) {
        ?>
                                <tr>
                                    <td><a href="<?php echo base_url() ?>store-detail/<?php echo $store['store_id'] ?>"><?php echo $store['store_title']; ?></a></td>
                                    <td><?php if (!$this->session->userdata('front_data')) {
                                        echo 'Up to 30%';
                                    } else {
                                        echo $store['cash_back_percentage'];
                                    } ?></td>
                                    <td><span class="button-checkbox"  >
                                            <?php
                                            if (!$this->session->userdata('front_data')) {
                                                ?>
                                                <a href="<?php echo base_url() . 'login' ?>" id="addfav-button">Login</a>
                                                <?php
                                            } else {
                                                if ($store['fk_store_id'] != '') {
                                                    ?>
                                                    <span id="fav-<?php echo $store['store_id'] ?>"><a href="javascript:void(0)" onClick="favourtie(<?php echo $store['store_id'] ?>, 'unfvrt')" id="<?php echo $store['store_id']; ?>" class="fav-icon active"><i class="fa fa-heart"></i></a></span>
                <?php
            } else {
                ?>
                                                    <span id="fav-<?php echo $store['store_id'] ?>"><a href="javascript:void(0)" onClick="favourtie(<?php echo $store['store_id'] ?>, 'fvrt')" id="<?php echo $store['store_id']; ?>" class="fav-icon" ><i class="fa fa-heart-o"></i></a></span>
                                                <?php
                                            }
                                        }
                                        ?>

                                        </span></td>

                                    <td>
                                <?php if (!$this->session->userdata('front_data')) {
                                    ?>
                                            <a href="<?php echo base_url() . 'premier-shopper-signup' ?>">Join Today</a>
                                    <?php } else {
                                    ?>
                                            <a href="<?php echo base_url() ?>store-visit/<?php echo $store['store_id'] ?>" target="_blank" class="td-upgrade">Shop Now</a>
        <?php } ?></td>
                                </tr>
        <?php
    }
    next($storeArray);
}
?>

                    </tbody>
                </table>


            </div>


        </div>

    </div>
</section>

<script>
    function favourtie(storeId, option_type) {

        jQuery.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {"karmora_mikamak677":csrfHash},
            url: baseurl + 'storefavourtie/' + storeId + '/' + option_type,
            context: document.body,
            error: function (data, transport) {
                alert("Sorry, the operation is failed.");
            },
            success: function (data) {
                $('#fav-' + storeId).html('');
                if (option_type === 'fvrt') {
                    var onclick_condation = "favourtie(" + storeId + ",'unfvrt')";
                    $('#fav-' + storeId).html('<span id="fav-' + storeId + '"><a href="javascript:void(0)"  onClick=' + onclick_condation + ' id="' + storeId + '" class="fav-icon active"><i class="fa fa-heart"></i></a></span>');
                } else {
                    var onclick_condation = "favourtie(" + storeId + ",'fvrt')";
                    $('#fav-' + storeId).html('<span id="fav-' + storeId + '"><a href="javascript:void(0)" onClick=' + onclick_condation + ' id="' + storeId + '" class="fav-icon"><i class="fa fa-heart-o"></i></a></span>');
                }
            }
        });
    }
</script>