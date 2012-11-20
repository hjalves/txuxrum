<?php
    require_once('../include/include.php');

    $userid = $_SESSION['userid'];

    if (!$userid) {
        exit();
    }

    if (sql_countnewmsg($userid) > 0) {
        $readtime = sql_update_setreadtime_all($userid);
        $result = sql_message_getnew($userid, $readtime);
        while ($row = pg_fetch_row($result, null))
                vf_printmessage($row[0], $row[1], $row[2], $row[3], $row[4]);
    }
    else
        echo "";

?>
