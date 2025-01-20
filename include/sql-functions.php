<?php
    $siteRoot = $siteRoot ?? '../';  // use siteRoot as defined in the .php file that includes this one; if it's not define then use the root from here
    require_once $siteRoot . 'config.php';

    function getNewDbConnection(): mysqli|bool
    {
        global $dbHostname, $dbUsername, $dbPassword, $dbDatabase;
        if (!isset($dbHostname) || !isset($dbUsername) || !isset($dbPassword) || !isset($dbDatabase)) {
            return false;
        }

        return new mysqli($dbHostname, $dbUsername, $dbPassword, $dbDatabase);
    }

    // SELECT queries:

    function isValidUsername(mysqli $mysqli, $username): bool
    {
        $sql = "SELECT * FROM user WHERE login_id='$username';";
        $result = $mysqli->query($sql);
        return $result->num_rows > 0;
    }

    function isValidLogin(mysqli $mysqli, $username, $password): bool
    {
        $sql = "SELECT login_id FROM user WHERE login_id='$username' and password='$password'";
        $result = $mysqli->query($sql);
        return $result->num_rows > 0;
    }

    function getOrCreateRedirect(mysqli $mysqli, $originalUrl, $expirationOffset, $insertIfNew): bool|mysqli_result
    {
        $redirectUrlInfo = getExistingRedirectByOriginalUrl($mysqli, $originalUrl, $expirationOffset);

        if (!$redirectUrlInfo && $insertIfNew) {
            insertNewRedirectUrl($mysqli, $originalUrl, $expirationOffset);
            $redirectUrlInfo = getExistingRedirectByOriginalUrl($mysqli, $originalUrl, $expirationOffset);
        }

        if (!$redirectUrlInfo) {
            return false;
        } else {
            return $redirectUrlInfo;
        }
    }

    function getExistingRedirectByOriginalUrl(mysqli $mysqli, $originalUrl, $expirationOffset = false): bool|mysqli_result
    {
        // if an offset is provided, find only a redirect_url that has the same expiration date
        // otherwise find one with no date (i.e., that doesn't expire)
        if ($expirationOffset) {
            $sql = "SELECT pk_redirect_url_id, original_url, expiration_date FROM redirect_url
                         WHERE original_url = '$originalUrl' 
                            AND (expiration_date = DATE_ADD(DATE(NOW()), INTERVAL $expirationOffset DAY)) LIMIT 1;";
        } else {
            $sql = "SELECT pk_redirect_url_id, original_url, expiration_date FROM redirect_url
                         WHERE original_url = '$originalUrl' 
                            AND expiration_date IS NULL LIMIT 1;";
        }

        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        }
        return false;
    }

    function getExistingRedirectByPkId(mysqli $mysqli, $redirectUrlId, $excludeExpiredLinks = true): bool|array|null
    {
        if ($excludeExpiredLinks) {
            $sql = "SELECT original_url FROM redirect_url 
                    WHERE
                        (expiration_date IS NULL OR expiration_date >= NOW())
                        AND pk_redirect_url_id = $redirectUrlId;";
        } else {
            $sql = "SELECT original_url FROM redirect_url 
                    WHERE pk_redirect_url_id = $redirectUrlId;";
        }

        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    function getUserRedirects(mysqli $mysqli, $username): mysqli_result|bool
    {
        $fkUserId = getLoggedInPkId($mysqli, $username);
        $sql = "
            SELECT pk_redirect_url_id, original_url, expiration_date, redirect_url_category.name AS 'category'
            FROM
                (SELECT * FROM user_redirect_url WHERE fk_user_id = $fkUserId) users_urls
            INNER JOIN
                redirect_url
            ON redirect_url.pk_redirect_url_id = users_urls.fk_redirect_url_id
            INNER JOIN
                redirect_url_category
            ON redirect_url_category.pk_redirect_url_category_id = users_urls.fk_redirect_url_category_id;
                ";

        return $mysqli->query($sql);
    }

    function getLoggedInPkId(mysqli $mysqli, $username): bool|int
    {
        $sql = "SELECT pk_user_id FROM user WHERE login_id='$username';";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['pk_user_id'];
        }
        return false;
    }

    function getExpirationTypes(mysqli $mysqli): array
    {
        $sql = "SELECT days_amount, display_text FROM expiration_type ORDER BY days_amount";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            $types = array();
            while ($row = $result->fetch_assoc()) {
                $types[$row['days_amount']] = $row['display_text'];
            }
            return $types;
        }
        return array();
    }

    function getCategories(mysqli $mysqli): array
    {
        $sql = "SELECT pk_redirect_url_category_id, name FROM `redirect_url_category` ORDER BY pk_redirect_url_category_id;";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            $categories = array();
            while ($row = $result->fetch_assoc()) {
                $categories[$row['pk_redirect_url_category_id']] = $row['name'];
            }
            return $categories;
        }
        return array();
    }

    // INSERT queries:

    function createLogin(mysqli $mysqli, $username, $password): bool
    {
        try {
            $sql = "INSERT INTO `user` (`login_id`, `password`) VALUES ('$username', '$password');";
            return $mysqli->query($sql);
        } catch (Exception $e) {
            return false;
        }
    }

    function insertNewRedirectUrl(mysqli $mysqli, $originalUrl, $expirationOffset): mysqli_result|bool
    {
        if ($expirationOffset) {
            $sql = "INSERT INTO `redirect_url` (`original_url`, `expiration_date`)
                            VALUES ('$originalUrl', DATE_ADD(DATE(NOW()), INTERVAL $expirationOffset DAY));";
        } else {
            $sql = "INSERT INTO `redirect_url` (`original_url`)
                            VALUES ('$originalUrl');";
        }
        return $mysqli->query($sql);
    }

    function insertNewUserRedirectUrl(mysqli $mysqli, $username, $redirectUrlId, $categoryId): mysqli_result|bool
    {
        $fkUserId = getLoggedInPkId($mysqli, $username);
        if ($fkUserId != null) {
            $sql = "INSERT INTO `user_redirect_url` (`fk_user_id`, `fk_redirect_url_id`, `fk_redirect_url_category_id`)
                        VALUES ('$fkUserId', '$redirectUrlId', '$categoryId');";
            return $mysqli->query($sql);
        }

        return false;
    }

    function upsertUserRedirectUrl(mysqli $mysqli, $username, $redirectUrlId, $categoryId): mysqli_result|bool
    {
        $fkUserId = getLoggedInPkId($mysqli, $username);
        if ($fkUserId != null) {
            $sql = "INSERT INTO `user_redirect_url`
                    (`fk_user_id`, `fk_redirect_url_id`, `fk_redirect_url_category_id`)
                    VALUES ('$fkUserId', '$redirectUrlId', '$categoryId')
                    ON DUPLICATE KEY UPDATE
                    `fk_redirect_url_category_id` = $categoryId;";
            // only the category is updated if the entry already exists as nothing else is changeable

            return $mysqli->query($sql);
        }

        return false;
    }

?>