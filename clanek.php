<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/roles.php";
$clanek_id = $_GET["id"];
$query = $db->fetch_assoc("SELECT * FROM clanky WHERE id=?", [$clanek_id]);
if (!$query)
{
    header("Location: /404");
}
$author = $db->fetch_assoc("SELECT user_id, username, id, status FROM uzivatele WHERE id=?", [$query["autor"]]);
?>
<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/top.php";
    if (isset($_SESSION["id"]))
        $user_status = $db->fetch_one("SELECT status FROM uzivatele WHERE id=?", [$_SESSION["id"]])[0];
    else
        $user_status = "user";
?>
<div id="clanek">
    <div id="clanek-head">
        <div id="headline-author">
            <h1><?php echo $query["nadpis"]?></h1>
            <h3>
                <?php
                    if (!$author) echo "[deleted]";
                    else echo "<a href=\"/user/{$author["id"]}\">{$author["username"]} ({$author["user_id"]})</a>";
                ?>
            </h3>
        </div>
        <div id="timestamps">
            <p>Vytvořeno: <?php echo date("j.n.Y G:i", $query["created"]) ?></p>
            <p>Aktualizováno:
                <?php
                    $date = $query["updated"];
                    if ($date != NULL) echo date("j.n.Y G:i", $date);
                ?>
            </p>
        </div>
    </div>
    <div id="clanek-actions">
        <a href="/clanek/<?php echo $clanek_id; ?>/edit" login-author="false">Editovat článek</a>
    </div>
    <div id="clanek-text">
        <?php
            $text = $query["text"];
            preg_match_all('/\((?:\n|)(?:.*?)(?:\n|)\)(?:\n|| )\[(?:\n|)(?:.*?)(?:\n|)\]/s', $text, $matche);

            foreach ($matche[0] as $match)
            {
                preg_match_all('/(?:(?<=\()(?:\n|).+?(?:\n|)(?=\)))|(?:(?<=\[)(?:\n|).+?(?:\n|)(?=\]))/s', $match, $coll);
                if ($coll[0] === []) continue;
                $coll = $coll[0];
                $new_sum = 
                "<div class='summary' opened='false'>
                    <h2>".nl2br(trim($coll[0]))."</h2>
                    <p>".nl2br(trim($coll[1]))."</p>
                </div>
                ";
                $text = str_replace($match, preg_replace('/[^\S ]+/', '', $new_sum), $text);
            }
            //echo $query[4];

            echo nl2br($text);
        ?>
    </div>
    <h3>Zdroje</h3>
    <div id="sources">
        <?php
            $sources = preg_split('/\r\n|\r|\n/', $query["sources"]);
            $ytregex = '/(?<=youtu.be\/|youtube.com\/watch\?v=).*/';

            foreach ($sources as $source)
            {
                if (preg_match($ytregex, $source, $matches))
                {
                    echo
                    "
                    <iframe
                    width='300'
                    src='https://www.youtube-nocookie.com/embed/$matches[0]'
                    title='YouTube video player'
                    frameborder='0'
                    allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
                    allowfullscreen
                    >
                    
                    </iframe>
                    ";
                }
                else if (preg_match('/(http:\/\/|https:\/\/)(.{2,}).*/', $source))
                {
                    echo "<a href=\"$source\">$source</a>";
                }
                else
                {
                    echo $source;
                }
            }
        ?>
    </div>
    <?php
        //echo $roles[$user_status] . $roles["admin_ae"];
        if (isset($_SESSION["id"]) && $_SESSION["id"] == $author["id"] || $roles[$user_status] >= $roles["admin_ae"])
            echo "<script>login_author();</script>";
    ?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>