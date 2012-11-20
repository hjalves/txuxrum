<?php /* Global vars and functions - CHATROOM */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

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
                    Is this topic relevant?
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
                <form method="POST" class="panelframe-item-body">
                    Title <br />
                    <input type="text" class="input" />
                    <input type="submit" name="title" value="edit" class="button" />
                    <br /><br />
                    Description <br />
                    <input type="text" class="input" />
                    <input type="submit" name="description" value="edit" class="button" />
                </form>
            </div>
        </div>
    </div>
    <div id="nextSetOfContent"></div>
</div>
END;
    }
?>
