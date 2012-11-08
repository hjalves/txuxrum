<?php /* Private message */
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
                        <div class="bodyframe" width="100%">
                            
                            
                            <div class="messagebox">
                            <?php
                                vf_printmessagesent("to", "ja foi ontem", "Tao? Tudo bem?");
                                vf_printmessagesent("to", "ja foi ontem", "Tao? Tudo bem?");
                                vf_printmessagerec("to", "ja foi ontem", "Tao? Tudo bem?");
                                vf_printmessagesent("to", "ja foi ontem", "Tao? Tudo bem?");
                                vf_printmessagerec("to", "ja foi ontem", "Tao? Tudo bem?");
                                vf_printmessagesent("to", "ja foi ontem", "Tao? Tudo bem?");
                                
                           ?>
                            </div>
                        
                            <?php
                                vf_printmessagepanel(""); 
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
