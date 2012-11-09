<?php /* Register new user form */
    require_once('include.php');

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
                        <div class="bodyframe">
                            <?php
                                vf_printregform();
                                vf_printstatus($status, $style);
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
