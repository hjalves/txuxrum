<?php /* Private message */
    require_once('include/include.php');

    /* send a message */
    if ($_POST["msgsent"]) {
        
    }
    
    /* get message list */
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

            vf_printmsgpost();

            vf_printmessagepanel(""); 
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
