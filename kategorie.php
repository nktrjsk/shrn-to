<?php include_once $_SERVER["DOCUMENT_ROOT"]."/top.php" ?>

<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";
    $item = $db->fetch_one("SELECT * FROM kategorie WHERE path_name=?", [$_GET["cat"]])
?>

<h1>Kategorie: <?php echo $item[2]; ?></h1>

<div id="clanky">
<?php
    $clanky = $db->fetch_all("SELECT * FROM clanky WHERE category_id=?", [$item[0]]);
    foreach ($clanky as $clanek)
    {
        $query = $db->fetch_one("SELECT user_id, username FROM uzivatele WHERE id=?", [$clanek[2]]);
        if ($query)
        {
            $autor = "$query[1] ($query[0])";
        }
        else
        {
            $autor = "[deleted]";
        }

        echo "<div class=\"clanek\">";
        echo "<h3><a href=\"/clanek/$clanek[0]\">$clanek[3]</a></h3>";
        echo "<h5>$autor</h5>";
        echo "<p>".substr(preg_split('/\r\n|\r|\n/', $clanek[4])[0], 0, 100)."</p>";
        echo "</div>";
    }
?>
</div>

<?php include_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>