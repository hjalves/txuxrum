<?php /* Profile viewer/editer */
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
                                vf_printsearchprofile();
                                vf_printsearchheader();
                                if($_GET["sp_u"] || $_GET["sp_n"] || $_GET["sp_d"] || $_GET["sp_a"] || $_GET["sp_m"] || $_GET["sp_co"] || $_GET["sp_ci"])
                                    $result = sql_search_users($_GET["sp_u"], $_GET["sp_n"], $_GET["sp_d"], $_GET["sp_a"], $_GET["sp_m"], $_GET["sp_co"], $_GET["sp_ci"]);
                                else
                                    $result = sql_query_users();
                                    
                                while ($line = pg_fetch_row($result, null)) {
                                    vf_printsearchresult($line[0], $line[1], $line[2], $line[3]);
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
