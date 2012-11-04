<?php /* Index file - chat rooms list */
    require_once('dbauth.php');
    require('varfunc.php');
    require('sqlqry.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
        <font size="1px" />
        <LINK href="gangnamstyle.css" rel="stylesheet" type="text/css">
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
                                $result = sql_query_chatrooms();
                                while ($line = pg_fetch_array($result, null, PGSQL_NUM)) {
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
