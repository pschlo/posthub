<?php
require "main-head.php";
require "main-header.php";
build_head("PostHub", ["navbar", "user-header", "settings"]);
build_header(2);
?>

<div class="container settings">
    <div class="user-header">
        <form action="user-profile.php" name="back">
            <input type="hidden" name="userId" value="<?php echo $_SESSION["user_id"]; ?>">
            <button id="back">&larr; Zurück</button>
        </form>
        <h1><img src="img/settings_large.png" alt="" height="40">Einstellungen</h1>
    </div>
    <?php
    if ($_GET["action"] == "succ") {
        echo "<p class='msg-succ'>Dein Passwort wurde erfolgreich ge&auml;ndert!</p>";
    }
    ?>
    <ul>
        <a href="change-pw.php"><li>Passwort ändern</li></a>
    </ul>
</div>

<?php
require "main-footer.php";
?>
