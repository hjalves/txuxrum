<?php /* Chat room */
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
                                $roomid = $_GET["thread"];
                                $result = sql_query_chatroom($roomid);
                                $row = pg_fetch_row($result, null);
                                vf_printchatheader($row[0], $row[1]);
                                
                                if ($_POST["text"]) {
                                    $text = $_POST["text"];
                                    $userid = $_SESSION['userid'];
                                    sql_post_message($userid, $roomid, $text);
                                }
                            ?>
                            

                            <?php
                                $roomid = $_GET["thread"];
                                $result = sql_query_messages($roomid);
                                while ($line = pg_fetch_row($result, null)) {
                                    vf_printchatmsg($line[0], $line[1], $line[2]);
                                }
                                
                                $roomid = $_GET["thread"];
                                vf_printchatroompostform($roomid); 
                            ?>

                            
                            <?php
                                vf_printchatpanel()
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
