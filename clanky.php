<?php require_once $_SERVER["DOCUMENT_ROOT"]."/top.php" ?>
<h1>Všechny články</h1>
<div id="clanky">
<?php
    $clanky = $db->fetch_all_a("SELECT * FROM clanky");
    //echo "<script>alert(".print_r($clanky).")</script>";
    foreach ($clanky as $clanek)
    {
        //echo "<script>alert(".print_r($clanek).")</script>";
        $query = $db->fetch_assoc("SELECT user_id, username FROM uzivatele WHERE id=?", [$clanek["autor"]]);
        if ($query)
            $autor = "{$query["username"]} ({$query["user_id"]})";
        else
            $autor = "[deleted]";

        echo "<div class=\"clanek\">";
        echo "<h3><a href=\"/clanek/{$clanek["id"]}\">{$clanek["nadpis"]}</a></h3>";
        echo "<h5>$autor</h5>";
        echo "<p>".substr(preg_split('/\r\n|\r|\n/', $clanek["text"])[0], 0, 100)."</p>";
        echo "</div>";
    }
?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>