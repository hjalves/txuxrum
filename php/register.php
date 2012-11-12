<?php /* Register new user form */
    require_once('include/include.php');

    if ($_SESSION['userid'])
        header('Location: .');

    $status = "";
    $style  = "info";

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
        <title> :: -- TXUXRUM -- ::</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link href="css/gangnamstyle.css" rel="stylesheet" type="text/css" />
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
