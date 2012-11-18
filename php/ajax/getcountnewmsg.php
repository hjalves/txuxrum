<?php
    require_once('../include/include.php');

    $userid = $_SESSION['userid'];

    if (!$userid) {
        echo "0";
        exit();
    }


    echo sql_countnewmsg($userid);
?>
