<?php

if (!isset($_POST["signup-submit"])) {
    header("Location: ../index.php");
    exit();
}

global $dbc;
require 'dbconnect.php';

$prename = trim($_POST["prename"]);
$surname = trim($_POST["surname"]);
$email = trim($_POST["email"]);
$password_1 = $_POST["password-1"];
$password_2 = $_POST["password-2"];
$birthdate = $_POST["birthdate"];
$sex = $_POST["sex"];

// check if every input was filled
if (empty($prename) or empty($surname) or empty($email) or empty($password_1) or empty($password_2) or empty($birthdate) or empty($sex)) {
    header("Location: ../index.php?signErr=emptyInput&prename=$prename&surname=$surname&email=$email&birthdate=$birthdate&sex=$sex");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?signErr=invalidMail&prename=$prename&surname=$surname&birthdate=$birthdate&sex=$sex");
    exit();
}
$pattern = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";

if (preg_match($pattern, $prename) or preg_match($pattern, $surname)) {
    header("Location: ../index.php?signErr=invalidName&birthdate=$birthdate&sex=$sex&email=$email");
    exit();
}

if ($password_1 != $password_2) {
    header("Location: ../index.php?signErr=noMatch&prename=$prename&surname=$surname&email=$email&birthdate=$birthdate&sex=$sex");
    exit();
}

if (strlen($password_1) < 5) {
    header("Location: ../index.php?signErr=tooShort&prename=$prename&surname=$surname&email=$email&birthdate=$birthdate&sex=$sex");
    exit();
}

$sql = "SELECT email FROM users WHERE email=?";
$stmt = mysqli_stmt_init($dbc);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    // error
    header("Location: ../index.php?signErr=sqlError&prename=$prename&surname=$surname&email=$email&birthdate=$birthdate&sex=$sex");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    //check if email already registered
    if ($resultCheck > 0) {
        header("Location: ../index.php?signErr=mailTaken&prename=$prename&surname=$surname&birthdate=$birthdate&sex=$sex");
        exit();
    }

    $sql = "INSERT INTO users (prename, surname, email, password, birthdate, sex) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($dbc);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?signErr=sqlError&prename=$prename&surname=$surname&email=$email&birthdate=$birthdate&sex=$sex");
        exit();
    }

    $pwd_hash = password_hash($password_1, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss", $prename, $surname, $email, $pwd_hash, $birthdate, $sex);
    mysqli_stmt_execute($stmt);
    header("Location: ../index.php?action=signup-succ");

    // mysqli_stmt_close($stmt);
    // mysqli_close($dbc);

}