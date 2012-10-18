<?php /* Chat room */
    require_once('dbauth.php');
    require('varfunc.php');
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
                                vf_printchatheader("An example of a title", "Do you like to kill patatos?");
                            ?>
                            
                            <div class="chatroom-posts">
                            <?php  
                                vf_printchatmsg("Username", "19 Oct 2012", "Die patato!");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                
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
