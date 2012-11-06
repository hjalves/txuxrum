<?php /* Profile viewer/editer */
    require_once('dbauth.php');
    require('varfunc.php');
    require('sqlqry.php');
    session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
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
                                $username = $_GET["user"];
                                $result = sql_query_user($username);
                                $row = pg_fetch_row($result, null);
                                vf_printprofile($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
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
