<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if (isset($fb_url)) {
        echo "<meta property='fb:app_id' content='1455287054704424'>";
    }if (isset($fb_title)) {
        echo '<meta property="og:title" content="' . $fb_title . '">';
    }if (isset($fb_image)) {
        echo "<meta property='og:image' content='" . $fb_image . "'>";
    }if (isset($fb_description)) {
        echo '<meta property="og:description" content="' . $fb_description . '">';
    }
    ?>
    <title>Karmora</title>

    <!-- Main CSS -->
    <link href="<?php echo $themeUrl ?>/frontend/css/main.css" rel="stylesheet" />
    <link href="<?php echo $themeUrl ?>/frontend/css/responsive.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<?php
echo $header;
echo $content;
echo $footer;
?>