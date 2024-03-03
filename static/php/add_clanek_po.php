<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$autor = $_POST["autor"];
$nadpis = $_POST["nadpis"];
$text = $_POST["text"];

if(empty($autor) || empty($nadpis) || empty($text)) {
    echo "empty";

    die();
} elseif($db->fetch_one("SELECT * FROM clanky WHERE nadpis=?", [$nadpis])) {
    echo "duplicate";
} else {
    $db->execute("INSERT INTO clanky (autor, nadpis, text) VALUES (?, ?, ?)", [$autor, $nadpis, $text]);

    echo "success";
}