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
    if ($_POST["title"])
        sql_edit_title($userid, $roomid, $_POST["title"]);
    #verificar permissoes
    if ($_POST["description"])
        sql_edit_description($userid, $roomid, $_POST["description"]);
    #fechar o topico
    if ($_POST["close"])
        sql_close_chatroom($roomid);
    if ($_POST["open"])
        sql_open_chatroom($roomid);

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
?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader($cr['title'], $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            echo '<div class="textframe">';
            vf_printchatheader($cr);

            if ($cr) {
                echo '<div class="panelframe-left">';

                $messages = sql_query_messages($roomid);
                /* mostra as mensagens e anexos, se houver */
                foreach ($messages as $message) {
                    $attachments = NULL;
                    if ($message["numdocs"] > 0)
                        $attachments = sql_query_documents($message["msgid"]);
                    vf_printchatmsg($message, $attachments);
                }

                /* imprime a caixa para post */
                if ($cr['canpost'] == 't')
                    vf_printchatpost();
                
                echo '</div>';
                
                vf_startchatpanel();
                vf_printinfotopic($cr);
                /* apenas mostra rate topic para users registados */
                if ($userid)
                    vf_printratetopic($cr['rating']);
                /* paineis do owner */
                if ($cr['iamowner'] == 't') {
                    vf_printedittitle($cr['title']);
                    vf_printeditdescription($cr['description']);
                    vf_printeditperm($cr['readingperm'], $cr['writingperm']);
                    vf_printpermissions( sql_query_permissions($roomid) );
                    vf_printclosetopic();
                }
                /* get chatroom permissions */
                vf_endchatpanel();
            }

            echo '</div>';
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
