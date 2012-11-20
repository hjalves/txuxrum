<?php /* Register new user form */
    require_once('include/include.php');

    /* redirects if it's already logged in */
    if ($_SESSION['userid'])
        header('Location: .');

    $status = "";
    $style  = "info";

    /* register new user */
    if ($_POST['register']) {
        if ($_POST["reg_usr"] && ($_POST["reg_pwd"] == $_POST["reg_pwdcheck"])){
            if (sql_reg_user($_POST["reg_usr"],$_POST["reg_pwd"],$_POST["reg_name"],$_POST["reg_sex"],$_POST["reg_mail"],$_POST["reg_loc"],$_POST["reg_date"]) === 0) {
                $status = "Great suck sex register!";
                $style  = "info";
            }
        } else if ($_POST["reg_pwd"] != $_POST["reg_pwdcheck"]) {
            $status = "Passwords don't match!";
            $style  = "error";
        }
    }
?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader("Register", $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printregform();

            vf_printstatus($status, $style);
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
