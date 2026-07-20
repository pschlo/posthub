<?php
    require "main-head.php";
    build_head("PostHub", ["user-profile", "print-posts", "navbar", "user-header"]);
    require "main-header.php";
    require "include/dbconnect.php";
    require "include/print-posts.php";

    global $dbc;
    if (!isset($_GET["userId"])) {
        header("Location: user-search.php");
        exit();
    }

    $user_id = $_GET["userId"];
    if ($user_id == $_SESSION["user_id"]) {
        build_header(2);
    } else {
        build_header(3);
    }


    $sql = "SELECT * FROM users WHERE user_id=?";
    $stmt = mysqli_stmt_init($dbc);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error";
        // header("Location:");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    $sql = "SELECT * FROM following WHERE user_id=? AND following_id=?";
    $stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $sql) or die("error");
    mysqli_stmt_bind_param($stmt, "ii", $_SESSION["user_id"], $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);

if ($userdata = mysqli_fetch_assoc($result)) {?>
    <div class="container user-header">
    <?php if ($userdata["user_id"] != $_SESSION["user_id"]) { ?>
        <form action="user-search.php" name="back">
            <button id="back">&larr; Zurück</button>
        </form>
        <h1>
            <img src="img/person_icon_orange.png" height="50">
            <?php
            echo $userdata["prename"].' '.$userdata["surname"].'';
            if ($num_rows > 0) {
                ?>

            <form action="include/unfollow.php" method="POST" name="follow_unfollow">
                <input type="hidden" name="following_id" value="<?=$user_id?>">
                <button type="submit" name="follow">− Nicht mehr folgen</button>
            <?php } else { ?>

            <form action="include/follow.php" method="POST" name="follow_unfollow">
                <input type="hidden" name="following_id" value="<?=$user_id?>">
                <button type="submit" name="unfollow">+ Folgen</button>
            <?php }
            ?></form>
        </h1>
        <?php } else { ?>

        <h1>
            <img src="img/person_icon_orange.png" height="50">
            Mein Profil
            <form action="settings.php" class="form-settings">
                <button></button>
            </form>
        </h1>
        <?php } ?>

    </div>
<?php } ?>

<table class="container" id="user-table">
    <tr>
        <td id="user-posts">
            <?php
                if (isset($_GET["action"])) {
                    switch ($_GET["action"]) {
                        case "post-succ":
                            echo '<p class="msg-succ">Beitrag geteilt!</p>';
                            break;
                        case "del-succ":
                            echo '<p class="msg-succ">Beitrag gelöscht!</p>';
                            break;
                    }
                }
            ?><div class='post-head'>
                <h2>Beitr&auml;ge</h2><?php
                if ($userdata["user_id"] == $_SESSION["user_id"]) { ?>

                    <form action="new-post.php" name="new-post" class="new-post-form">
                        <button>Beitrag erstellen</button>
                    </form><?php } ?>

            </div>

                <?php
                $sql = "SELECT posts.*, users.* FROM posts JOIN users ON posts.author_id = users.user_id WHERE author_id=? ORDER BY posts.timestamp DESC";
                $stmt = mysqli_stmt_init($dbc);
                mysqli_stmt_prepare($stmt, $sql) or die("error");
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $c = print_posts($result);

            ?>

        </td>

        <td id="user-info">
            <div>
                <h2>Daten</h2>
                <?php
                $sql = "SELECT * FROM following WHERE following_id=?";
                $stmt = mysqli_stmt_init($dbc);
                mysqli_stmt_prepare($stmt, $sql) or die("error");
                mysqli_stmt_bind_param($stmt, "i",$user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $follower = mysqli_stmt_num_rows($stmt);
                ?><div class=follow-list_click>
                    <p>Abonnenten: <?=$follower?></p>
                    <a href="show-followers.php?userId=<?=$user_id?>">Anzeigen</a>
                </div>
                <?php
                $sql = "SELECT * FROM following WHERE user_id=?";
                $stmt = mysqli_stmt_init($dbc);
                mysqli_stmt_prepare($stmt, $sql) or die("error");
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $following = mysqli_stmt_num_rows($stmt);
                ?><div class=follow-list_click>
                    <p>Abonniert: <?=$following?></p>
                    <a href="show-following.php?userId=<?=$user_id?>">Anzeigen</a>
                </div>
                <p>Beitr&auml;ge: <?=$c?></p>
                <?php
                $birthdate_new = date("d.m.Y", strtotime($userdata["birthdate"]));
                ?><p>Geburtstag: <?=$birthdate_new?></p>
                <?php
                $sex = "none";
                switch ($userdata["sex"]) {
                    case "m": $sex="männlich"; break;
                    case "f": $sex="weiblich"; break;
                    case "d": $sex="divers"; break;
                }
                ?><p>Geschlecht: <?=$sex?></p>
            </div>
        </td>
    </tr>
</table>

<?php
require "main-footer.php";
?>

