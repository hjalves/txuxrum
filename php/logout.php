<?php /* Index file - chat rooms list */
    require_once('dbauth.php');
    session_start();
    unset($_SESSION['userid']);
    header('Location: index.php');
    //exit;
?>
