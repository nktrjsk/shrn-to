<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$uid = $_POST["uid"];
$password = $_POST["password"];

if (!$db->fetch_one("SELECT * FROM uzivatele WHERE user_id=?", [$uid]))
{
    $password_salt = bin2hex(random_bytes(32));
    $password_pepper = "b4c2d5bc8a41683adc280c468ea7cf2881e5d8ce55798e6702cf213115fdfbbd";
    $combined = hash("sha256", $password.$password_salt.$password_pepper);
    $user_id = str_replace(" ", "_", strtolower(preg_replace('/[^a-zA-Z0-9]/', "", $uid)));

    $counter = 0;
    while ($db->fetch_one("SELECT user_id FROM uzivatele WHERE user_id=?", [$user_id.$counter]))
    {
        $counter++;
    }
    $user_id .= $counter;

    $db->execute("INSERT INTO uzivatele (user_id, username, password) VALUES (?, ?, ?)", [$user_id, "default", "$combined$$password_salt"]);
    $id = $db->fetch_one("SELECT id FROM uzivatele WHERE user_id=?", [$user_id])[0];
    copy($_SERVER["DOCUMENT_ROOT"]."/static/users/profile_img/default.png", $_SERVER["DOCUMENT_ROOT"]."/static/users/profile_img/$id.png");
    echo "registered;$user_id";
}
else
{
    echo "uid-taken";
}