<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

if (!isset($_SESSION["uid"]))
{
    header("HTTP/1.0 403 Forbidden");
    die("Forbidden");
}

$username = htmlspecialchars($_POST["username"]);
$old_uid = $_SESSION["uid"];
$new_uid = $_POST["uid"];
$id = $_SESSION["id"];
if (isset($_FILES["file"]))
{
    $avatar = $_FILES["file"];
    $avatar_name = $avatar["name"];
    $avatar_path = $avatar["tmp_name"];
}

if (!preg_match('/^[a-z0-9_.]*$/', $new_uid))
{
    echo "id-bad-format";
    die();
}

$db->execute("UPDATE uzivatele SET username=? WHERE id=?", [$username, $id]);
$_SESSION["username"] = $username;
if (!$db->fetch_one("SELECT user_id FROM uzivatele WHERE user_id=? and id!=?", [$new_uid, $id]))
{
    $db->execute("UPDATE uzivatele SET user_id=? WHERE user_id=?", [$new_uid, $old_uid]);
    $_SESSION["uid"] = $new_uid;
}
else if ($old_uid === $new_uid)
{
    
}
else
{
    echo "id-taken";
}

if (isset($avatar))
{
    $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));
    if (!in_array($extension, ["png", "jpg"]))
    {
        echo "avatar-bad-format";
    }
    else
    {
        
        move_uploaded_file($avatar_path, $_SERVER["DOCUMENT_ROOT"]."/static/users/profile_img/$id.png");
    }
}