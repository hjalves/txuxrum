<?php /* Chat room */
    require_once('include/include.php');

    $userid = $_SESSION['userid'];
    $roomid = $_GET["thread"];

    /* post new post into chatroom */
    if ($_POST["post"] && $_SESSION['userid']) {
        $text = $_POST["text"];
        sql_post_message($userid, $roomid, $text);
    }

    /* edit title and description */
    // TODO - mudar a form, verificar o usar owner
    if ($_POST["title"]) {
        $title = $_POST["title"];
        $result = sql_edit_title($userid, $roomid, $title);
    }

    if ($_POST["description"]) {
        $description = $_POST["description"];
        sql_edit_description($userid, $roomid, $description);
    }

    /* get title and description */
    $result = sql_query_chatroom($roomid);
    $rows = pg_fetch_row($result, null);
    $title = $rows[0];
    $description = $rows[1];
    $owner = $rows[2];
    $date = $rows[3];
    /* get chatroom's messages */
    $resmsgs = sql_query_messages($roomid);

?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader($title, $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printchatheader($title, $description);

            while ($line = pg_fetch_row($resmsgs, null))
                vf_printchatmsg($line[0], $line[1], $line[2]);

            vf_printchatpost();
            vf_printchatpanel($title, $description, $owner, $date);
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
