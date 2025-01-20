<?php

    // user functions:

    function isUserLoggedIn(): bool
    {
        return array_key_exists("username", $_SESSION) &&
            array_key_exists("loggedIn", $_SESSION) &&
            $_SESSION["loggedIn"];
    }

    function loginUser($username): void
    {
        $_SESSION["username"] = $username;
        $_SESSION["loggedIn"] = true;
    }

    function logoutUser(): void
    {
        unset($_SESSION["username"]);
        $_SESSION["loggedIn"] = false;
    }

    function setUserJustCreated(bool $val): void
    {
        setcookie("userJustCreated", $val, path: '/');  // we need to set path = '/' so that cookie is available on the whole site
    }

    function getUserJustCreated(): bool
    {
        return $_COOKIE["userJustCreated"] ?? false;
    }

    // utility functions:

    function calculateExpirationDaysOffset($expirationType): int|bool
    {
        if (is_numeric($expirationType) && $expirationType > 0) {
            return (int)$expirationType;
        }
        return false;
    }

    function ensureUrlHasScheme($url): string|bool
    {
        $urlAlreadyHasScheme = str_starts_with($url, 'http');
        if (!$urlAlreadyHasScheme) {
            $url = 'https://' . $url;
        }

        return $url;
    }


    function displayMessage($message, $linkUrl, $linkText): void
    {
        echo "<br>$message<br><br>";
        echo "<a href=\"$linkUrl\">$linkText</a>";
    }

    function getHtmlDropdown($displayName, $name, $values): string
    {
        $dropdownElement = "
                        <label>
                            $displayName:
                            <br>
                            <select name=\"$name\" id=\"$name\">
                    ";

        foreach ($values as $key => $value) {
            $dropdownElement .= "<option value='$key'>$value</option>";
        }

        $dropdownElement .= "</select></label>";

        return $dropdownElement;
    }

    function displayUserRedirectsTable($siteRoot, mysqli_result $redirects): void
    {
        $siteDomainName = 'localhost';
        echo "<table>
                <tr>
                    <th>Original URL</th>
                    <th>Shortened URL</th>
                    <th>Expiration Date</th>
                    <th>Category</th>
                </tr>";
        while ($row = $redirects->fetch_assoc()) {
            $originalUrl = $row['original_url'];
            $shortenedUrl = $row['pk_redirect_url_id'];
            $shortenedUrlLink = "<a href=\"$siteRoot$shortenedUrl\">$siteDomainName/$shortenedUrl</a>";
            $expirationDate = $row['expiration_date'] ?? "N/A";
            $category = $row['category'];
            echo
            "<tr>
                <td>$originalUrl</td>
                <td>$shortenedUrlLink</td>
                <td>$expirationDate</td>
                <td>$category</td>
            </tr>";
        }
        echo '</table>';
    }

    function displayRedirectUrlLink($siteRoot, array $redirectRow): void
    {
        echo '<p><b>Original URL - Shortened URL - Expiration Date</b><br>';

        $siteDomainName = 'localhost';
        $redirectUrl = $redirectRow['pk_redirect_url_id'];
        $originalUrl = $redirectRow['original_url'];
        $expirationDate = $redirectRow['expiration_date'] ?? "<i>N/A</i>";

        echo "<br>$originalUrl - <a href=\"$siteRoot$redirectUrl\">$siteDomainName/$redirectUrl</a> - $expirationDate<br>";
    }

    function getAutoRefreshHtmlMetaElement(): string
    {
        return '<meta http-equiv="refresh" content="5; url=login.php">';
    }

?>