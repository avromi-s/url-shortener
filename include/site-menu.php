<?php
    if (isset($siteRoot)) {
        $indexPageLink = $siteRoot . 'index.php';
        $shortenPageLink = $siteRoot . 'shorten/shorten.php';
        $loginPageLink = $siteRoot . 'account/login.php';
        $savedUrlsPageLink = $siteRoot . 'account/saved-urls.php';
        $aboutPageLink = $siteRoot . 'info/about.php';
        $contactPageLink = $siteRoot . 'info/contact.php';
    } else {
        $indexPageLink = 'index.php';
        $shortenPageLink = 'shorten/shorten.php';
        $loginPageLink = 'account/login.php';
        $savedUrlsPageLink = 'account/saved-urls.php';
        $aboutPageLink = 'info/about.php';
        $contactPageLink = 'info/contact.php';
    }

    echo
    "<nav>
        <ul id=\"navigation\" class=\"slimmenu\">
            <li><a href=\"$indexPageLink\">Home</a></li>
            <li><a href=\"$shortenPageLink\">Shorten a URL</a></li>
            <li><a href=\"$loginPageLink\">Account</a></li>
            <li><a href=\"$savedUrlsPageLink\">Saved URLs</a></li>
            <li><a href=\"$aboutPageLink\">About</a></li>
            <li><a href=\"$contactPageLink\">Contact</a></li>
        </ul>
    </nav>";


?>

<script>
    $('#navigation').slimmenu(
        {
            resizeWidth: '800',
            collapserTitle: 'Main Menu',
            animSpeed: 'medium',
            easingEffect: null,
            indentChildren: false,
            childrenIndenter: '&nbsp;'
        });
</script>
