<?php
    session_start();
    $siteRoot = '../';
    $title = 'Account Info';
    include $siteRoot . 'include/header.php';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/sql-functions.php';
?>
<main>
    <div>
        <?php
            $originalUrl = $_POST['originalUrl'];
            $normalizedUrl = ensureUrlHasScheme($originalUrl);
            $expirationOffset = calculateExpirationDaysOffset($_POST['expirationType']);

            try {
                $mysqli = getNewDbConnection();
                if (!$mysqli || $mysqli->connect_errno) {
                    displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
                    exit();
                }

                $redirectUrlResult = getOrCreateRedirect($mysqli, $normalizedUrl, $expirationOffset, true);

                if ($redirectUrlResult) {
                    $resultRow = $redirectUrlResult->fetch_assoc();
                    $redirectUrl = $resultRow['pk_redirect_url_id'];
                } else {
                    displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
                    exit();
                }

                // If user is logged in, then also insert the redirect url in their collection
                if (isUserLoggedIn()) {
                    $categoryId = $_POST['categoryId'];
                    upsertUserRedirectUrl($mysqli, $_SESSION["username"], $redirectUrl, $categoryId);
                }

                echo "<h1>URL shortened</h1><br>";
                displayRedirectUrlLink($siteRoot, $resultRow);
            } catch (Exception $e) {
                displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
            }
        ?>
    </div>
</main>

<?php include $siteRoot . 'include/footer.php' ?>
