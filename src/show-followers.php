<?php
    require "main-head.php";
    require "main-header.php";
    require "include/dbconnect.php";
    require "include/list-users.php";
    build_head("PostHub", ["list-users", "navbar", "user-header"]);
    global $dbc;

    if (!isset($_GET["userId"])) {
        header("Location: main-page.php");
        exit();
    }
    $user_id = $_GET["userId"];
    if ($user_id == $_SESSION["user_id"]) {
        build_header(2);
    } else {
        build_header(3);
    }


    $sql = "SELECT *
                FROM users
                WHERE user_id =?
                ORDER BY users.surname DESC";
    $stmt = mysqli_stmt_init($dbc);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error";
        // header("Location:");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $user_result = mysqli_stmt_get_result($stmt);
    $userdata = mysqli_fetch_assoc($user_result);


    $sql = "SELECT *
            FROM users
            WHERE user_id IN (
                SELECT user_id
                FROM following
                WHERE following_id = ?
            )
            ORDER BY users.surname DESC";
    $stmt = mysqli_stmt_init($dbc);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error";
        // header("Location:");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $follow_result = mysqli_stmt_get_result($stmt);

    ?>
    <div class="container">
        <div class="user-header">
            <form action="user-profile.php" name="back">
                <input type="hidden" name="userId" value="<?php echo $user_id; ?>">
                <button id="back">&larr; Zurück</button>
            </form>
    <?php
    if ($_SESSION["user_id"] == $userdata["user_id"]) {
        echo '<h1>Nutzer, die dir folgen</h1>';
    } else {
        echo '<h1>Nutzer, die '.$userdata["prename"].' '.$userdata["surname"].' folgen</h1>';
    }
    ?>

        </div>
    <?php
    $c = list_users($follow_result);
    if ($c == 0) {
        if ($_SESSION["user_id"] == $userdata["user_id"]) {
            echo '<p class="no_posts">Niemand folgt dir</p>';
        } else {
            echo '<p class="no_posts">Niemand folgt '.$userdata["prename"].'</p>';
        }
    }
    ?>

    </div>

<?php
    require "main-footer.php";
?>
