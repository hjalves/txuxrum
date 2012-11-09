<?php /* Header - title (...), menu and login/logout */

    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');
        

?>

<table width="100%" border="0px" cellspacing="0px" cellpadding="0px">
    <tr>
        <td colspan="5" align="center" class="title">
            Txuxrum
        </td>
    </tr>
    <tr>
        <td width="100px" align="center" class="menuitem">
            <a href="forum.php">
                Forum
            </a>
        </td>
        <td width="100px" align="center" class="menuitem">
            <a href="message.php">
                Messages
            </a>
        </td>
        <td width="100px" align="center" class="menuitem">
            <a href="users.php">
                Users
            </a>
        </td>
        <td width="100px" align="center" class="menuitem">
        <?php
            if ($_SESSION['userid']) {
                $username = $_SESSION['username'];
                echo<<<END
<a href="profile.php?user=$username">
    Profile
</a>
END;
            } else {
echo<<<END
<a href="register.php">
    Register!
</a>
END;
            }
            
        ?>
        </td>
        <td align="right" class="login">
            <form name="login" method="post">
                <?php
                    /* se nao tiver autenticado */
                    if (!$_SESSION['userid']) {
                        echo<<<END
    User: <input name="username" type="text" size="10" class="logininput" /> 
    Pass: <input name="password" type="password" size="10" class="logininput" />
    <input type="submit" name="login" value="login" class="loginbutton" />
END;
                    /* se tiver autenticado */
                    } else {
                        $username = $_SESSION['username'];
                        echo<<<END
    Welcome $username
    <input type="submit" name="logout" value="logout" class="loginbutton" />
END;
                    }
                ?>
            </form>
        </td>
    </tr>
</table>
