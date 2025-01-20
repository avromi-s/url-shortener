<?php
    session_start();
    $siteRoot = '../';
    $title = 'Logout';
    include $siteRoot . 'include/functions.php';
    include $siteRoot . 'include/header.php';
?>
<main>
    <div>
        <?php
            logoutUser();
            forwardToLoginPage();
        ?>
    </div>
</main>

<?php

    function forwardToLoginPage(): void
    {
        header("Location: login.php");
        exit();
    }

?>
<?php include $siteRoot . 'include/footer.php' ?>
