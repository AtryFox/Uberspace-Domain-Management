<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

if (!isset($_POST["username"]) || !isset($_POST["uberspacen"])) {
    $msg = "E02";
    include("message.php");
    exit;
}

if ($_POST["uberspacen"] != $uberspacename) {
    $msg = "E13";
    include("message.php");
    exit;
}

$username = $_POST["username"];

$s = $pdo->prepare("SELECT username FROM $t_users WHERE username = :username LIMIT 1");
$s->execute(array('username' => $username));

if ($s->rowCount() != 1) {
    $msg = "E13";
    include("message.php");
    exit;
}

$homedir = "/home/" . $uberspacename;

if (!is_dir($homedir)) {
    $msg = "E14";
    include("message.php");
    exit;
}

$filepath = $homedir . "/udm-reset-password.php";

if (file_exists($filepath)) {
    $msg = "E15";
    include("message.php");
    exit;
}

$passwordCreationFile = '<?php
require_once("' . __DIR__ . '/../config.php");
require_once("' . __DIR__ . '/main.php");
require_once("' . __DIR__ . '/mysql.php");

$username = "' . $username . '";

$s = $pdo->prepare("SELECT username FROM $t_users WHERE username = :username LIMIT 1");
$s->execute(array(\'username\' => $username));

if ($s->rowCount() != 1) {
    echo "Username not found";
    exit;
}


$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%^&*()_-=+;:,.";
$password = substr( str_shuffle( $chars ), 0, 32 );

$salt = "";
$hashedPassword = makeHashSecure($password, $salt);

$s = $pdo->prepare("UPDATE $t_users SET password = :password, salt = :salt WHERE username = :username");
$s->execute(array(\'password\' => $hashedPassword, \'salt\' => $salt, \'username\' => $username));

echo "Uberspace Domain Management v'.$version.'";
echo "\n\nThe password of user \"'. $username. '\" has been changed!";
echo "\nNew password: \"" . $password . "\" (without quotation marks)";
echo "\n\nPlease change your password after your next login!\n";

unlink(__FILE__);

';


$fp = fopen($filepath, 'w');
fputs($fp, $passwordCreationFile);
fclose($fp);

$msg = "E16";
include("message.php");
exit;

