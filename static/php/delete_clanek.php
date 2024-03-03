<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$clanek_id = $_POST["id"];
$query = $db->fetch_one("SELECT * FROM clanky WHERE id=?", [$clanek_id]);

if (!isset($_SESSION) || $_SESSION["id"] !== $query[2])
{
    header("HTTP/1.0 403 Forbidden");
    die("Forbidden");
}
else
{
    $db->execute("DELETE FROM clanky WHERE id=?", [$clanek_id]);
    die("success");
}