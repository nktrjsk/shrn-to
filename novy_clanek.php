<?php
    session_start();

    if (!isset($_SESSION["id"]))
    {
        header("HTTP/1.0 403 Forbidden");
        header("Location: /403");
    }
    else
    {
        include_once $_SERVER["DOCUMENT_ROOT"]."/top.php";
    }
?>
<h1>Nový článek</h1>
<div id="novy-clanek">
    <h3 id="novy-clanek-error"></h3>
    <div id="novy-clanek-rules">
        <h3 id="novy-clanek-rules-headline">Příručka a základní pravidla</h3>
        <div id="novy-clanek-rules-content">
            <h4 id="novy-clanek-rules-headline-rules">Pravidla</h4>
            <ol>
                <li>1. Nediskriminovat</li>
            </ol>
        </div>
    </div>
    <div class="novy-clanek-input">
        <label for="novy-clanek-headline">Nadpis: </label>
        <input type="text" name="headline" id="novy-clanek-headline">
    </div>
    <div class="novy-clanek-input">
        <label for="novy-clanek-categories">Kategorie:</label>
        <select name="categories" id="novy-clanek-categories">
            <option value="null">Nezařazeno</option>
            <?php
                require_once $_SERVER["DOCUMENT_ROOT"]."/static/php/categories.php";
                $print_categories = function ($categories, $depth=0)
                {
                    global $db, $print_categories;

                    foreach ($categories as $item => $value)
                    {
                        $query = $db->fetch_one("SELECT * FROM kategorie WHERE id=?", [$item]);
                        //echo $name;
                        echo "<option value=\"$query[0]\">".str_repeat("&nbsp;", $depth)."$query[2]</option>";
                        $print_categories($categories[$item], $depth+1);
                    }
                };
                $print_categories(get_categories());
            ?>
        </select>
    </div>
    <div class="novy-clanek-input">
        <textarea name="content" id="novy-clanek-content" cols="30" rows="10"></textarea>
    </div>
    <div class="novy-clanek-input">
        <label for="novy-clanek-sources">Zdroje:</label>
        <br>
        <textarea name="sources" id="novy-clanek-sources" cols="30" rows="1"></textarea>
    </div>
    <div class="novy-clanek-input">
        <button id="novy-clanek-send" onclick="novy_clanek()">Odeslat článek</button>
    </div>
</div>
<?php include_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>