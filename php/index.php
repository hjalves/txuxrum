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
                            
                            
                            <?php
                                vf_printsearchbox();
                                vf_printchatitem("Exemplo de titulo", "chat.php?thread=ID", "Username", "19 Oct 2012");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                vf_printchatitem("Outro exemplo de titulo", "outrolink", "user", "agosto");
                                
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
