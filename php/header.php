<?php /* Header - title (...), menu and login/logout */

    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');
        

?>

<table width="100%" border="0px" cellspacing="0px" cellpadding="0px">
    <tr>
        <td colspan="4" align="center" class="title">
            Txuxrum
        </td>
    </tr>
    <tr>
        <td width="105px" align="center" class="menuitem">
            <a href="index.php">
                Forum
            </a>
        </td>
        <td width="105px" align="center" class="menuitem">
            <a href="message.php">
                Mensagens
            </a>
        </td>
        <td width="105px" align="center" class="menuitem">
            <a href="users.php">
                Membros
            </a>
        </td>

        <?php
            /* se nao tiver autenticado */
            if (!$_SESSION['userid']) {
                echo<<<END
<td align="right" class="login">
    <form name="login" method="post">
        User: <input name="username" type="text" size="10" class="logininput" /> 
        Pass: <input name="password" type="password" size="10" class="logininput" />
        <input type="submit" name="login" value="login" class="loginbutton" />
    </form>
</td>
END;
            /* se tiver autenticado */
            } else {
                $result = sql_query_user_id($_SESSION['userid']);
                $row = pg_fetch_row($result, null);
                $username = $row[0];
                echo<<<END
<td align="right" class="login">
    <form name="logout" method="post">
        Logged as: $username
        <input type="submit" name="logout" value="logout" class="loginbutton" />
    </form>
</td>
END;
            }
        ?>
    </tr>
</table>
