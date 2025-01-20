<?php
    $siteRoot = '../';
    $title = 'Contact Us';
    include $siteRoot . 'include/header.php';
?>
    <main>
        <div>
            <form name="contact-form" method="POST" action="contact-response.php">
                <h2>Contact Us</h2>
                <label>
                    Email:
                    <br>
                    <input type="email" name="email" required/>
                </label> <br> <br>
                <label>
                    Message:
                    <br>
                    <textarea name="message" required></textarea>
                </label> <br> <br>
                <input type="SUBMIT" name="submit-button">
            </form>
        </div>
    </main>
<?php include $siteRoot . 'include/footer.php' ?>