<?php
    require_once('../include/include.php');

    $userid = $_SESSION['userid'];

    if (!$userid) {
        exit();
    }

    $query = 'SELECT count(*) FROM privatemessages WHERE readtime IS NULL AND receiverid = $1';
    $result = pg_query_params($query, array($userid));
    $line = pg_fetch_row($result, null);
    echo $line[0];
?>
