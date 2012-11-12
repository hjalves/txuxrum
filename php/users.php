<?php /* Profile viewer/editer */
    require_once('include/include.php');

    if ($_GET['search']) {
        $result = sql_search_users($_GET["sp_u"],
                                   $_GET["sp_n"],
                                   $_GET["sp_s"],
                                   $_GET["sp_m"],
                                   $_GET["sp_l"],
                                   $_GET["sp_d"],
                                   $_GET["sp_amin"],
                                   $_GET["sp_amax"],
                                   $_GET["sp_birthage"]);
    }
    else
        $result = sql_query_users();
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
            vf_printsearchprofile($_GET["sp_u"],
                                  $_GET["sp_n"],
                                  $_GET["sp_s"],
                                  $_GET["sp_m"],
                                  $_GET["sp_l"],
                                  $_GET["sp_d"],
                                  $_GET["sp_amin"],
                                  $_GET["sp_amax"],
                                  $_GET["sp_birthage"]);

            vf_printsearchheader();
            while ($line = pg_fetch_row($result, null)) {
                vf_printsearchresult($line[0], $line[1], $line[2], $line[3]);
            }
            vf_printsearchfooter();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
