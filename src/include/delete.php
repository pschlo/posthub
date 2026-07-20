<?php

session_start();
require "dbconnect.php";
global $dbc;

if (!isset($_POST["timestamp"])) {
    header("Location: ../main-page.php");
    exit();
}

$sql = "DELETE FROM posts WHERE timestamp=? AND author_id=?";
$stmt = mysqli_stmt_init($dbc);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "error";
    // header("Location: ../index.php?loginErr=sqlError&email=$email");
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $_POST["timestamp"], $_SESSION["user_id"]);
if (!mysqli_stmt_execute($stmt)) {
    echo "error";
    exit();
}

header("Location: ../user-profile.php?userId=".$_SESSION["user_id"].'&action=del-succ');