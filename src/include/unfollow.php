<?php

if (!isset($_POST["following_id"])) {
    header("Location: ../main-page.php");
    exit();
}
session_start();
require "dbconnect.php";
global $dbc;
$following_id = $_POST["following_id"];

$sql = "DELETE FROM following WHERE user_id=? AND following_id=?";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("error");
mysqli_stmt_bind_param($stmt, "ii", $_SESSION["user_id"], $following_id);
mysqli_stmt_execute($stmt);

header("Location: ../user-profile.php?userId=".$following_id);