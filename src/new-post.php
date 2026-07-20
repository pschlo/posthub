<?php
    require "main-head.php";
    require "main-header.php";
    build_head("PostHub", ["new-post", "navbar"]);
    build_header(2);
?>

<div class="container">
<h1>Beitrag erstellen</h1>
    <?php
        if (isset($_GET["err"])) {
            switch ($_GET["err"]) {
                case "emptyInput":
                    echo '<p class=msg-error>Bitte fülle alle Felder aus!</p>';
                    break;
                default:
                    echo '<p class=msg-error>'.$_GET["err"].'</p>';
            }
        }
    ?>
<form action="include/post-process.php" method="POST" id="new-post">
    <label for="text"></label>
    <label><input required type="text" placeholder="Titel" id="title" name="title"></label>
    <textarea required name="text" id="text" cols="100" rows="10" minlength="5"></textarea>
    <button type="submit" name="newpost-submit">Teilen</button>
</form>
</div>
<?php
    require "main-footer.php";
?>
