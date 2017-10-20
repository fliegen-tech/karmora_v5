
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function () {
        FB.init({
            appId: '1455287054704424',
            status: true,
            xfbml: true,
            cookie: true
        });
    };
    /**
     * FaceBook Share function
     */
    function sharepost(name, url, img, des) {

        FB.ui({
            method: 'feed',
            name: name,
            link: url,
            picture: img,
            description: des,
        }, function (response) {
        });
    }
</script>