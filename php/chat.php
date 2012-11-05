<?php /* Chat room */
    require_once('dbauth.php');
    require('varfunc.php');
    require('sqlqry.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
        <font size="1px" />
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
                                $roomid = $_GET["thread"];
                                $result = sql_query_chatroom($roomid);
                                $row = pg_fetch_row($result, null);
                                vf_printchatheader($row[0], "Op op op oppa gangnam style.");
                            ?>
                            
                            <div class="chatroom-posts">
                            <?php  
                                $roomid = $_GET["thread"];
                                $result = sql_query_messages($roomid);
                                while ($line = pg_fetch_row($result, null)) {
                                    vf_printchatmsg($line[0], $line[1], $line[2]);
                                }
                                
                                vf_printchatroompostform(); 
                            ?>
                            </div>
                            
                            <?php
                                vf_printchatroompanel()
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
