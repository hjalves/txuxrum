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
    
    /* print footer */
    function vf_printfooter() {
        echo <<<END
<div align="center">
    Copyright (c) Bernarno Marques, Humberto Alves, Tiago Levita
</div>
END;
    }
    
    /* print chatroom item */
    function vf_printchatitem($title, $id, $user, $date, $postuser, $postdate, $postprev) {
        $user = vf_usertolink($user);
        $postuser = vf_usertolink($postuser);
        echo <<<END
<div class="chatroom">
    <div class="chatroom-left">
        <div class="chatroom-title">
            <a href="chat.php?thread=$id">$title</a>
        </div>
        <div>
            <div class="chatroom-user">
                $user
            </div>
            <div class="chatroom-date">
                $date
            </div>
        </div>
    </div>
    <div class="chatroom-right">
        <div class="chatroom-lastpost">
            Last post by $postuser on $postdate
        </div>
        <div class="chatroom-lastpostby">
            $postprev
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }

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
    function vf_printchatroompostform($roomid) {
        echo <<<END
<form method="POST">
    <div class="textframe-inside postbox">
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
                    Rate this room
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
                    <input type="text" size="20" class="input" />
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
                    <input type="text" size="20" class="input" />
                    <input type="submit" value="edit" class="button" />
                    <br /><br />
                    Theme <br />
                    <input type="text" size="20" class="input" />
                    <input type="submit" value="edit" class="button" />
                </div>
            </div>
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }

    /* print message item received */
    function vf_printmessagerec($from, $date, $msg) {
        echo <<<END
<div class="msgrec textframe">                            
    <div class="msgrec-inside textframe-inside">
        <div class="msgrec-from">
            $from
        </div>
        <div class="msgrec-date">
            $date
        </div>
        <div class="msgrec-body">
            $msg
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }
    
    /* print message item sent */
    function vf_printmessagesent($to, $date, $msg) {
        echo <<<END
<div class="msgsnt textframe">                            
    <div class="msgsnt-inside textframe-inside">
        <div class="msgsnt-from">
            $to
        </div>
        <div class="msgsnt-date">
            $date
        </div>
        <div class="msgsnt-body">
            $msg
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }
    
    /* print message panel */
    function vf_printmessagepanel($user) {
        if (!$user)
            $user = "everyone";
        else
            $user = vf_usertolink($user);
            
        echo <<<END
<div class="msgpanel panelframe">
    <div class="msgpanel-filter panelframe-item">
        <div class="msgpanel-filter-title panelframe-item-title">
            Message of you and $user
        </div>
        <div class="msgpanel-filter-div">
            <input name="msg_filter_user" type="text" size="20" class="msgpanel-filter-div-search panelframe-input" />
            <input name="msg_filter_button" type="submit" value="filter" class="msgpanel-filter-div-button panelframe-button" />
            <input name="msg_clear" type="submit" value="clear filter" class="msgpanel-filter-div-button panelframe-button" />
        </div>
    </div>
</div>
END;
    }

    /* print searchbox */
    function vf_printsearchbox($user, $topic) {
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
                <input type="text" name="sb_usr" value="$user" size="20" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Title
            </div>
            <div class="textframe-ival">
                <input type="text" name="sb_tit" value="$topic" size="20" class="input" />
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
    function vf_printeditprofile($username, $name, $male, $mail, $location, $birthday, $age, $usernamepublic, $profilepublic) {
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
                    <input type="password" name="password" size="30" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Re-enter password:
                </div>
                <div class="textframe-ival">
                    <input type="password" name="repassword" size="30" class="input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Name:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="name" required size="30" class="input" value="$name" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Sex:
                </div>
                <div class="textframe-ival">
                    male
                    <input $mc type="radio" required name="sex" value="1" />
                    <input $fc type="radio" required name="sex" value="0" />
                    female
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    E-mail:
                </div>
                <div class="textframe-ival">
                    <input type="email" name="email" required size="30" class="input" value="$mail" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="textframe-item">
                <div class="textframe-ivar">
                    Location:
                </div>
                <div class="textframe-ival">
                    <input type="text" name="local" required size="30" class="input" value="$location" />
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
                    Age:
                </div>
                <div class="textframe-ival">
                    $age
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
                <input type="text" name="sp_u" size="30" class="input" value="$username" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Name:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_n" size="30" class="input" value="$name" />
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
                <input type="email" name="sp_m" size="30" class="input" value="$mail" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Location:
            </div>
            <div class="textframe-ival">
                <input type="text" name="sp_l" size="30" class="input" value="$location" />
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
                        <input id="ba_agemin" type="number" min="0" max="120" name="sp_amin" size="20" class="input" value="$agemin" /> min<br />
                        <input id="ba_agemax" type="number" min="0" max="120" name="sp_amax" size="20" class="input" value="$agemax" /> max
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

    /* print search header */
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

    /* print search result */
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

    /* print search result */
    function vf_printsearchfooter($username, $name, $age, $location) {
    echo <<<END
</div>
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
                <input type="text" size="20" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                Description
            </div>
            <div class="textframe-ival">
                <input type="text" size="20" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-footer">
            <input type="submit" name="createthread_post" value="create new topic" class="button" />
        </div>
    </div>
</form>
END;
    }
    
    /* print a status message */
    function vf_printstatus($status, $style) { /* TODO info/error div message */
        echo <<<END
$status
END;
    }
    
    /* print registration form */
    function vf_printregform() {
        echo <<<END
<form method="POST">
    <div class="textframe profile-profile-main">
        <div class="textframe-inside profile-profile-user">
            Register new user
        </div>
        <div class="">
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Username:
                </div>
                <div class="profile-profile-val">
                    <input type="text" name="reg_usr" required size="30" class="panelframe-input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Password:
                </div>
                <div class="profile-profile-val">
                    <input type="password" name="reg_pwd" size="30" class="panelframe-input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Re-enter password:
                </div>
                <div class="profile-profile-val">
                    <input type="password" name="reg_pwdcheck" size="30" class="panelframe-input" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Name:
                </div>
                <div class="profile-profile-val">
                    <input type="text" name="reg_name" required size="30" class="panelframe-input" value="$name" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Sex:
                </div>
                <div class="profile-profile-val">
                    male
                    <input type="radio" required name="reg_sex" value="1" class="panelframe-input" />
                    <input type="radio" required name="reg_sex" value="0" class="panelframe-input" />
                    female
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    E-mail:
                </div>
                <div class="profile-profile-val">
                    <input type="email" name="reg_mail" required size="30" class="panelframe-input" value="$mail" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Location:
                </div>
                <div class="profile-profile-val">
                    <input type="text" name="reg_loc" required size="30" class="panelframe-input" value="$location" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-div textframe-inside">
                <div class="profile-profile-var">
                    Birthday:
                </div>
                <div class="profile-profile-val">
                    <input type="date" name="reg_date" required class="panelframe-input" value="$birthday" />
                </div>
                <div id="nextSetOfContent"></div>
            </div>
            <div class="profile-profile-footer">
                <input name="register" type="submit" value="save" class="panelframe-button" />
            </div>
        </div>
    </div>
</form>
END;
    }
    
?>
