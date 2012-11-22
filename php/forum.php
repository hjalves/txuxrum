<?php /* Forum - chat rooms list */
    require_once('include/include.php');

    /* new topic */
    if ($_POST["newtopic"] && $_SESSION["userid"] && $_POST["title"])
        sql_new_topic($_SESSION["userid"], $_POST["title"], $_POST["description"]);

    /* pagination - set $selected >= 1 */
    $selected = $_GET['page'];
    if ($selected < 1)
        $selected = 1;

    $userid = $_SESSION["userid"];
    $owner = $_GET["user"];
    $title = $_GET["title"];

    /* get forum threads */
    $reschatrooms = sql_query_chatrooms($userid, $selected - 1, $title, $owner);

    /* get max pages */
    $maxpages = sql_get_chatrooms_pages($userid, $title, $owner);

    /* check page selected out of bounds */
    if ($selected > $maxpages && $maxpages>=1) {
        $$_GET["page"] = $maxpages;
        $url = http_build_query($$_GET);
        header("Location: ?$url");
    }
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

            vf_printchatlistheader();
            while ($row = pg_fetch_row($reschatrooms, null))
                vf_printchatitem($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);

            vf_printchatlistfooter($maxpages, $selected);

            vf_printcreatethread();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
