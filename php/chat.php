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
                // TODO: devia mostrar erros como deve ser
                if ($_FILES["files"]["error"][$filei])
                    break;
                $filename = $_FILES["files"]['name'][$filei];
                $filetype = $_FILES["files"]['type'][$filei];
                $filepath = $_FILES["files"]['tmp_name'][$filei];
                $filesize = $_FILES["files"]['size'][$filei];
                //echo $filei, $filename, $filetype, $filepath, $filesize, " . ";
                move_uploaded_file($filepath, '/home/txux/public_html/uploaded_files/' . $filename);

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
    $cr = sql_query_chatroom($userid, $roomid);
    if ($cr) {
        $title = $cr[0];
        $description = $cr[1];
        $owner = $cr[2];
        $date = $cr[3];
        $reading = $cr[4];
        $posting = $cr[5];
        $rating = $cr[6];
        $closed = $cr[7];
        $canpost = $cr[8];
        $iamowner = $cr[9];
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
            vf_printchatheader($cr);
            
            while ($line = pg_fetch_row($resmsgs, null)) {
                $attachments = NULL;
                if ($line[4]) {
                    $resdocs = sql_query_documents($line[3]);
                    $attachments = pg_fetch_all($resdocs);
                    //vf_printattachments($attachments);
                }
                vf_printchatmsg($line[0], $line[1], $line[2], $attachments);
            }
            
            vf_printchatpost();
            
            vf_startchatpanel();

            vf_printinfotopic($title, $description, $owner, $date, $reading, $posting, $rating, $closed, $canpost, $iamowner);
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
