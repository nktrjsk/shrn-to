<?php
    session_start();

    if (!isset($_SESSION["uid"]))
    {
        header("HTTP/1.0 403 Forbidden");
        header("Location: /403");
    }
    else
    {
        include_once $_SERVER["DOCUMENT_ROOT"]."/top.php";
    }
?>
<h1></h1>
<?php include_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>