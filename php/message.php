<?php /* Private message */
    require_once('include.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title> :: -- TXUXRUM -- ::</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link href="gangnamstyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printmsgheader();

            vf_printmessagerec("to", "ja foi ontem", "Tao? Tudo bem?", "rec");
            vf_printmessagerec("to", "ja foi ontem", "Tao? Tudo bem?", "sent");

            vf_printmsgpost();

            vf_printmessagepanel(""); 
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
