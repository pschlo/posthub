<?php

if (!isset($_POST["following_id"])) {
    header("Location: ../main-page.php");
    exit();
}
session_start();
require "dbconnect.php";
global $dbc;
$following_id = $_POST["following_id"];

$sql = "INSERT INTO following (user_id, following_id) VALUES (?, ?)";
$stmt = mysqli_stmt_init($dbc);
if (!mysqli_stmt_prepare($stmt, $sql)){
    echo "Fehler";
}
mysqli_stmt_bind_param($stmt, "ii", $_SESSION["user_id"], $following_id);
mysqli_stmt_execute($stmt);

header("Location: ../user-profile.php?userId=".$following_id);