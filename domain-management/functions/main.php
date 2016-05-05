<?php
error_reporting(0);

function getLoggedin()
{
    if (isset($_COOKIE["name"])) {
        if (isset($_COOKIE["key"])) {
            $username = $_COOKIE["name"];
            $password = $_COOKIE["key"];
            global $t_users, $pdo, $tablepreValid;

            if (!isset($pdo)) {
                return false;
            }

            if (!$tablepreValid) {
                return false;
            }

            $s = $pdo->prepare("SELECT password, salt FROM $t_users WHERE username = :username AND password = :password LIMIT 1");
            $s->execute(array('username' => $username, 'password' => $password));


            while ($r = $s->fetch()) {
                if (empty($r["salt"])) return false;
                return TRUE;
            }
            return FALSE;
        } else return FALSE;
    } else return FALSE;
}

function loginCheck($redirectPath = "../")
{
    if (!getLoggedin()) {
        header("Location: " . $redirectPath);
        exit;
    }
}

// deprecated //
function makeHash($hashThis)
{
    for ($i = 0; $i < 42; $i++) $hashThis = hash("sha512", $hashThis);
    return $hashThis;
}

function makeHashSecure($hashThis, &$salt)
{
    $salt = md5(rand() . mcrypt_create_iv(32));
    for ($i = 0; $i < 42; $i++) $hashThis = hash("sha512", $hashThis . $salt);
    return $hashThis;
}

function makeSaltedHash($hashThis, $salt)
{
    for ($i = 0; $i < 42; $i++) $hashThis = hash("sha512", $hashThis . $salt);
    return $hashThis;
}


function checkDomain($domain)
{
    global $t_domains, $pdo;
    $s = $pdo->prepare("SELECT domain FROM $t_domains WHERE domain = :domain");
    $s->execute(array('domain' => $domain));
    while ($r = $s->fetch()) {
        return TRUE;
    }
    return FALSE;
}

function checkLink($link, $id)
{
    if (is_link($link)) {
        return "<span style='color: green;'>Verfügbar</span>";
    } else {
        return "<span style='color: red;'><i class='fa fa-exclamation-triangle fa-fw'></i> Fehler (<a href='?p=edit-domain&id=" . $id . "'>Fehler beheben!</a>)</span>";
    }
}

function getLink($path1, $path2)
{
    if (file_exists($path1) ? readlink($path1) != "" : false) {
        return readlink($path1);
    } else if (file_exists($path2) ? readlink($path2) != "" : false) {
        return readlink($path2);
    } else {
        return "<span style='color: red;'>Der Link konnte nicht zurückverfolgt werden.</span>";
    }
}

function checkUpdate()
{
    global $version;

    $rawLatestVersion = file_get_contents("https://deratrox.de/dev/Uberspace_Domain_Management/cur.txt");
    $latestVersion = explode(".", $rawLatestVersion);

    if (!is_array($latestVersion)) return -1;
    if (sizeof($latestVersion) != 3) return -1;

    $installedVersion = explode(".", $version);
    if (!is_array($installedVersion)) return -1;
    if (sizeof($installedVersion) != 3) return -1;

    if ($installedVersion[0] < $latestVersion[0]) return $rawLatestVersion;
    else if ($installedVersion[1] < $latestVersion[1] && $installedVersion[0] == $latestVersion[0]) return $rawLatestVersion;
    else if ($installedVersion[2] < $latestVersion[2] && $installedVersion[1] == $latestVersion[1]) return $rawLatestVersion;

    return -1;
}