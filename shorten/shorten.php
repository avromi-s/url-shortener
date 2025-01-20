<?php
    session_start();
    $siteRoot = '../';
    $title = 'Shorten a URL';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/sql-functions.php';
    include $siteRoot . 'include/header.php';

    // get dropdown data
    try {
        $mysqli = getNewDbConnection();
        if (!$mysqli || $mysqli->connect_errno) {
            displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
            exit();
        }

        $expirationTypes = getExpirationTypes($mysqli);
        if (isUserLoggedIn()) {  // categories are only for use in a user's account
            $categories = getCategories($mysqli);
        }
    } catch (Exception $e) {
        displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
        exit();
    }
?>
<main>
    <div>
        <form name="shorten-form" method="POST" action="shorten-response.php">
            <h2>Shorten a URL</h2>
            <label>
                URL to shorten:
                <br>
                <input type="text" name="originalUrl" required/>
            </label>
            <br>
            <?php
                if (isset($expirationTypes)) {
                    echo '<br>';
                    echo getHtmlDropdown('Link expiration (days from now)', 'expirationType', $expirationTypes);
                    echo '<br>';
                }
            ?>
            <?php
                if (isset($categories)) {
                    echo '<br>';
                    echo getHtmlDropdown('Category', 'categoryId', $categories);
                    echo '<br>';
                }
            ?>
            <br>
            <input type="SUBMIT" name="submit-button">
        </form>
    </div>
</main>
<?php include $siteRoot . 'include/footer.php' ?>
