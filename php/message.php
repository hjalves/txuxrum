<?php /* Private message */
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
                        
                            
                            <div class="msgpanel">
                                <div class="msgpanel-filter">
                                    <div class="msgpanel-filter-title">
                                        Message of you and $user
                                    </div>
                                    <div class="msgpanel-filter-div">
                                        <input type="text" size="20" class="msgpanel-filter-div-search" />
                                        <input type="submit" value="filter" class="msgpanel-filter-div-button" />
                                        <input type="submit" value="clear filter" class="msgpanel-filter-div-button" />
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
