<?php
    require "include/dbconnect.php";
    require "main-head.php";
    require "main-header.php";
    build_head("PostHub", ["navbar", "user-header", "change-pw"]);
    build_header(2);
?>

<div class="container change-pw">
    <div class="user-header">
        <form action="settings.php" name="back">
            <button id="back">&larr; Zurück</button>
        </form>
        <h1>Passwort ändern</h1>
    </div>
    <div id="change-pw-content">
        <?php
        switch ($_GET["err"]) {
            case "wrongPw":
                echo "<p class='msg-error'>Falsches Passwort!</p>";
                break;
            case "noMatch":
                echo "<p class='msg-error'>Die Passw&ouml;rter stimmen nicht &uuml;berein</p>";
                break;
        }
        ?>
        <form action="include/change-pw-process.php" method="POST">
            <label for=""><input type="password" name="pw_old" placeholder="Altes Passwort" required minlength="5"></label>
            <label for=""><input type="password" name="pw_new_1" placeholder="Neues Passwort" required minlength="5"></label>
            <label for=""><input type="password" name="pw_new_2" placeholder="Neues Passwort wiederholen" required minlength="5"></label>
            <button id="submit">&Auml;ndern</button>
        </form>
    </div>

</div>

<?php
require "main-footer.php";
?>