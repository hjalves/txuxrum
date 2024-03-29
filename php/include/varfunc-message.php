<?php /* Global vars and functions - MESSAGE */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* print message header */
    function vf_printmsgheader($user) {
        $msg = $user ? "Private messages" : "You need to login to send/receive PM's!";
        $error = $user ? "" : " error";
        echo <<<END
<div class="textframe">
    <div class="textframe-title$error">
        $msg
    </div>
    <div class="panelframe-left" id="msglist">
END;
    }

    /* print message item */
    function vf_printmessage($direction, $user, $text, $sendtime, $rectime, $msgid) {
        $user = vf_usertolink($user);
        $dirstr = $direction == "rec" ? "From: " : "To: ";
        $deletebtn = "";
        if (!$rectime){
            $rectime = "unread";
            $deletebtn = '  <br>
                            <form method="POST">
                                <div class="msg-submit">
                                    <input type="hidden" name="pvtmsgid" value="'.$msgid.'" />
                                    <input type="submit" name="delete" value="delete" class="button" />
                                </div>
                            </form>';
        }
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
        $deletebtn
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
        $input = vf_makesearch("msgdatalistpost");
        $datalist = vf_makedatalist("msgdatalistpost");
        echo <<<END
<form method="POST">
    <div class="textframe postbox">
        <div class="textframe-inside postbox-to">
            <div class="textframe-ivar">
                To:
            </div>
            <div class="textframe-ival">
                <input $input name="to" type="text" class="input" value="$user" />$datalist
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-inside postbox-to">
            <div class="textframe-ivar">
                Postpone:
            </div>
            <div class="textframe-ival">
                <input type="date" name="date" class="input" />
                <input type="time" name="time" class="msg-input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-inside postbox-text">
            <textarea rows="4" cols="50" name="text" class="input postbox-textarea"></textarea>
        </div>
        <div class="textframe-inside postbox-attach">
            (TODO) Attach files
        </div>
        <div class="msg-submit">
            <input type="submit" name="msgsent" value="sent" class="button" />
        </div>
    </div>
</form>
END;
    }

    /* print message panel */
    function vf_printmessagepanel($user) {
        $buser = !$user ? "everyone" : vf_usertolink($user);
        $input = vf_makesearch("msgdatalistfilter");
        $datalist = vf_makedatalist("msgdatalistfilter");
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
                        <input $input type="text" name="user" class="input" value="$user" />$datalist
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

    /* print ajax script get new messages */
    function vf_printjsgetmsg() {
        echo <<<END
<script>
    igetnewmsg = setInterval(getnewmsg, 2500);
</script>
END;
}
?>
