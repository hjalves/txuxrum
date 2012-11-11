<?php /* Profile viewer/editer */
    require_once('include.php');
// $username, $name, $sex, $mail, $location, $birthday, $agemin, $agemax, $bithage
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
                                vf_printsearchprofile($_GET["sp_u"],
                                                      $_GET["sp_n"],
                                                      $_GET["sp_s"],
                                                      $_GET["sp_m"],
                                                      $_GET["sp_l"],
                                                      $_GET["sp_d"],
                                                      $_GET["sp_amin"],
                                                      $_GET["sp_amax"],
                                                      $_GET["sp_birthage"]);

echo "<div class=\"textframe profile-profile-main\">";
                                vf_printsearchheader();
                                while ($line = pg_fetch_row($result, null)) {
                                    vf_printsearchresult($line[0], $line[1], $line[2], $line[3]);
                                }
                            ?>
                            </div>
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
