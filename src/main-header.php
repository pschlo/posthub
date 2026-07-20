<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: index.php");
        exit();
    }

    function build_header($mark)
    {
        ?>

<body>
    <header>
        <h1 class="container"><a href="main-page.php"><img src="img/logo_grey.png" alt=""></a></h1>
    </header>
    <nav class="nav">
        <div class="container">
                <?php
                echo '<label>Eingeloggt als '.$_SESSION["prename"].' '.$_SESSION["surname"].'</label>';
                if ($mark == 1) {
                    echo '<a class="nav-active" href="main-page.php">Start</a>';
                } else {
                    echo '<a href="main-page.php">Start</a>';
                }
                if ($mark == 2) {
                    echo '<a class="nav-active" href="user-profile.php?userId='.$_SESSION["user_id"].'">Profil</a>';
                } else {
                    echo '<a href="user-profile.php?userId='.$_SESSION["user_id"].'">Profil</a>';
                }
                if ($mark == 3) {
                    echo '<a class="nav-active" href="user-search.php">Nutzer suchen</a>';
                } else {
                    echo '<a href="user-search.php">Nutzer suchen</a>';
                }
                echo '<a href="include/logout.php">Logout</a>';
                ?>

        </div>
    </nav>
<?php
    }
?>
