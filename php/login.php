<?php /* Index file - chat rooms list */
    require_once('dbauth.php');
    require('sqlqry.php');
    session_start();
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = sql_login($username, $password);
    $row = pg_fetch_row($result, null);
    if ($row[0]) {
        $_SESSION['userid'] = $row[0];
    }
    header('Location: index.php');
    exit;
?>
