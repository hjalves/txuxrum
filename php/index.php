<?php /* Index file - chat rooms list */
    require_once('include/include.php');
?>

<!DOCTYPE html>

<html>
    <head>
    <META HTTP-EQUIV="refresh" CONTENT="2;URL=forum.php">
    <?php vf_printhtmlheader("Welcome", $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
            <?php
            if (isset($_SESSION['username']))
                echo "Welcome back, ", $_SESSION['username'], "! <br /> Redirecting to forum...";
            else
                echo "Very welcome! Redirecting to forum...";
            ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
