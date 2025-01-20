<?php

    session_start();
    $siteRoot = '../';
    $title = 'Login';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/sql-functions.php';
    include $siteRoot . 'include/header.php';
    require_once '../config.php';
?>

<main>
    <div>
        <?php
            if (!isValidPostData()) {
                displayMessage('An internal error occurred. Please try again.', 'login.php', 'Try again');
                exit();
            }

            try {
                $mysqli = getNewDbConnection();
                if (!$mysqli || $mysqli->connect_errno) {
                    displayMessage('An internal error occurred. Please try again.', 'login.php', 'Try again');
                    exit();
                }

                if (isValidUsername($mysqli, $_POST["username"])) {
                    if (isValidLogin($mysqli, $_POST["username"], $_POST["password"])) {
                        loginUser($_POST["username"]);
                    } else {
                        logoutUser();
                    }
                } else {
                    if (createLogin($mysqli, $_POST["username"], $_POST["password"])) {
                        loginUser($_POST["username"]);
                        setUserJustCreated(true);
                    }
                }

                forwardToAccountInfo();

            } catch (Exception $e) {
                displayMessage('An internal error occurred. Please try again.', 'login.php', 'Try again');
                exit();
            }
        ?>
    </div>
</main>
<?php

    function isValidPostData(): bool
    {
        return array_key_exists("username", $_POST) && array_key_exists("password", $_POST);
    }

    function forwardToAccountInfo(): void
    {
        header("Location: account-info.php");
        exit();
    }

?>
<?php /*include $site_root . 'include/footer.php' */ ?>
