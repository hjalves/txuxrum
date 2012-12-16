<?php /* Private message */
require_once('include/include.php');

    $user = $_GET['user'];

    /* send a message */
    if ($_POST["msgsent"]) {
        sql_message_send($_SESSION['userid'], $_POST['to'], $_POST['date'], $_POST['time'], $_POST['text']);
    }

    /* update readtime */
    if (!$user)
        sql_update_setreadtime_all($_SESSION['userid']);
    else
        sql_update_setreadtime_user($_SESSION['userid'], $user);

    /* get message list */
    if ($user)
        $resmsgs = sql_message_getchat($_SESSION['userid'], $user);
    else
        $resmsgs = sql_message_get($_SESSION['userid']);

    if ($_POST["delete"]) {
        sql_delete_message($_POST["pvtmsgid"]);
    }

?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader("Messages", $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printjsgetmsg();
            vf_printmsgheader($_SESSION['userid']);
            
            if ($_SESSION['userid']) {
                while ($row = pg_fetch_row($resmsgs, null))
                    vf_printmessage($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);

                vf_printmsgpost($user);
                vf_printmessagepanel($user);
            } else {
                echo "</div>";
                echo "</div>";
            }
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    
    </body>
</html>
