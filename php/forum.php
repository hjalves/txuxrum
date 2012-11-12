<?php /* Forum - chat rooms list */
    require_once('include.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link href="gangnamstyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div align="center">
            <table width="700px" border="0px" cellspacing="0px" cellpadding="0px" class="mainframe">
                <tr>
                    <td>
                        <?php include("header.php"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="bodyframe">

                            <?php
                                vf_printsearchbox($_GET["sb_usr"], $_GET["sb_tit"]);

                                if ($_GET["sb_usr"] || $_GET["sb_tit"]) {
                                    $result = sql_query_chatrooms($_GET["sb_usr"], $_GET["sb_tit"]);
                                }
                                else {
                                    $result = sql_query_chatrooms();
                                }
                                vf_printchatlistheader();
                                while ($line = pg_fetch_row($result, null))
                                    vf_printchatitem($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
                                vf_printchatlistfooter(4, 2);

                                vf_printcreatethread();
                            ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="footer">
                        <?php vf_printfooter(); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        
    </body>
</html>