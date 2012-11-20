<?php
    require_once('../include/include.php');

    $user = $_GET['user'];

    $result = sql_get_user_suggestions($user);
    
    while ($row = pg_fetch_row($result, null))
        echo "<option value=\"$row[0]\">";

?>
