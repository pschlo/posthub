<?php
    global $dbc;
    require "main-head.php";
    require "main-header.php";
    require "include/dbconnect.php";
    require "include/list-users.php";
    build_head("PostHub", ["list-users", "navbar", "user-header"]);
    build_header(3);
?>

<div class="container">
<h1>Nutzer suchen</h1>
    <?php
        $sql = "SELECT user_id, prename, surname FROM users WHERE user_id <> ? ORDER BY surname";
        $stmt = mysqli_stmt_init($dbc);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "error";
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (!$result) die("Query Failed.");

        list_users($result);
    ?>
</div>

<?php
    require "main-footer.php";
?>


