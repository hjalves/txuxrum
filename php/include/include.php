<?php /* include and init scripts */
    session_start();

    require_once('dbauth.php');
    require('varfunc.php');
    require_once('sqlqry.php');

    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* LOGIN */
    if ($_REQUEST['login']) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = sql_login($username, $password);
        $row = pg_fetch_row($result, null);
        $_SESSION['userid'] = $row[0];
        if ($_SESSION['userid'])
            $_SESSION['username'] = $username;
    }
    if ($_REQUEST['logout']) {
        unset($_SESSION['userid'], $_SESSION['username']);
    }
?>
