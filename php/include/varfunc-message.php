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
?>
