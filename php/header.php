<?php /* Header - title (...), menu and login/logout */

    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        exit;
        
    
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
        <td align="right" class="login">
            User: <input type="text" size="10" class="logininput" /> 
            Pass: <input type="password" size="10" class="logininput" />
            <input type="submit" value="login" class="loginbutton" />
            <input type="submit" value="register" class="loginbutton" />
        </td>
    </tr>
</table>
