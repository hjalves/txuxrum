<?php /* Global vars and functions */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');
    include("varfunc-chatroom.php");
    include("varfunc-forum.php");
    include("varfunc-message.php");
    include("varfunc-profile.php");
    include("varfunc-users.php");
    /* ## Vars ## */


    /* ## Functions ## */
    
    /* print HTML header */
    function vf_printhtmlheader($page_title, $include_scripts) {
        echo <<<END
<title> Txuxrum: $page_title </title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link href="css/gangnamstyle.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="txuxrum, txux, rum, forum, chat, rooms, messages, depraved, drunk">
<meta name="description" content="A forum with private messages and chatrooms for depraved and drunk people :)">
<meta name="author" content="Bernardo Marques, Humberto Alves, Tiago Levita">

END;
        if ($include_scripts)
            echo '<script src="js/scriptorium.js"></script>';
    }
    
    /* make link to search the $user */
    function vf_usertolink($user) {
        if (!$user)
            return "<a class =\"userlink\"> [deleted] </a>";
        return "<a href=\"profile.php?user=" . $user . "\" class=\"userlink\">" . $user . "</a>";
    }

    /* make a standard link */
    function vf_stdlink($text, $link) {
        return "<a href=\"" . $link . "\" class=\"stdlink\">" . $text . "</a>";
    }

    /* print a status message */
    function vf_printstatus($status, $style) { /* TODO info/error div message */
        echo <<<END
<div class="status-error">
    $status
</div>
END;
    }

    /* print footer */
    function vf_printfooter() {
        echo <<<END
<div align="center">
    Copyright (c) Bernarno Marques, Humberto Alves, Tiago Levita
</div>
END;
    }

    /* print mainmenu */
    function vf_printmainmenu() {
        echo <<<END
<a href="forum.php">
    <div class="menuitem">Forum</div>
</a>
<a href="message.php">
    <div class="menuitem">Messages<span class="msg-newicon" id="msgnewicon"></span></div>
</a>
<a href="users.php">
    <div class="menuitem">Users</div>
</a>
END;
        
        if ($_SESSION['userid']) {
            $username = $_SESSION['username'];
            echo<<<END
<a href="profile.php?user=$username">
    <div class="menuitem">Profile</div>
</a>
END;
        } else {
            echo<<<END
<a href="register.php">
    <div class="menuitem">Register!</div>
</a>
END;
        }
        echo <<<END
<div class="menulogin">
    <form method="POST">
END;
        /* se nao tiver autenticado */
        if (!$_SESSION['userid']) {
            echo<<<END
<input name="username" placeholder="Username" type="text" size="10" class="logininput" /> 
<input name="password" placeholder="Password" type="password" size="10" class="logininput" />
<input type="submit" name="login" value="login" class="loginbutton" />
END;
                    /* se tiver autenticado */
        } else {
            $username = $_SESSION['username'];
            echo<<<END
Welcome $username <input type="submit" name="logout" value="logout" class="loginbutton" />
END;
        }
        echo <<<END
    </form>
</div>
<div id="nextSetOfContent"></div>
END;
    }

    /* make ajax search autocomplete */
    function vf_makesearch($id) {
        return "incremental list=\"$id\" autocomplete=\"off\" onkeyup=\"getusersearch(this.value, '$id')\"";
    }

    /* make ajax datalist */
    function vf_makedatalist($id) {
        return "<datalist id=\"$id\"></datalist>";
    }
?>
