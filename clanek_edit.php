<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/roles.php";

    $query = $db->fetch_assoc("SELECT * FROM clanky WHERE id=?", [$_GET["id"]]);
    $user_status = $db->fetch_one("SELECT status FROM uzivatele WHERE id=?", [$_SESSION["id"]])[0];
    echo "<script>alert(" . $roles[$user_status] . ")</script>";
    $clanek_cat = $query["category_id"];
    if (!isset($_SESSION["id"]) || $query["autor"] !== $_SESSION["id"] || $roles[$user_status] < $roles["admin_ae"])
    {
        header("HTTP/1.0 403 Forbidden");
        header("Location: /403");
    }
    else
    {
        include_once $_SERVER["DOCUMENT_ROOT"]."/top.php";
    }
?>
<h1>Upravit článek</h1>
<div id="novy-clanek">
    <h3 id="novy-clanek-error"></h3>
    <div class="novy-clanek-input">
        <label for="novy-clanek-headline">Nadpis: </label>
        <input type="text" name="headline" id="novy-clanek-headline" value="<?php echo $query["nadpis"]?>">
    </div>
    <div class="novy-clanek-input">
        <label for="novy-clanek-categories">Kategorie:</label>
        <select name="categories" id="novy-clanek-categories">
            <option value="null">Nezařazeno</option>
            <?php
                require_once $_SERVER["DOCUMENT_ROOT"]."/static/php/categories.php";
                $print_categories = function ($categories, $depth=0)
                {
                    global $db, $print_categories, $clanek_cat;

                    foreach ($categories as $item => $value)
                    {
                        $selected = "";
                        if ($item === $clanek_cat)
                        {
                            $selected = "selected";
                        }
                        $query = $db->fetch_one("SELECT * FROM kategorie WHERE id=?", [$item]);
                        //echo $name;
                        echo "<option value=\"$query[0]\" $selected>".str_repeat("&nbsp;", $depth)."$query[2]</option>";
                        $print_categories($categories[$item], $depth+1);
                    }
                };
                $print_categories(get_categories());
            ?>
        </select>
    </div>
    <div class="novy-clanek-input">
        <textarea name="content" id="novy-clanek-content" cols="30" rows="10"><?php echo $query["text"]?></textarea>
    </div>
    <div class="novy-clanek-input">
        <label for="novy-clanek-sources">Zdroje:</label>
        <br>
        <textarea name="sources" id="novy-clanek-sources" cols="30" rows="1"><?php echo $query["sources"]?></textarea>
    </div>
    <div class="novy-clanek-input">
        <button id="novy-clanek-send" onclick="update_clanek()">Upravit článek</button>
    </div>
    <div class="novy-clanek-input">
        <button id="novy-clanek-delete" onclick="delete_clanek()">Smazat článek</button>
    </div>
</div>
<?php include_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>