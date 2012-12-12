<?php /* Profile viewer/editer */
    require_once('include/include.php');

    /* get username and check if it has rights to edit */
    $username = $_GET["user"] ? $_GET["user"] : $_GET["edit"];
    $editable = $username == $_SESSION["username"];
    if (!$editable && $_GET["edit"])
        header("Location: ?user=$username");

    /* edit profile */
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

    /* cancel edit profile */
    if ($_POST['cancel'])
        header("Location: ?user=$username");

    /* close user account */
    if ($_POST['closeprofile']) {
        if($_POST['deleleAccData'])
            sql_delete_account($_SESSION["userid"], true);
        else
            sql_delete_account($_SESSION["userid"], false);
        header("Location: index.php?logout");
    }

    /* gets profile's info */
    $result = sql_query_user($username);
    $rowprofile = pg_fetch_row($result, null);

?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader("$rowprofile[0]", $_SESSION['userid']); #apenas inclui scripts para users ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            if ($_GET["edit"])
                vf_printeditprofile($rowprofile[0], $rowprofile[1], $rowprofile[2], $rowprofile[3], $rowprofile[4], $rowprofile[5], $rowprofile[7], $rowprofile[8]);
            else {
                if (!$_SESSION["userid"])
                    $rowprofile[3] = "[hidden]";
                vf_printprofile($rowprofile[0], $rowprofile[1], $rowprofile[2], $rowprofile[3], $rowprofile[4], $rowprofile[5], $rowprofile[6], $editable);
            }

            vf_printstatus($status, $style);
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
