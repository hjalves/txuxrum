<?php /* Global vars and functions - MESSAGE */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

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
    function vf_printmessage($direction, $user, $text, $sendtime, $rectime) {
        $user = vf_usertolink($user);
        $dirstr = $direction == "rec" ? "From: " : "To: ";
        if (!$rectime)
            $rectime = "unread";
        echo <<<END
<div class="textframe-inside msg-$direction">
    <div class="msg-header">
        <div class="msg-from">
            $dirstr $user
        </div>
        <div class="msg-date">
            $sendtime
        </div>
        <div id="nextSetOfContent"></div>
    </div>
    <div class="msg-header">
        <div class="msg-from">
            
        </div>
        <div class="msg-date">
            $rectime
        </div>
        <div id="nextSetOfContent"></div>
    </div>
    <div class="msg-msg">
        $text
    </div>
</div>
END;
    }

    /* print message post form */
    function vf_printmsgpost($user) {
        echo <<<END
<form method="POST">
    <div class="textframe postbox">
        <div class="textframe-inside postbox-to">
            <div class="textframe-ivar">
                To:
            </div>
            <div class="textframe-ival">
                <input name="to" type="text" class="input" value="$user" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-inside postbox-to">
            <div class="textframe-ivar">
                Postpone:
            </div>
            <div class="textframe-ival">
                <input type="date" name="date" class="input" />
                <input type="time" name="time" class="input" />
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
        $buser = !$user ? "everyone" : vf_usertolink($user);

        echo <<<END
    </div>
    <div class="panelframe-right">
        <div class="panelframe">
            <form method="GET">
                <div class="panelframe-item">
                    <div class="panelframe-item-title">
                        Message of you and $buser
                    </div>
                    <div class="panelframe-item-body">
                        <input name="user" type="text" class="input" value="$user" />
                        <input type="submit" value="filter" class="button" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }
?>
