<?php require_once $_SERVER["DOCUMENT_ROOT"]."/top.php" ?>
<?php
    $user = $db->fetch_assoc("SELECT * FROM uzivatele WHERE id=?", [$_GET["id"]]);
?>
<h1>Profil <?php echo $user["username"] ?></h1>
<img src="/static/users/profile_img/<?php echo $user["id"] ?>.png" alt="pfp" width="64">
<p><?php echo $user["bio"] ?></p>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/bottom.php" ?>