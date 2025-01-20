<?php
    $siteRoot = '';
    $title = 'Account Info';
    include 'include/header.php';
    include 'include/functions.php';
    include 'include/sql-functions.php';

    try {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        $redirectUrlId = substr($requestedUrl, 1);  // remove the leading forward slash

        $mysqli = getNewDbConnection();
        if (!$mysqli || $mysqli->connect_errno) {
            displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
            exit();
        }

        $redirectUrlResult = getExistingRedirectByPkId($mysqli, $redirectUrlId, true);
        if ($redirectUrlResult) {
            // todo increment numVisits count
            $originalUrl = $redirectUrlResult['original_url'];
            header("Location: $originalUrl");
            exit();
        } else {
            echo "
                <main>
                    <div>
                        <br><br>
                        <h1>URL not found or expired</h1>
                    </div>
                </main>
            ";
        }

    } catch (Exception $e) {
        displayMessage('An internal error occurred. Please try again.', 'shorten.php', 'Try again');
    }
?>

<?php include $siteRoot . 'include/footer.php' ?>
