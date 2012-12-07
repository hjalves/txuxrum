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

    #verificar permissoes
    if ($_POST["description"]) {
        $description = $_POST["description"];
        sql_edit_description($userid, $roomid, $description);
    }

    // permissao reading e writing - verific permissoes
    if ($_POST["readingperm"] || $_POST["postingperm"]) {
        $perm = NULL;
        if ($_POST["permval"] == 'f' || $_POST["permval"] == 't')
            $perm = $_POST["permval"];
        
        if ($_POST["readingperm"])
            sql_edit_reading_permission($userid, $roomid, $perm);
        else if ($_POST["postingperm"])
            sql_edit_posting_permission($userid, $roomid, $perm);
    }





    # verificar permissoes
    if ($_POST["perm_add"]) {
        $permuser = $_POST["perm_user"];
        $perm = $_POST["perm_value"];

        if ($perm[0] == 'R') $readperm = "t";
        else if ($perm[0] == 'x') $readperm = "f";
        else $readperm = NULL;

        if ($perm[1] == 'W') $writeperm = "t";
        else if ($perm[1] == 'x') $writeperm = "f";
        else $writeperm = NULL;

        sql_update_permission($permuser, $roomid, $readperm, $writeperm);
    }



    /* get title and description */
    $result = sql_query_chatroom($userid, $roomid);

    if (pg_num_rows($result) > 0) {
        $rows = pg_fetch_row($result, null);
        $title = $rows[0];
        $description = $rows[1];
        $owner = $rows[2];
        $date = $rows[3];
        $reading = $rows[4];
        $posting = $rows[5];
        /* get chatroom's messages */
        $resmsgs = sql_query_messages($roomid);
        /* get chatroom permissions */
        $resperm = sql_query_permissions($roomid);
    }

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
            
            vf_startchatpanel();

            vf_printinfotopic($title, $description, $owner, $date, $reading, $posting);
            vf_printratetopic();
            vf_printedittitle($title);
            vf_printeditdescription($description);
            vf_printeditperm($reading, $posting);
            
            vf_printpermissions(pg_fetch_all($resperm));
            vf_printclosetopic();

            vf_endchatpanel();


            echo '<div id="nextSetOfContent"></div>';
            echo '</div>';
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
