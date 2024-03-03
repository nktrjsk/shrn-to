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
<h1>Nastavení</h1>
<div id="nastaveni">
    <div id="state-report">
        <h4 id="nastaveni-username-report"></h4>
        <h4 id="nastaveni-uid-report"></h4>
        <h4 id="nastaveni-avatar-report"></h4>
    </div>
    <div class="nastaveni-option">
        <label for="nastaveni-username">Uživatelské jméno: </label>
        <br>
        <input type="text" name="username" id="nastaveni-username" value="<?php echo $_SESSION["username"] ?>">
    </div>
    <div class="nastaveni-option">
        <label for="nastaveni-uid">UID: </label>
        <br>
        <input type="text" name="uid" id="nastaveni-uid" value="<?php echo $_SESSION["uid"] ?>">
    </div>
    <div class="nastaveni-option">
        <label for="nastaveni-avatar">Avatar: </label>
        <br>
        <img src="/static/users/profile_img/<?php echo $_SESSION["id"] ?>.png" alt="avatar_img" id="nastaveni-avatar-img" width="64px" height="64px">
        <br>
        <input type="file" name="avatar" id="nastaveni-avatar" onchange="update_avatar(this)">
    </div>
    <div class="nastaveni-option">
        <button id="nastaveni-submit" onclick="update_settings()">Aktualizovat nastavení</button>
    </div>
</div>

<?php include_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>