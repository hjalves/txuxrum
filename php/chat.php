<?php /* Chat room */
    require_once('dbauth.php');
    require('varfunc.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- CHATRUM -- ::</title>
        <font size="1px" />
        
    </head>
    <body>
        <div align="center">
            <table width="700px" border="1px" cellspacing="0px" cellpadding="0px">
                <tr>
                    <td>
                        <?php include("header.php"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        body
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php vf_printfooter(); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        
    </body>
</html>
