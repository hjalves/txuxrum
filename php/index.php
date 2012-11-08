<?php /* Index file - chat rooms list */
    require_once('dbauth.php');
    require('varfunc.php');
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
                                vf_printsearchbox();
                                vf_printcreatethread();
                            ?>

                            <?php
                                if (!$_GET["sb_usr"] && !$_GET["sb_tit"])
                                    $result = sql_query_chatrooms();
                                else
                                    $result = sql_query_chatrooms_search($_GET["sb_usr"], $_GET["sb_tit"]);
                                while ($line = pg_fetch_row($result, null)) {
                                 vf_printchatitem($line[0], $line[1], $line[2], $line[3]);
                                }

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
