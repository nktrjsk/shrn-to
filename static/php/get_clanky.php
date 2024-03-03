<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

$clanky = $db->fetch_all("SELECT * FROM clanky");

echo json_encode($clanky);