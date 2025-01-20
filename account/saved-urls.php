<?php
    session_start();
    $siteRoot = '../';
    $title = 'Saved URLs';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/sql-functions.php';
    include $siteRoot . 'include/header.php';
?>
    
    <main>
        <div>
            <?php

                try {
                    if (isUserLoggedIn()) {
                        $mysqli = getNewDbConnection();
                        if (!$mysqli || $mysqli->connect_errno) {
                            displayMessage('An internal error occurred. Please try again.', "{$siteRoot}shorten/shorten.php", 'Try again');
                            exit();
                        }
    
                        $result = getUserRedirects($mysqli, $_SESSION["username"]);
    
                        if (!$result) {
                            displayMessage('Error retrieving your saved URLs. Please try again later.', '../index.php', 'Home');
                            exit();
                        } else if ($result->num_rows == 0) {
                            displayMessage("You don't have any saved URLs. ", "{$siteRoot}shorten/shorten.php", 'Create a shortened URL');
                            exit();
                        } else {
                            displayUserRedirectsTable($siteRoot, $result);
                        }
                    } else {
                        displayMessage('You need to login to see your saved URLs', 'login.php', 'Login');
                        exit();
                    }

                } catch (Exception $e) {
                    displayMessage('An internal error occurred. Please try again.', "{$siteRoot}shorten/shorten.php", 'Try again', false);
                }

            ?>
        </div>
    </main>

<?php include $siteRoot . 'include/footer.php' ?>