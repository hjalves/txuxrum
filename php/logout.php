<?php /* Index file - chat rooms list */
    require_once('dbauth.php');
    require('sqlqry.php');
    session_start();
    unset($_SESSION['userid']);
    header('Location: index.php');
    exit;
?>
