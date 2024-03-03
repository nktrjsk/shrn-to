</div>
<div id="search" type="">
    <div id="search-type">
        <div class="search-type-option">
            <label for="search-type-profile">Profil</label>
            <input type="radio" name="select-type" id="search-type-profile">
        </div>
        <div class="search-type-option">
            <label for="search-type-article">Článek</label>
            <input type="radio" name="select-type" id="search-type-article">
        </div>
    </div>
    <form action="GET" id="profile-form">
        <h4>Profil</h4>
    </form>
    <form action="GET" id="article-form">
        <h4>Článek</h4>
    </form>
</div>
<footer>
    <div id="footer-row-1">
        <a href="/clanky">Všechny články</a>
        <a href="/categories/edit"></a>
    </div>
</footer>
</body>
<script src="/static/js/index.js"></script>
<?php
if (isset($_SESSION["id"]))
{
    echo "<script>login_page();</script>";
}
?>
</html>