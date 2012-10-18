<?php /* Index file - chat rooms list */
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
                            <div class="searchbox">
                                <div class="searchbox-inside"> 
                                        Search by
                                        username <input type="text" size="20" class="chatpanel-ulist-addinput" />
                                        and/or topic <input type="text" size="20" class="chatpanel-ulist-addinput" />
                                        <input type="submit" value="search" class="chatpanel-ulist-addbutton" />
                                        or list your topics
                                </div>
                            </div>
                            
                            <?php
                                vf_printchatitem("Exemplo de titulo", "link", "utilizador", "junho");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                vf_printchatheader("title", "example");
                            ?>
                            
                            <div class="chatroom-posts">
                            <?php  
                                
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                vf_printchatmsg("ajsd", "324", "skjfs sf");
                                
                            ?>
                            
                            <div class="postbox">
                                <div class="postbox-inside">
                                    <div class="postbox-text">
                                    <textarea rows="4" cols="50" class="postbox-text-area"></textarea>
                                    </div>
                                    <div class="postbox-attach">
                                        Attach files
                                    </div>
                                    <div class="postbox-submit">
                                        <input type="submit" value="post" class="chatpanel-ulist-addbutton" />
                                    </div>    
                                </div>
                            </div>
                            
                            </div>
                            
                            <div class="chatpanel">
                                <div class="chatpanel-rate">
                                    <div class="chatpanel-rate-title">
                                        Rate this room
                                    </div>
                                    <div class="chatpanel-rate-rate">
                                        No | Maybe | Yes
                                    </div>
                                </div>
                                <div class="chatpanel-ulist">
                                    <div class="chatpanel-ulist-title">
                                        Users in this topic
                                    </div>
                                    <div class="chatpanel-ulist-list">
                                        user1<br>user2
                                    </div>
                                    <div class="chatpanel-ulist-addtitle">
                                        Add new user
                                    </div>
                                    <div class="chatpanel-ulist-add">
                                        <input type="text" size="20" class="chatpanel-ulist-addinput" />
                                        <input type="submit" value="add" class="chatpanel-ulist-addbutton" />
                                    </div>
                                </div>
                                <div class="chatpanel-close">
                                    <div class="chatpanel-close-title">
                                        Close this topic
                                    </div>
                                    <div class="chatpanel-close-div button">
                                        <input type="submit" value="close" class="chatpanel-close-button" />
                                    </div>
                                </div>
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
