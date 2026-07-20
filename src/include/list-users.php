<?php

function list_users($result) {
    echo '<ul class="user-search">';
    $c = 0;
    while($row = mysqli_fetch_array($result)) {
        $c++;
        echo '
        <a href="'.'user-profile.php?userId='.$row["user_id"].'">
            <li>
                <img src="img/person_icon_orange.png" height="40">'.$row["surname"].", ".$row["prename"].'
            </li>
        </a>';
    }
    echo '</ul>';
    return $c;
}