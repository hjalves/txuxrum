<?php /* Forum - chat rooms list */
    require_once('include/include.php');

    $selected = $_GET['page'];
    if ($selected < 1)
        $selected = 1;
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
            vf_printsearchbox($_GET["sb_usr"], $_GET["sb_tit"]);

            if ($_GET["sb_usr"] || $_GET["sb_tit"]) {
                $result = sql_query_chatrooms($_GET["sb_usr"], $_GET["sb_tit"], $selected - 1);
            }
            else {
                $result = sql_query_chatrooms($selected - 1);
            }
            vf_printchatlistheader();
            while ($line = pg_fetch_row($result, null))
                vf_printchatitem($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7]);
            vf_printchatlistfooter(sql_get_chatrooms_pages(), $selected);
            vf_printcreatethread();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
