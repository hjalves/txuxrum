<?php /* Header - title (...), menu and login/logout */

    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        exit;
        
    
?>

<table width="100%" border="1px" cellspacing="0px" cellpadding="0px">
    <tr>
        <td colspan="4">
            baner
        </td>
    </tr>
    <tr>
        <td width="133px" align="center">
            <a href="index.php">
                Inicio
            </a>
        </td>
        <td width="133px" align="center">
            <a href="message.php">
                Mensagens
            </a>
        </td>
        <td  align="center">
            <a href="profile.php">
                Perfil
            </a>
        </td>
        <td width="300px" align="center">
            User: <input type="text" size="10" style="font-size: 10px;" /> 
            Pass: <input type="password" size="10" style="font-size: 10px;" />
            <input type="submit" value="login" style="font-size: 10px;" />
        </td>
    </tr>
</table>
