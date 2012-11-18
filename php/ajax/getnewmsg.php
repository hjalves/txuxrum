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

    /* functions */
    function sql_message_getnew($userid, $readtime) {
        $query = '  SELECT CASE WHEN privatemessages.receiverid = $1 THEN \'rec\'
                                ELSE \'sent\' END "direction",
                           CASE WHEN privatemessages.receiverid = $1 THEN senders.username
                                ELSE receivers.username END,
                           privatemessages.msgtext,
                           To_char(privatemessages.sendtime, \'DD-Mon, HH24:MI:SS\'),
                           To_char(privatemessages.readtime, \'DD-Mon, HH24:MI:SS\')
                    FROM   privatemessages
                    LEFT JOIN users "receivers"
                           ON privatemessages.receiverid = receivers.userid
                    LEFT JOIN users "senders"
                           ON privatemessages.senderid = senders.userid
                    WHERE  (senderid = $1 OR receiverid = $1) AND 
                           (privatemessages.sendtime < current_timestamp) AND
                           (privatemessages.readtime = $2)
                    ORDER BY sendtime DESC';

        $result = pg_query_params($query, array($userid, $readtime)) or die('Query failed: ' . pg_last_error());
        return $result;
    }
?>
