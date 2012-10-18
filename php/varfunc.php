<?php /* Global vars and functions */
    
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        exit;
    
    /* ## Vars ## */
    
    
    /* ## Functions ## */
    /* print footer */
    function vf_printfooter() {
        echo <<<END
<div align="center">
    Copyright (c) Bernarno Marques, Humberto Alves, Tiago Levita
</div>
END;
    }
    
    /* print chatroom item */
    function vf_printchatitem($title, $atitle, $user, $date) {
        echo <<<END
<div class="chatroom">                            
    <div class="chatroom-left">
        <div class="chatroom-title">
            <a href="$atitle">$title</a>
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
        <div class="chatroom-info">
            more info
        </div>
        <div class="chatroom-options">
            more options
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }
    
    /* print chatroom header */
    function vf_printchatheader($title, $theme) {
        echo <<<END
<div class="chathead">
    <div class="chathead-title">
        $title
    </div>
    <div class="chathead-theme">
        $theme
    </div>
</div>
<div>
    &nbsp; <!-- space -->
</div>
END;
    }
    
    /* print chatroom message item */
    function vf_printchatmsg($user, $date, $msg) {
        echo <<<END
<div class="chatmsg textframe">                            
    <div class="chatmsg-inside textframe-inside">
        <div class="chatmsg-from">
            $user
        </div>
        <div class="chatmsg-date">
            $date
        </div>
        <div id="nextSetOfContent"></div>
        <div class="chatmsg-body">
            $msg
        </div>
    </div>
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
        echo <<<END
<div class="msgpanel panelframe">
    <div class="msgpanel-filter panelframe-item">
        <div class="msgpanel-filter-title panelframe-item-title">
            Message of you and $user
        </div>
        <div class="msgpanel-filter-div">
            <input type="text" size="20" class="msgpanel-filter-div-search panelframe-input" />
            <input type="submit" value="filter" class="msgpanel-filter-div-button panelframe-button" />
            <input type="submit" value="clear filter" class="msgpanel-filter-div-button panelframe-button" />
        </div>
    </div>
</div>
END;
    }
    
    /* print chatroom panel */
    function vf_printchatroompanel() {
        echo <<<END
<div class="chatpanel panelframe">
    <div class="chatpanel-rate panelframe-item">
        <div class="chatpanel-rate-title panelframe-item-title">
            Rate this room
        </div>
        <div class="chatpanel-rate-rate">
            No | Maybe | Yes
        </div>
    </div>
    <div class="chatpanel-ulist panelframe-item">
        <div class="chatpanel-ulist-title panelframe-item-title">
            Users in this topic
        </div>
        <div class="chatpanel-ulist-list">
            (TODO)<br> user1<br>user2
        </div>
        <div class="chatpanel-ulist-addtitle panelframe-item-title">
            Add new user
        </div>
        <div class="chatpanel-ulist-add">
            <input type="text" size="20" class="chatpanel-ulist-addinput panelframe-input" />
            <input type="submit" value="add" class="chatpanel-ulist-addbutton panelframe-button" />
        </div>
    </div>
    <div class="chatpanel-close panelframe-item">
        <div class="chatpanel-close-title  panelframe-item-title">
            Close this topic
        </div>
        <div class="chatpanel-close-div button">
            <input type="submit" value="close" class="chatpanel-close-button panelframe-button" />
        </div>
    </div>
    <div class="chatpanel-edit panelframe-item">
        <div class="chatpanel-edit-title  panelframe-item-title">
            Edit this topic
        </div>
        <div class="chatpanel-edit-div">
            Title <br />
            <input type="text" size="20" class="chatpanel-edit-addinput panelframe-input" />
            <input type="submit" value="edit" class="chatpanel-edit-addbutton panelframe-button" />
            <br /><br />
            Theme <br />
            <input type="text" size="20" class="chatpanel-edit-addinput panelframe-input" />
            <input type="submit" value="edit" class="chatpanel-edit-addbutton panelframe-button" />
        </div>
    </div>
</div>
END;
    }
    
    /* print chatroom post form */
    function vf_printchatroompostform() {
        echo <<<END
<div class="postbox textframe">
    <div class="postbox-inside textframe-inside">
        <div class="postbox-text">
        <textarea rows="4" cols="50" class="postbox-text-area panelframe-input"></textarea>
        </div>
        <div class="postbox-attach">
            (TODO) Attach files
        </div>
        <div class="postbox-submit">
            <input type="submit" value="post" class="panelframe-button" />
        </div>    
    </div>
</div>
END;
    }
    
    /* print searchbox */
    function vf_printsearchbox() {
        echo <<<END
<div class="searchbox">
    <div class="searchbox-inside"> 
        Search by
        username <input type="text" size="20" class="panelframe-input" />
        and/or topic <input type="text" size="20" class="panelframe-input" />
        <input type="submit" value="search" class="panelframe-button" />
        or list your topics
    </div>
</div>
END;
    }
    
    
    
?>
