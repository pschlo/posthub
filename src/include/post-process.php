<?php
session_start();
global $dbc;
require "dbconnect.php";

if (!isset($_POST["text"]) or !isset($_POST["title"])) {
    header("Location: ../main-page.php");
    exit();
}

$text = $_POST["text"];
$title = $_POST["title"];

if (empty($text) or empty($title)) {
    header("Location: ../new-post.php?err=emptyInput");
    exit();
}

$sql = "INSERT INTO posts (timestamp, author_id, title, text) VALUES (NOW(), ?, ?, ?)";
$stmt = mysqli_stmt_init($dbc);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "error";
    // header("Location: ../index.php?loginErr=sqlError&email=$email");
    exit();
}

mysqli_stmt_bind_param($stmt, "sss", $_SESSION["user_id"], $title, $text);
if (!mysqli_stmt_execute($stmt)) {
    echo "error";
    exit();
}

header('Location: ../user-profile.php?userId=' . $_SESSION["user_id"].'&action=post-succ');
