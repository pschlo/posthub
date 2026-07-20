<?php

function print_posts($result) {
    session_start();
    echo "\n<ul class=post>";
    $c = 0;
    while($row = mysqli_fetch_array($result)) {
        $c++;
        echo "\n<li>";
        $text = $row["text"];
        echo "\n<h3>".$row["title"].'</h3>';
        if (strlen($text) > 200 or substr_count($text, "\n") > 5) {
            echo "\n".'<button class="more-button" onclick="myFunction(\'' . $c . '\')" id="' . $c . '">+ Mehr anzeigen</button>';
        }
        echo "\n".'<input type=hidden name="'.$row["author_id"].'">';
        $timestamp_date = date("d.m.Y", strtotime($row["timestamp"]));
        $timestamp_time = date("H:i", strtotime($row["timestamp"]));
        echo "\n".'<h4>ver&ouml;ffentlicht von <a href="user-profile.php?userId='.$row["user_id"].'">'
            .$row["prename"].' '.$row["surname"].'</a> am '.$timestamp_date.' um '.$timestamp_time.' Uhr</h4>';

        $exploded_text = explode("\n", $text);
        $exploded_trimmed_1 = array_slice($exploded_text, 0, 5);
        $part_1 = implode("\n", $exploded_trimmed_1);
        $exploded_trimmed_2 = array_slice($exploded_text, 5);
        $part_2 = implode("\n", $exploded_trimmed_2);

        if (substr_count($text, "\n") > 5 and strlen($part_1) <= 200) {
            $text = htmlentities($part_1). '<span id="' . $c . '_dots">...</span><span style="display: none;" id="' . $c . '_more">' .
                htmlentities($part_2) . '</span>';
        }
        elseif (substr_count($text, "\n") > 5 or strlen($text) > 200) {
            $text = htmlentities(substr($text, 0, 200)) . '<span id="' . $c . '_dots">...</span><span style="display: none;" id="' . $c . '_more">' .
                htmlentities(substr($text, 200)) . '</span>';
        } else {
            $text = htmlentities($text);
        }
        echo "\n" . '<p>' . nl2br($text) . '</p>';

        if ($row["author_id"] == $_SESSION["user_id"]) {
            echo "\n".'
                       <form action="include/delete.php" method="POST">
                       <input type="hidden" name="timestamp" value="'.$row["timestamp"].'">
                       <button class="btn-delete"></button>
                       </form>';
        }
        echo "\n</li>";
    }
    if ($c == 0) {
        echo '<p class="no_posts">Keine Beitr&auml;ge vorhanden</p>';
    }

    echo "\n</ul>\n</div>";
    return $c;
}