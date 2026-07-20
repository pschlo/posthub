<?php
require "../main-head.php";
require "dbconnect.php";
global $dbc;
session_start();

if (!isset($_POST["pw_old"]) or !isset($_POST["pw_new_1"]) or !isset($_POST["pw_new_2"])
    or empty($_POST["pw_old"]) or empty($_POST["pw_new_1"]) or empty($_POST["pw_new_2"])) {
    header("Location: ../change-pw.php?err=tooShort");
    exit();
}

$pw_old = $_POST["pw_old"];
$pw_new_1 = $_POST["pw_new_1"];
$pw_new_2 = $_POST["pw_new_2"];

$sql = "SELECT password FROM users WHERE user_id=".$_SESSION["user_id"];
$result = mysqli_query($dbc, $sql);
$result = mysqli_fetch_array($result);

if (!password_verify($pw_old, $result["password"])) {
    header("Location: ../change-pw.php?err=wrongPw");
    exit();
}
if ($pw_new_1 != $pw_new_2) {
    header("Location: ../change-pw.php?err=noMatch");
    exit();
}

$sql = "UPDATE users SET password=? WHERE user_id=?";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("Datenbank-Fehler");
mysqli_stmt_bind_param($stmt, "si", password_hash($pw_new_1,PASSWORD_DEFAULT), $_SESSION["user_id"]);
mysqli_stmt_execute($stmt);
if (mysqli_affected_rows($dbc) == 1) {
    header("Location: ../settings.php?action=succ");
    exit();
} else {
    die("error");
}
