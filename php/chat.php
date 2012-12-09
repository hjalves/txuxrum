<?php /* Chat room */
    require_once('include/include.php');

    $userid = $_SESSION['userid'];
    $roomid = $_GET["thread"];


    /* post new post into chatroom */
    if ($_POST["post"] && $_SESSION['userid']) {
        $text = $_POST["text"];
        $result = sql_post_message($userid, $roomid, $text);
        /* TODO: Verifica se o post foi bem efetuado */
        $msgid = pg_fetch_result($result, 0);

        /* send attachments */
        if ($_FILES["files"]) {
            for ($filei = 0; $filei < count($_FILES["files"]['name']); $filei++) {
                if ($_FILES["files"]["error"][$filei])
                    break;
                $filename = $_FILES["files"]['name'][$filei];
                $filetype = $_FILES["files"]['type'][$filei];
                $filepath = $_FILES["files"]['tmp_name'][$filei];
                $filesize = $_FILES["files"]['size'][$filei];
                //echo $filei, $filename, $filetype, $filepath, $filesize, " . ";
                sql_attach_document($msgid, $filename);
            }
            //echo "Number of files i:", $filei;
        }
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

    #fechar o topico
    if ($_POST["close"]) {
        sql_close_chatroom($roomid);
    }

    if ($_POST["open"]) {
        sql_open_chatroom($roomid);
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

    # ratings
    if ($_POST["rating"]) {
        switch ($_POST["rating"]) {
            case 'no':      $rating_value = 0;      break;
            case 'maybe':   $rating_value = 1;      break;
            case 'yes':     $rating_value = 2;      break;
            default:        $rating_value = NULL;   break;
        }
        sql_update_rating($userid, $roomid, $rating_value);
    }

    /* get chatroom info */
    $result = sql_query_chatroom($userid, $roomid);
    if (pg_num_rows($result) > 0) {
        $rows = pg_fetch_row($result, null);
        $title = $rows[0];
        $description = $rows[1];
        $owner = $rows[2];
        $date = $rows[3];
        $reading = $rows[4];
        $posting = $rows[5];
        $rating = $rows[6];
        $closed = $rows[7];
        $canpost = $rows[8];
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

            vf_printinfotopic($title, $description, $owner, $date, $reading, $posting, $rating, $closed, $canpost);
            vf_printratetopic($rating);
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
