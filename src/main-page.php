 <?php
    require "include/print-posts.php";
    require "main-head.php";
    build_head("PostHub", ["main-page", "print-posts", "navbar"]);
    require "main-header.php";
    build_header(1);
    ?>

    <section class="container">
        <p>Willkommen, <?= $_SESSION['prename']?>!</p>
    </section>
    <article class="container">
        <div class="post-head">
            <h2>Beitr&auml;ge</h2>
            <form action="new-post.php" name="new-post" class="new-post-form">
                <button>Beitrag erstellen</button>
            </form>
        </div>
        <div class="post">
            <?php
                global $dbc;
                require "include/dbconnect.php";

                $sql = "
                SELECT
                    posts.text,
                    posts.timestamp,
                    posts.title,
                    users.prename,
                    users.surname,
                    users.user_id
                FROM posts
                JOIN users ON
                    posts.author_id = users.user_id
                WHERE author_id IN
                (
                    SELECT
                        following_id
                    FROM following
                    WHERE
                        user_id = ?
                    )
                ORDER BY
                    timestamp DESC";
                $stmt = mysqli_stmt_init($dbc);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Fehler";
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                print_posts($result);
            ?>

        </div>
    </article>

<?php
    require "main-footer.php";
?>