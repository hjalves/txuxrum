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

    function vf_printratetopic() {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Is this topic relevant?
    </div>
    <div class="panelframe-item-body">
        No | Maybe | Yes
    </div>
</div>
END;
    }

    function vf_printpermissions() {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Permissions
    </div>
    <div class="panelframe-item-body">
    User manel <br /> Wololo
    </div>
    <div class="panelframe-item-title">
        Add new user
    </div>
    <div class="panelframe-item-body">
        <input type="text" class="input" />
        <input type="submit" value="add" class="button" />
    </div>
</div>
END;
    }

    function vf_printclosetopic() {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Close this topic
    </div>
    <div class="panelframe-item-body">
        <input type="submit" value="close topic" class="button" />
    </div>
</div>
END;
    }

    function vf_printinfotopic($title, $description, $owner, $date) {
        $link = vf_usertolink($owner);
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        About this topic
    </div>
    <div class="panelframe-item-body">
        Title: $title <br />
        Description: $description <br />
        Owner: $link <br />
        Created on: $date <br />
    </div>
</div>
END;
    }

    function vf_printedittitle($title) {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Edit title
    </div>
    <form method="POST" class="panelframe-item-body">
        <input type="text" name="title" value="$title" class="input" />
        <input type="submit" value="edit" class="button" />
    </form>
</div>
END;
    }

    function vf_printeditdescription($description) {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Edit description
    </div>
    <form method="POST" class="panelframe-item-body">
        <input type="text" name="description" value="$description" class="input" />
        <input type="submit" value="edit" class="button" />
    </form>
</div>
END;
    }

    /* print chatroom panel */
    function vf_printchatpanel($title, $description, $owner, $date) {
        echo '</div>';
        echo '<div class="panelframe-right">';
        echo '<div class="panelframe">';

        vf_printinfotopic($title, $description, $owner, $date);
        vf_printedittitle($title);
        vf_printeditdescription($description);
        vf_printratetopic();
        vf_printpermissions();
        vf_printclosetopic();
        

        echo '</div>';
        echo '</div>';
        echo '<div id="nextSetOfContent"></div>';
        echo '</div>';
    }
?>
