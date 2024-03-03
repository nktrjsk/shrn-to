<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$clanek_id = $_POST["id"];
$query = $db->fetch_one("SELECT * FROM clanky WHERE id=?", [$clanek_id]);

if ($_SESSION["id"] !== $query[4])
{
    header("HTTP/1.0 403 Forbidden");
    die("Forbidden");
}

if (isset($_POST["nadpis"], $_POST["kategorie"], $_POST["content"], $_POST["sources"]))
{
    $nadpis = htmlspecialchars($_POST["nadpis"]);
    $kategorie = $_POST["kategorie"];
    if ($kategorie == "null") $kategorie = NULL;
    $content = htmlspecialchars($_POST["content"]);
    $sources = htmlspecialchars($_POST["sources"]);
    $autor = $_SESSION["id"];
    $updatedate = time();

    if ($nadpis === $query[5]);
    else if ($db->fetch_one("SELECT nadpis FROM clanky WHERE nadpis=?", [$nadpis]))
    {
        die("headline-taken");
    }

    $db->execute("UPDATE clanky SET updated=?, nadpis=?, category_id=?, text=?, sources=? WHERE id=?", [$updatedate, $nadpis, $kategorie, $content, $sources, $clanek_id]);
    die("success");
}
else
{
    die("vars_not_set");
}

die("nic");