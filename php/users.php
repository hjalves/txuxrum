<?php /* Profile viewer/editer */
    require_once('include/include.php');

   $user = $_GET["sp_u"];
   $name = $_GET["sp_n"];
   $sex = $_GET["sp_s"];
   $mail = $_GET["sp_m"];
   $location = $_GET["sp_l"];
   $birthday = $_GET["sp_d"];
   $agemin = $_GET["sp_amin"];
   $agemax = $_GET["sp_amax"];
   $birthage = $_GET["sp_birthage"];

    /* search user */
    if ($_GET['search'])
        $ressearch = sql_search_users($user, $name, $sex, $mail, $location, $birthday, $agemin, $agemax, $birthage);
    else
        $ressearch = sql_query_users();
?>

<!DOCTYPE html>

<html>
    <head>
    <?php vf_printhtmlheader(); ?>
    </head>
    <body>
    <div class="mainframe">
        <div class="maintitle"> Txuxrum </div>
        <div class="mainmenu"> <?php vf_printmainmenu(); ?> </div>
        <div class="mainbody">
        <?php
            vf_printsearchprofile($user, $name, $sex, $mail, $location, $birthday, $agemin, $agemax, $birthage);

            vf_printsearchheader();

            while ($row = pg_fetch_row($ressearch, null))
                vf_printsearchresult($row[0], $row[1], $row[2], $row[3]);

            vf_printsearchfooter();
        ?>
        </div>
        <div class="mainfooter"> <?php vf_printfooter(); ?> </div>
    </div>
    </body>
</html>
