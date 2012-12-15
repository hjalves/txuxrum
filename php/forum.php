<?php /* Forum - chat rooms list */
    require_once('include/include.php');

    /* new topic */
    if ($_POST["newtopic"] && $_SESSION["userid"] && $_POST["title"])
        sql_new_topic($_SESSION["userid"], $_POST["title"], $_POST["description"]);

    /* pagination - set $selected >= 1 */
    $selected = $_GET['page'];
    if (!$selected)
        $selected = 1;

    $userid = $_SESSION["userid"];
    $owner = $_GET["user"];
    $title = $_GET["title"];

    /* get max pages */
    $maxpages = sql_get_chatrooms_pages($userid, $title, $owner);

    /* check page selected out of bounds */
    if (($selected > $maxpages || $selected < 1) && $selected != 1) {
        $_GET["page"] = $selected > $maxpages ? $maxpages : 1;
        $url = http_build_query($_GET);
        header("Location: ?$url");
    }

    /* get forum threads */
    $chatrooms = sql_query_chatrooms($userid, $selected, $title, $owner);
?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader("Forum", $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printsearchbox($user, $title);
            vf_printchatlistheader($chatrooms);
            vf_printchatrooms($chatrooms);
            vf_printchatlistfooter($maxpages, $selected);
            vf_printcreatethread();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
