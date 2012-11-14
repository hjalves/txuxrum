<?php /* Private message */
    require_once('include/include.php');

    $user = $_GET['user'];

    /* send a message */
    if ($_POST["msgsent"]) {
        sql_message_send($_SESSION['userid'], $_POST['to'], $_POST['date'], $_POST['time'], $_POST['text']);
    }

    /* get message list */
    if ($user)
        $resmsgs = sql_message_getchat($_SESSION['userid'], $user);
    else
        $resmsgs = sql_message_get($_SESSION['userid']);
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- TXUXRUM -- ::</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link href="css/gangnamstyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printmsgheader();

            while ($row = pg_fetch_row($resmsgs, null))
                vf_printmessage($row[0], $row[1], $row[2], $row[3], $row[4]);

            vf_printmsgpost($user);

            vf_printmessagepanel($user); 
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
