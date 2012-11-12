<?php /* Chat room */
    require_once('include/include.php');
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
            $roomid = $_GET["thread"];
            $result = sql_query_chatroom($roomid);
            $row = pg_fetch_row($result, null);
            vf_printchatheader($row[0], $row[1]);

            if ($_POST["text"]) {
                $text = $_POST["text"];
                $userid = $_SESSION['userid'];
                sql_post_message($userid, $roomid, $text);
            }

            $roomid = $_GET["thread"];
            $result = sql_query_messages($roomid);
            while ($line = pg_fetch_row($result, null)) {
                vf_printchatmsg($line[0], $line[1], $line[2]);
            }

            $roomid = $_GET["thread"];
            vf_printchatpost(); 

            vf_printchatpanel();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
