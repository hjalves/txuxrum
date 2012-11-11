<?php /* Profile viewer/editer */
    require_once('include.php');

    $username = $_GET["user"] ? $_GET["user"] : $_GET["edit"];
    $editable = $username == $_SESSION["username"];

    if ($_POST['profileedit']) {
        if ($_POST['password'] != $_POST['repassword']) {
            $status = "Passwords mismatch";
            $style = "error";
        }

        else {
            sql_profile_update($username,
                               $_POST['password'],
                               $_POST['name'],
                               $_POST['sex'],
                               $_POST['email'],
                               $_POST['local'],
                               $_POST['birthday'],
                               $_POST['usernamepublic'],
                               $_POST['profilepublic']);
            header("Location: ?user=$username");
        }
    }
    if ($_POST['cancel'])
        header("Location: ?user=$username");
    if ($_POST['closeprofile']) {
        //TODO close account
    }

    if (!$editable && $_GET["edit"])
        header("Location: ?user=$username");

    $result = sql_query_user($username);
    $row = pg_fetch_row($result, null);

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


                                if ($_GET["edit"])
                                    vf_printeditprofile($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]);
                                else
                                    vf_printprofile($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $editable);
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
