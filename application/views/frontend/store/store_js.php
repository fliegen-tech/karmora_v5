
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
                    $('#fav-' + storeId).html('<span id="fav-' + storeId + '"><a href="javascript:void(0)"  onClick=' + onclick_condation + ' id="' + storeId + '"><i class="fa fa-heart"></i></a></span>');
                } else {
                    var onclick_condation = "favourtie(" + storeId + ",'fvrt')";
                    $('#fav-' + storeId).html('<span id="fav-' + storeId + '"><a href="javascript:void(0)" onClick=' + onclick_condation + ' id="' + storeId + '"><i class="fa fa-heart-o"></i></a></span>');
                }
            }
        });
    }


</script>