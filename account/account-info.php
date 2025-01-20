<?php
    session_start();
    $siteRoot = '../';
    $title = 'Account Info';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/header.php';
?>
    <main>
        <?php
            if (getUserJustCreated()) {
                echo "<h2>Account created</h2>";
                setUserJustCreated(false);
            }
        ?>
        <div>
            <?php
                // the user_was_just_created() check above is not sufficient/secure enough for purposes of validating
                // login, so we must check again here based on session variable
                if (isUserLoggedIn()) {
                    echo '<p>User ID: <b>' . $_SESSION["username"] . '</b></p>';
                    echo "<br><a href=\"saved-urls.php\">Saved URLs</a><br><br>";
                    echo getLogoutButtonHtml();
                } else {
                    echo '<h2>Login failed. Please try again.</h2>';
                    echo '<br><br>';
                    echo '<a href="login.php">Login</a>';
                }
            ?>
        </div>
    </main>

<?php

    function getLogoutButtonHtml(): string
    {
        return "
            <form name=\"logout-form\" method=\"POST\" action=\"logout-response.php\">
                <input type=\"SUBMIT\" name=\"logout-button\" value=\"Logout\">
            </form>";
    }

?>
<?php include $siteRoot . 'include/footer.php' ?>