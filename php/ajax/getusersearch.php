<?php
    require_once('../include/include.php');

    $user = $_GET['user'];

    /*if (!$user) {
        exit();
    }*/

    $query = 'SELECT username FROM users WHERE username ILIKE $1 ORDER BY username';
    $result = pg_query_params($query, array("$user%"));
    while ($row = pg_fetch_row($result, null))
                echo "<option value=\"$row[0]\">";

?>
