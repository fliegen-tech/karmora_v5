<script src="<?php echo $themeUrl ?>/frontend/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
            $('#uncheck').click(function (event) {
                console.info("here are you.");
                if (this.checked) {
                    $('.check').each(function () {
                        this.checked = false;
                    });
                }
                else {
                    $('.check').each(function () {
                        this.checked = true;
                    });
                }
                $('#uncheck').checked = true;
            });
        });
</script>