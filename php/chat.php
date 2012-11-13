<?php /* Chat room */
    require_once('include/include.php');

    /* get title and description */
    $roomid = $_GET["thread"];
    $result = sql_query_chatroom($roomid);
    $rowchatheader = pg_fetch_row($result, null);

    /* post new post into chatroom */
    if ($_POST["post"]) {
        $text = $_POST["text"];
        $userid = $_SESSION['userid'];
        sql_post_message($userid, $roomid, $text);
    }

    /* get chatroom's messages */
    $resmsgs = sql_query_messages($roomid);

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
            vf_printchatheader($rowchatheader[0], $rowchatheader[1]);

            while ($line = pg_fetch_row($resmsgs, null))
                vf_printchatmsg($line[0], $line[1], $line[2]);

            vf_printchatpost(); 

            vf_printchatpanel();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
