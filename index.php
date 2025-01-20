<?php
    $siteRoot = '';
    $title = 'Home';
    $additionalHeadElements = '<link rel="stylesheet" href="res/slideshow-styles.css" />';
    include 'include/header.php';
?>
<main>
    <div>
        <h1>shortenURL</h1>
        <p>shortenURL allows you to take any long URL and shorten it to a much shorter one</p>
        <h2 class="slideshowcaption" style="color: black">Here's how it works</h2>
        <ul class="rslides">
            <li>
                <h4 class="slideshowcaption">Enter a long URL</h4>
                <div class="imgbox"><img class="center-fit" src="res/slideshow_image_1.jpg" alt="slideshow image"></div>
            </li>
            <li>
                <h4 class="slideshowcaption">Convert it</h4>
                <div class="imgbox"><img class="center-fit" src="res/slideshow_image_2.jpg" alt="slideshow image"></div>
            </li>
            <li>
                <h4 class="slideshowcaption">Receive a short URL</h4>
                <div class="imgbox"><img class="center-fit" src="res/slideshow_image_3.jpg" alt="slideshow image"></div>
            </li>
            <li>
                <h4 class="slideshowcaption">Share the short URL; it will redirect to the long URL you entered
                    automatically</h4>
                <div class="imgbox"><img class="center-fit" src="res/slideshow_image_4.jpg" alt="slideshow image"></div>
            </li>
        </ul>
    </div>
</main>

<script>
    $(function () {
        $(".rslides").responsiveSlides({nav: true});
    });
</script>

<?php include 'include/footer.php' ?>

