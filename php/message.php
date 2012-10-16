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
                            
                            
                            
                            
                            <div class="msgrec">                            
                                <div class="msgrec-inside">
                                    <div class="msgrec-from">
                                            From
                                    </div>
                                    <div class="msgrec-date">
                                        date
                                    </div>
                                    <div class="msgrec-body">
                                            Mensagem
                                    </div>
                                </div>
                                <div id="nextSetOfContent"></div>
                            </div>
                            
                            <div class="msgsnt">                            
                                <div class="msgsnt-inside">
                                    <div class="msgsnt-from">
                                            To
                                    </div>
                                    <div class="msgsnt-date">
                                        date
                                    </div>
                                    <div class="msgsnt-body">
                                            Mensagem
                                    </div>
                                </div>
                                <div id="nextSetOfContent"></div>
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
