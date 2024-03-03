<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

if (isset($_POST["nadpis"], $_POST["kategorie"], $_POST["content"], $_POST["sources"]))
{
    $nadpis = htmlspecialchars($_POST["nadpis"]);
    $kategorie = $_POST["kategorie"];
    $content = htmlspecialchars($_POST["content"]);
    $sources = htmlspecialchars($_POST["sources"]);
    $autor = $_SESSION["id"];
    $created = time();

    if ($db->fetch_one("SELECT nadpis FROM clanky WHERE nadpis=?", [$nadpis]))
    {
        die("headline-taken");
    }

    $db->execute("INSERT INTO clanky (category_id, created, autor, nadpis, text, sources) VALUES (?, ?, ?, ?, ?, ?)", [$kategorie, $created, $autor, $nadpis, $content, $sources]);
    $id = $db->fetch_one("SELECT id FROM clanky WHERE nadpis=?", [$nadpis]);

    die("success " . $id[0]);
}
else
{
    die("vars_not_set");
}

die("nic");