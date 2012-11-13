<?php /* Forum - chat rooms list */
    require_once('include/include.php');

    /* set $selected >= 1 */
    $selected = $_GET['page'];
    if ($selected < 1)
        $selected = 1;

    $user = $_GET["user"];
    $title = $_GET["title"];

    /* get forum threads */
    $reschatrooms = sql_query_chatrooms($selected - 1, $user, $title);

    /* get max pages */
    $maxpages = sql_get_chatrooms_pages($user, $title);
    echo "merda", $maxpages;
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
