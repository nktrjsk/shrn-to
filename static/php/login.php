<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$uid = $_POST["uid"];
$password = $_POST["password"];
$userquery = $db->fetch_assoc("SELECT * FROM uzivatele WHERE user_id=?", [$uid]);

if (!$userquery)
{
    echo "user-not-found";
}
else
{
    $password_hash = explode("$", $userquery["password"])[0];
    $password_salt = explode("$", $userquery["password"])[1];
    $password_pepper = "b4c2d5bc8a41683adc280c468ea7cf2881e5d8ce55798e6702cf213115fdfbbd";
    $combined = hash("sha256", $password.$password_salt.$password_pepper);

    if ($password_hash === $combined)
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), session_id(), 0,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        if ($_POST["stay-logged"] === "true")
        {
            setcookie(session_name(), session_id(), time() + 86400 * 30,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }
        /* setcookie(session_name(),session_id(),0); */
        $_SESSION["id"] = $userquery["id"];
        $_SESSION["username"] = $userquery["username"];
        $_SESSION["uid"] = $userquery["user_id"];
        echo "success";
    }
    else
    {
        echo "wrong-password";
    }
}