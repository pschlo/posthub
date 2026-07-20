<?php
    require "main-head.php";
    build_head("PostHub - Anmelden oder Registrieren", ["index"]);
?>
<body>
    <div id="side-1">
        <div class="container">
            <a href="index.php"><img src="img/logo_2.png" alt=""></a>
            <form action="include/login.php" method="POST" id="login-form">
                <?php
            $email = "";
            if (isset($_GET["loginErr"])) {
                if (isset($_GET["email"])) $email = $_GET["email"];
            }

            if (isset($_GET["loginErr"])) {
                switch ($_GET["loginErr"]) {
                    case "wrongPwd":
                        echo "<p class='msg-error'>Falsches Passwort!</p>";
                        break;
                    case "emptyInput":
                        echo "<p class='msg-error'>Bitte E-Mail-Adresse und Passwort eingeben!</p>";
                        break;
                    case "sqlError":
                        echo "<p class='msg-error'>Datenbank-Fehler</p>";
                        break;
                    case "unknownMail":
                        echo "<p class='msg-error'>Diese E-Mail-Adresse ist nicht registriert!</p>";
                        break;
                    default:
                        echo "<p class='msg-error'>".$_GET["loginErr"]."</p>";
                }
            }
            ?><label><input required type="email" value="<?=$email?>" name="email" placeholder="E-Mail"></label>
                <label><input required type="password" name="password" placeholder="Passwort"></label>
                <button type="submit" name="login-submit">Anmelden</button>
            </form>
            <?php
            if (isset($_GET["action"])) {
                switch($_GET["action"]) {
                    case "logout-succ":
                        echo "<p class='msg-succ'>Du wurdest ausgeloggt!</p>";
                        break;
                }
            }
            ?>

        </div>
    </div>
    <div id="side-2">
        <div class="container">
            <?php
                session_start();
                if (isset($_SESSION["user_id"])) {
                    header("Location: main-page.php");
                    exit();
                }
            ?><h1>Willkommen auf PostHub!</h1>
            <h2 id="h-intro">Registriere dich jetzt und werde Teil der gr&ouml;ßten Community der Welt!</h2>
            <form action="include/signup.php" method="POST" id="register-form">
                <?php
                if (isset($_GET["signErr"])) {
                    switch ($_GET["signErr"]) {
                        case "mailTaken":
                            echo "<p class='msg-error'>Diese E-Mail-Adresse ist bereits registriert!</p>";
                            break;
                        case "sqlError":
                            echo "<p class='msg-error'>Datenbank-Fehler</p>";
                            break;
                        case "emptyInput":
                            echo "<p class='msg-error'>Bitte alle Felder ausfüllen!</p>";
                            break;
                        case "noMatch":
                            echo "<p class='msg-error'>Die Passw&ouml;rter stimmen nicht &uuml;berein</p>";
                            break;
                        case "tooShort":
                            echo "<p class='msg-error'>Bitte w&auml;hle ein Passwort, das mindestens 5 Zeichen lang ist</p>";
                            break;
                        case "invalidMail":
                            echo "<p class='msg-error'>Diese E-Mail-Adresse ist ung&uuml;ltig!</p>";
                            break;
                        case "invalidName":
                            echo "<p class='msg-error'>Dieser Name ist ung&uuml;ltig!</p>";
                            break;
                        default:
                            echo "<p class='msg-error'>".$_GET["signErr"]."</p>";
                    }
                }
                if (isset($_GET["action"])) {
                    if ($_GET["action"] == "signup-succ") {
                        echo "<p class='msg-succ'>Erfolgreich registriert!</p>";
                    }
                }
                    $prename = "";
                    $surname = "";
                    $email = "";
                    $birthdate = "";
                    $sex = "";
                    if (isset($_GET["signErr"])) {
                        if (isset($_GET["prename"])) $prename = $_GET["prename"];
                        if (isset($_GET["surname"])) $surname = $_GET["surname"];
                        if (isset($_GET["email"])) $email = $_GET["email"];
                        if (isset($_GET["birthdate"])) $birthdate = $_GET["birthdate"];
                        if (isset($_GET["sex"])) $sex = $_GET["sex"];
                    }

                ?><label><input required id="prename" type="text" placeholder="Vorname" value="<?=$prename?>" name="prename"></label>
                <label><input required id="surname" name="surname" type="text" value="<?=$surname?>" placeholder="Nachname"></label>
                <label><input required type="email" name="email" value="<?=$email?>" placeholder="E-Mail-Adresse"></label>
                <label><input required type="password" name="password-1" placeholder="Neues Passwort"></label>
                <label><input required type="password" name="password-2" placeholder="Passwort wiederholen"></label>
                <label for="birthdate">Geburtstag</label>
                <input required type="date" name="birthdate" value="<?=$birthdate?>" id="birthdate">
                <label>Geschlecht</label>
                <div id="radiobuttons">
                    <div>
                        <?php if ($sex == "m") {
                            echo '<input type="radio" name="sex" id="male" value="m" checked>';
                        } else {
                            echo '<input type="radio" name="sex" id="male" value="m">';
                        } ?>

                        <label for="male">M&auml;nnlich</label>
                    </div>
                    <div>
                        <?php if ($sex == "f") {
                            echo '<input type="radio" name="sex" id="female" value="f" checked>';
                        } else {
                            echo '<input type="radio" name="sex" id="female" value="f">';
                        } ?>

                        <label for="female">Weiblich</label>
                    </div>
                    <div>
                        <?php if ($sex == "d") {
                            echo '<input type="radio" name="sex" id="diverse" value="d" checked>';
                        } else {
                            echo '<input type="radio" name="sex" id="diverse" value="d">';
                        } ?>

                        <label for="diverse">Divers</label>
                    </div>
                </div>
                <button type="submit" name="signup-submit">Registrieren</button>
            </form>
        </div>
    </div>

<?php
    require "main-footer.php";
?>