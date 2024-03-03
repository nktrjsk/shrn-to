<?php include_once "./top.php"?>
<h1>Homepage</h1>
<p><?php if (isset($_SESSION["id"])) {echo $_SESSION["id"];} else {echo "ne";} ?></p>
<?php include_once "./bottom.php" ?>