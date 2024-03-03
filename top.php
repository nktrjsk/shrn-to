<?php
if (!isset($_SESSION))
{
    session_start();
}
else if (!isset($_SESSION["id"]))
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";
    if (!$db->fetch_one("SELECT * FROM uzivatele WHERE id=?", [$_SESSION["id"]]))
    {
        session_start();
        session_unset();
        session_regenerate_id();
    }
}

?>
<!DOCTYPE html>
<html lang="cs" theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/static/js/jquery-3.6.0.min.js"></script>
    <script src="/static/js/index.js"></script>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="shortcut icon" href="/static/img/logo_short.png" type="image/x-icon">
    <title>Shrň.to</title>
</head>
<body>
    <nav>
        <a href="/" id="nav-logo"></a>
        <a href="/o-nas.html" class="nav-link">O nás</a>
        <div id="links-wrap" login="false">
            <svg id="sipka-svg-link" viewBox="0 0 1080 1080" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
                <g transform="matrix(1,0,0,1,-2247.25,0)">
                    <g transform="matrix(1.05334,0,0,1.05334,-214.342,-33.7585)">
                        <g id="šipka3" serif:id="šipka" transform="matrix(1.20143,0,0,0.563058,-666.385,253.885)">
                            <path d="M2926.5,170L3273,863L2926.5,170L2580,863L2926.5,170Z" style="stroke-width:168.65px;"/>
                        </g>
                    </g>
                </g>
            </svg>
            <div id="links">
                <a href="/novy_clanek" class="nav-link">Napsat článek</a>
            </div>
        </div>
        <div id="profile" login="false">
            <div id="logged">
                <img src="/static/users/profile_img/<?php echo $_SESSION["id"].".png?".time() ?>" alt="profile-img" id="profile-img">
                <div id="user-data">
                    <p id="username" title="<?php echo $_SESSION["username"] ?>"><?php echo $_SESSION["username"] ?></p>
                    <p id="username" title="<?php echo $_SESSION["uid"] ?>">UID: <?php echo $_SESSION["uid"] ?></p>
                </div>
                <svg width="100%" height="100%" class="sipka-svg" opened="false" viewBox="0 0 1080 1080" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
                    <g transform="matrix(1,0,0,1,-2247.25,0)">
                        <g transform="matrix(1.05334,0,0,1.05334,-214.342,-33.7585)">
                            <g id="šipka3" serif:id="šipka" transform="matrix(1.20143,0,0,0.563058,-666.385,253.885)">
                                <path d="M2926.5,170L3273,863L2926.5,170L2580,863L2926.5,170Z" style="stroke-width:168.65px;"/>
                            </g>
                        </g>
                    </g>
                </svg>
                <div id="profile-dropdown">
                    <a class="nav-link" onclick="document.documentElement.setAttribute('theme', document.documentElement.getAttribute('theme') === 'dark' ? 'light' : 'dark')">Změnit motiv</a>
                    <a href="/nastaveni" class="nav-link">Nastavení</a>
                    <a class="nav-link" onclick="logout()">Log out</a>
                </div>
            </div>
            <div id="guest">
                <div id="login-div">
                    <a id="login">Log in</a>
                    <a id="register">Register</a>
                </div>
                <svg width="100%" height="100%" class="sipka-svg" opened="false" viewBox="0 0 1080 1080" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
                    <g transform="matrix(1,0,0,1,-2247.25,0)">
                        <g transform="matrix(1.05334,0,0,1.05334,-214.342,-33.7585)">
                            <g id="šipka3" serif:id="šipka" transform="matrix(1.20143,0,0,0.563058,-666.385,253.885)">
                                <path d="M2926.5,170L3273,863L2926.5,170L2580,863L2926.5,170Z" style="stroke-width:168.65px;"/>
                            </g>
                        </g>
                    </g>
                </svg>
                <div id="profile-dropdown">
                    <a class="nav-link" onclick="document.documentElement.setAttribute('theme', document.documentElement.getAttribute('theme') === 'dark' ? 'light' : 'dark')">Změnit motiv</a>
                </div>
                <div id="login-form" opened="false">
                    <div>
                        <h5>Přihlásit</h5>
                        <h6 id="login-error"></h6>
                        <label for="login-uid">UID: </label>
                        <input type="email" name="uid" id="login-uid">
                        <label for="login-password">Password: </label>
                        <input type="password" name="password" id="login-password">
                        <label for="login-stay-logged">Zůstat přihlášený</label>
                        <input type="checkbox" name="stay-logged" id="login-stay-logged">
                        <button onclick="login()">Přihlásit se</button>
                    </div>
                </div>
                <div id="register-form" opened="false">
                    <div>
                        <h5>Registrovat</h5>
                        <h6 id="register-error"></h6>                   
                        <label for="register-uid">UID: </label>
                        <input type="email" name="uid" id="register-uid" required>
                        <label for="register-password">Password: </label>
                        <input type="password" name="password" id="register-password">
                        <label for="register-password">Repeat password: </label>
                        <input type="password" name="repeat-password" id="register-repeat-password">
                        <button onclick="register()">Registrovat se</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="menu">
        <h3>Kategorie</h3>
        <?php
            require_once $_SERVER["DOCUMENT_ROOT"]."/static/php/categories.php";
            $print_categories = function ($categories, $depth=0) use ($db, &$print_categories)
            {
                echo "<ol>";
                foreach ($categories as $item => $value)
                {
                    $query = $db->fetch_one("SELECT * FROM kategorie WHERE id=?", [$item]);
                    //echo $name;
                    echo "<a href=\"\\kategorie\\$query[2]\">$query[1]</a>";
                    $print_categories($categories[$item], $depth+1);
                }
                echo "</ol>";
            };
            $print_categories(get_categories());
        ?>
    </div>
    <div id="content">