<?php /* Global vars and functions */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* ## Vars ## */


    /* ## Functions ## */
    /* make link to search the $user */
    function vf_usertolink($user) {
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
    <div class="menuitem">Messages</div>
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

    /***************
     *
     * CHATROM LIST
     *
     ***************/

    /* print chatroom list header */
    function vf_printchatlistheader() {
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        Chat rooms
    </div>
END;
    }

    /* print chat room list item */
    function vf_printchatitem($title, $id, $user, $date, $postuser, $postdate, $postprev, $topic) {
        $user = vf_usertolink($user);
        $postuser = vf_usertolink($postuser);
        $lastpostup = $postdate ? "Last post by $postuser on $postdate" : "No posts in this topic";
        $title = vf_stdlink($title, "chat.php?thread=$id");
        if (!$postprev)
            $postprev = "&nbsp;";
        echo <<<END
    <div class="textframe-inside">
        <div class="chatroom-left">
            <div class="chatroom-left-inside">
                <div class="chatroom-leftsmal">
                    $title
                </div>
                <div class="chatroom-rightsmal">
                    $user
                </div>
                <div id="nextSetOfContent"></div>
                <div class="chatroom-leftsmal">
                    $topic
                </div>
                <div class="chatroom-rightsmal">
                    $date
                </div>
                <div id="nextSetOfContent"></div>
            </div>
        </div>
        <div class="chatroom-right">
            <div class="chatroom-right-inside">
                <div class="chatroom-lastpost-up">
                    $lastpostup
                </div>
                <div class="chatroom-lastpost-down">
                    $postprev
                </div>
            </div>
        </div>
        <div id="nextSetOfContent"></div>
    </div>
END;
    }

    /* print chatroom list footer */
    function vf_printchatlistfooter($numpage, $selected) {
        $query_arr = $_GET;

        $query_arr["page"] = $selected - 1;
        $prev = http_build_query($query_arr);
        $query_arr["page"] = $selected + 1;
        $next = http_build_query($query_arr);

        if ($selected > 1)
            $prev = "<a href=\"?$prev\" class=\"button\"><</a> ";
        else
            $prev = "<span class=\"button\"><</span>";

        if ($selected < $numpage)
            $next = "<a href=\"?$next\" class=\"button\">></a>";
        else
            $next = "<span class=\"button\">></span>";

        echo <<<END
    <div class="textframe-footer">
END;
        echo $prev;
        for ($i = 1; $i <= $numpage; $i++) {
            $query_arr["page"] = $i;
            $get = http_build_query($query_arr);

            if ($i == $selected)
                echo "<span class=\"page-selected\">$i</span> ";
            else
                echo "<a href=\"?$get\" class=\"page-link\">$i</a> ";
        }
            echo $next;
        echo <<<END
    </div>
</div>
END;
    }

    /* print searchbox */
    function vf_printsearchbox($user, $title) {
        echo <<<END
<form method="GET">
    <div class="textframe">
        <div class="textframe-title">
            Search topics
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username
            </div>
            <div class="textframe-ival">
                <input type="text" name="user" value="$user" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Title
            </div>
            <div class="textframe-ival">
                <input type="text" name="title" value="$title" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input type="submit" value="search" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print create new thread */
    function vf_printcreatethread() {
        echo <<<END
<form method="POST">
    <div class="textframe">
        <div class="textframe-title">
        New topic
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Title
            </div>
            <div class="textframe-ival">
                <input type="text" name="title" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Description
            </div>
            <div class="textframe-ival">
                <input type="text" name="description" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input type="submit" name="newtopic" value="newtopic" class="button" />
        </div>
    </div>
</form>
END;
    }

    /***************
     *
     * CHATROM
     *
     ***************/

    /* print chatroom header */
    function vf_printchatheader($title, $theme) {
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        $title
        <div class="textframe-subtitle">
            $theme
        </div>
    </div>
    <div class="panelframe-left">
END;
    }

    /* print chatroom message item */
    function vf_printchatmsg($user, $date, $msg) {
        $user = vf_usertolink($user);
        echo <<<END
<div class="textframe-inside chatmsg">
    <div class="chatmsg-header">
        <div class="chatmsg-from">
            $user
        </div>
        <div class="chatmsg-date">
            $date
        </div>
        <div id="nextSetOfContent"></div>
    </div>
    <div class="chatmsg-msg">
        $msg
    </div>
</div>
END;
    }

    /* print chatroom post form */
    function vf_printchatpost() {
        echo <<<END
<form method="POST">
    <div class="textframe postbox">
        <div class="postbox-text">
            <textarea rows="4" cols="50" name="text" class="input postbox-textarea"></textarea>
        </div>
        <div class="postbox-attach">
            (TODO) Attach files
        </div>
        <div class="postbox-submit">
            <input type="submit" name="post" value="post" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print chatroom panel */
    function vf_printchatpanel() {
        echo <<<END
    </div>
    <div class="panelframe-right">
        <div class="panelframe">
            <div class="panelframe-item">
                <div class="panelframe-item-title">
                    Is this room interesting?
                </div>
                <div class="panelframe-item-body">
                    No | Maybe | Yes
                </div>
            </div>
            <div class="panelframe-item">
                <div class="panelframe-item-title">
                    Users in this topic
                </div>
                <div class="panelframe-item-body">
                    (TODO)<br> user1<br>user2
                </div>
                <div class="panelframe-item-title">
                    Add new user
                </div>
                <div class="panelframe-item-body">
                    <input type="text" class="input" />
                    <input type="submit" value="add" class="button" />
                </div>
            </div>
            <div class="panelframe-item">
                <div class="panelframe-item-title">
                    Close this topic
                </div>
                <div class="panelframe-item-body">
                    <input type="submit" value="close topic" class="button" />
                </div>
            </div>
            <div class="panelframe-item">
                <div class="panelframe-item-title">
                    Edit this topic
                </div>
                <div class="panelframe-item-body">
                    Title <br />
                    <input type="text" class="input" />
                    <input type="submit" value="edit" class="button" />
                    <br /><br />
                    Theme <br />
                    <input type="text" class="input" />
                    <input type="submit" value="edit" class="button" />
                </div>
            </div>
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }

    /***************
     *
     * PRIVATE MESSAGE
     *
     ***************/

    /* print message header */
    function vf_printmsgheader() {
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        Private messages
    </div>
    <div class="panelframe-left">
END;
    }

    /* print message item */
    function vf_printmessagerec($fromto, $date, $msg, $direction) {
        $fromto = vf_usertolink($fromto);
        echo <<<END
<div class="textframe-inside msg-$direction">
    <div class="msg-header">
        <div class="msg-from">
            $fromto
        </div>
        <div class="msg-date">
            $date
        </div>
        <div id="nextSetOfContent"></div>
    </div>
    <div class="msg-msg">
        $msg
    </div>
</div>
END;
    }

    /* print message post form */
    function vf_printmsgpost() {
        echo <<<END
<form method="POST">
    <div class="textframe postbox">
        <div class="textframe-inside postbox-to">
            <div class="textframe-ivar">
                To:
            </div>
            <div class="textframe-ival">
                <input name="to" type="text" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="postbox-text">
            <textarea rows="4" cols="50" name="text" class="input postbox-textarea"></textarea>
        </div>
        <div class="postbox-attach">
            (TODO) Attach files
        </div>
        <div class="postbox-submit">
            <input type="submit" name="msgsent" value="sent" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print message panel */
    function vf_printmessagepanel($user) {
        if (!$user)
            $user = "everyone";
        else
            $user = vf_usertolink($user);

        echo <<<END
    </div>
    <div class="panelframe-right">
        <div class="panelframe">
            <div class="panelframe-item">
                <div class="panelframe-item-title">
                    Message of you and $user
                </div>
                <div class="panelframe-item-body">
                    <input name="msg_filter_user" type="text" class="input" />
                    <input name="msg_filter_button" type="submit" value="filter" class="button" />
                    <input name="msg_clear" type="submit" value="clear filter" class="button" />
                </div>
            </div>
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }

    /***************
     *
     * PROFILE
     *
     ***************/

    /* print profile */
    function vf_printprofile($username, $name, $male, $mail, $location, $birthday, $age, $editable) {
        $male = $male == "t" ? "male" : "female";
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        $username
    </div>
    <div class="">
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                $username
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                $name
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                $male
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                E-mail:
            </div>
            <div class="textframe-ival">
                $mail
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                $location
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday:
            </div>
            <div class="textframe-ival">
                $birthday
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Age:
            </div>
            <div class="textframe-ival">
                $age
            </div>
            <div id="nextSetOfContent"></div>
        </div>
END;
    if ($editable)
        echo <<<END
        <div class="textframe-footer">
            <a class="button" href="?edit=$username">edit your profile</a>
        </div>
END;

    echo <<<END
    </div>
</div>
END;
    }

    /* print profile editable */
    function vf_printeditprofile($username, $name, $male, $mail, $location, $birthday, $usernamepublic, $profilepublic) {
        if ($male == "t")
            $mc = "checked";
        else
            $fc = "checked";

        if ($usernamepublic == "t")
            $upc = "checked";
        else
            $unc = "checked";

        if ($profilepublic == "t")
            $ppc = "checked";
        else
            $pnc = "checked";

        echo <<<END
<form method="POST">
    <div class="textframe">
        <div class="textframe-title">
            $username
        </div>
        <div class="">
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Username:
                </div>
                <div class="textframe-ival">
                    $username
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Password:
                </div>
                <div class="textframe-ival">
                    <input type="password" name="password" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Re-enter password:
                </div>
                <div class="textframe-ival">
                    <input type="password" name="repassword" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Name:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="name" required class="input" value="$name" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Sex:
                </div>
                <div class="textframe-ival">
                    male
                    <input $mc type="radio" required name="sex" value="true" />
                    <input $fc type="radio" required name="sex" value="false" />
                    female
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    E-mail:
                </div>
                <div class="textframe-ival">
                    <input type="email" name="email" required class="input" value="$mail" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Location:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="local" required class="input" value="$location" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Birthday:
                </div>
                <div class="textframe-ival">
                    <input type="date" name="birthday" required class="input" value="$birthday" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Public username:
                </div>
                <div class="textframe-ival">
                    yes
                    <input $upc type="radio" required name="usernamepublic" value="true" />
                    <input $unc type="radio" required name="usernamepublic" value="false" />
                    no
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Public profile:
                </div>
                <div class="textframe-ival">
                    yes
                    <input $ppc type="radio" required name="profilepublic" value="true" />
                    <input $pnc type="radio" required name="profilepublic" value="false" />
                    no
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-footer">
                <input name="profileedit" type="submit" value="save" class="button" />
                <input name="cancel" type="submit" value="cancel" class="button" />
                <input name="closeprofile" type="submit" value="close account" class="button" />
            </div>
        </div>
    </div>
</form>
END;
    }

    /* print search profile */
    function vf_printsearchprofile($username, $name, $male, $mail, $location, $birthday, $agemin, $agemax, $birthage) {
        if ($male == "true")
            $mc = "checked";
        else if ($male == "false")
            $fc = "checked";
        else
            $bc = "checked";

        if ($birthage == "age")
            $baa = "checked";
        else
            $bab = "checked";

        echo <<<END
<form method="GET">
    <div class="textframe">
        <div class="textframe-title">
            Search user
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_u" class="input" value="$username" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_n" class="input" value="$name" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                <input $bc type="radio" name="sp_s" value="" /> both <br />
                <input $mc type="radio" name="sp_s" value="true" /> male <br />
                <input $fc type="radio" name="sp_s" value="false" /> female
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Mail:
            </div>
            <div class="textframe-ival">
                <input type="email" name="sp_m" class="input" value="$mail" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_l" class="input" value="$location" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday or age:
            </div>
            <div class="textframe-ival">
                Birthday
                <input $bab type="radio" name="sp_birthage" value="birth" />
                <input $baa type="radio" name="sp_birthage" value="age" />
                Age
                <div id="birthagediv">
                    <div id="birthage-date">
                        <input id="ba_date" type="date" name="sp_d" class="input" value="$birthday" />
                    </div>
                    <div id="birthage-age">
                        <input id="ba_agemin" type="number" min="0" max="120" name="sp_amin" class="input" value="$agemin" /> min<br />
                        <input id="ba_agemax" type="number" min="0" max="120" name="sp_amax" class="input" value="$agemax" /> max
                    </div>
                </div>
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input name="search" type="submit" value="search" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print registration form */
    function vf_printregform() {
        echo <<<END
<form method="POST">
    <div class="textframe">
        <div class="textframe-title">
            Register new user
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Username:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_usr" required class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Password:
            </div>
            <div class="textframe-ival">
                <input type="password" name="reg_pwd" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Re-enter password:
            </div>
            <div class="textframe-ival">
                <input type="password" name="reg_pwdcheck" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_name" required class="input" value="$name" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Sex:
            </div>
            <div class="textframe-ival">
                male
                <input type="radio" required name="reg_sex" value="1" />
                <input type="radio" required name="reg_sex" value="0" />
                female
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                E-mail:
            </div>
            <div class="textframe-ival">
                <input type="email" name="reg_mail" required class="input" value="$mail" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                <input type="text" name="reg_loc" required class="input" value="$location" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Birthday:
            </div>
            <div class="textframe-ival">
                <input type="date" name="reg_date" required class="input" value="$birthday" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input name="register" type="submit" value="save" class="button" />
        </div>
    </div>
</form>
END;
    }

    /***************
     *
     * USERS LIST
     *
     ***************/

    /* print search user header */
    function vf_printsearchheader() {
        echo <<<END
<div class="textframe">
    <div class="textframe-title">
        <div class="users-search-subtitle">
            Username
        </div>
        <div class="users-search-subtitle">
            Name
        </div>
        <div class="users-search-subtitle">
            Age
        </div>
        <div class="users-search-subtitle">
            Location
        </div>
        <div id="nextSetOfContent"></div>
    </div>

END;
    }

    /* print search user result */
    function vf_printsearchresult($username, $name, $age, $location) {
        $username = vf_usertolink($username);
        echo <<<END
<div class="textframe-item">
    <div class="users-search-subitem">
        $username
    </div>
    <div class="users-search-subitem">
        $name
    </div>
    <div class="users-search-subitem">
        $age
    </div>
    <div class="users-search-subitem">
        $location
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }

    /* print search user footer */
    function vf_printsearchfooter($username, $name, $age, $location) {
    echo <<<END
</div>
END;
    }

?>
