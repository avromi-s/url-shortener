<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title ?? 'Page'; ?></title>
        <link rel="stylesheet"
              href="<?php echo ($siteRoot ?? '') . 'res/styles.css' ?>">
        <link rel="stylesheet"
              href="<?php echo ($siteRoot ?? '') . 'res/libraries/slimmenu.min.css' ?>"
              type="text/css">
        <script src="<?php echo ($siteRoot ?? '') . 'res/libraries/jquery-3.6.0.min.js'  ?>"
                crossorigin="anonymous">
        </script>
        <script src="<?php echo ($siteRoot ?? '') . 'res/libraries/responsiveslides.min.js' ?>"></script>
        <?php echo isset($additionalHeadElements) ? $additionalHeadElements : ''; ?>
    </head>
    <body>
        <header>
            <img src="<?php echo ($siteRoot ?? '') . 'res/logo.jpg' ?>"
                 alt="shortenURL logo"
                 class="logo"/>
            <br> <br> <br>
        </header>
        <script src="<?php echo ($siteRoot ?? '') . 'res/libraries/jquery.slimmenu.min.js' ?>">
        </script>
        <?php include 'site-menu.php' ?>
