<?php
    session_start();
    $siteRoot = '../';
    $title = 'Contact Us';
    include $siteRoot . 'include/mail.php';
    include $siteRoot . 'include/header.php';
?>
    <main>
        <div>
            <?php
                $email = $_POST['email'];
                $message = $_POST['message'];
                $subject = "Message from $email";

                $result = send_mail($subject, $message);
                if ($result["success"]) {
                    echo "Message sent";
                } else {
                    echo "Error sending message. Please try again later.<br><br>";
                }
            ?>
        </div>
    </main>
<?php include $siteRoot . 'include/footer.php' ?>