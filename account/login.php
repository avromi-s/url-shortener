<?php
    session_start();
    $siteRoot = '../';
    $title = 'Login';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/header.php';
?>
<main>
    <div>
        <?php
            if (!isUserLoggedIn()) {
                echo getLoginFormHtmlElement();
            } else {
                forwardToAccountInfo();
            }
        ?>
    </div>
</main>

<?php
    function getLoginFormHtmlElement(): string
    {
        return "
            <form name=\"login-form\" method=\"POST\" action=\"login-response.php\">
                <br>
                <label>
                    Username:
                    <input type=\"text\" name=\"username\" required/>
                </label>
                <br>
                <label>
                    Password:
                    <input type=\"password\" name=\"password\" required/>
                </label>
                <br>
                <br>
                <input type=\"SUBMIT\" name=\"login-button\" value=\"Login or Create Account\">
            </form>";
    }

    function forwardToAccountInfo(): void
    {
        header("Location: account-info.php");
        exit();
    }

?>
<?php include $siteRoot . 'include/footer.php' ?>
