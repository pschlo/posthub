<?php
if (isset($_POST["login-submit"])) {

    global $dbc;
    require 'dbconnect.php';

    $email = $_POST["email"];
    $password = $_POST["password"];

    // check if every input was filled
    if (empty($email) or empty($password)) {
        header("Location: ../index.php?loginErr=emptyInput");
        exit();
    }

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $sql) or die("error");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);
        if ($pwdCheck == false) {
            header("Location: ../index.php?loginErr=wrongPwd");
            exit();
        } elseif ($pwdCheck == true) {
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['prename'] = $row['prename'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['email'] = $row['email'];
            header("Location: ../main-page.php");
            exit();
        }
    } else {
        header("Location: ../index.php?loginErr=unknownMail");
        exit();
    }
}