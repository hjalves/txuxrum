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
            Attach files
        </div>
        <div class="postbox-submit">
            <input type="submit" name="post" value="post" class="button" />
        </div>
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


    function vf_printeditperm() {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Generic permissions
    </div>
    <form method="POST" class="panelframe-item-body">
        <select name="permval" class="select perm">
            <option value="t">Anyone can access</option>
            <option value="d">Users can access</option>
            <option value="f">Restricted access</option>
        </select>
        <input type="submit" name="readingperm" value="edit" class="button" />
    </form>
    <form method="POST" class="panelframe-item-body">
        <select name="permval" class="select perm">
            <option value="t">Users can post</option>
            <option value="f">Restricted posting</option>
        </select>
        <input type="submit" name="postingperm" value="edit" class="button" />
    </form>
</div>
END;
    }

    function vf_printpermissions($permissions) {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        User permissions
    </div>
    <div class="panelframe-item-body">
END;
    foreach ($permissions as $p) {
        echo vf_usertolink($p['username']), " : ";
        if ($p['canread'] == 't') echo "(CAN access)";
        else if ($p['canread'] == 'f') echo "(NO access)";
        echo " ";
        if ($p['canpost'] == 't') echo "(CAN post)";
        else if ($p['canpost'] == 'f') echo "(NO post)";
        echo '<br />';
    }

        echo <<<END
    </div>
    <div class="panelframe-item-title">
        Add users
    </div>
    <form method="POST" class="panelframe-item-body">
        <input type="text" name="perm_user" class="input" id="perminput" />
        <select name="perm_value" class="select">
          <option value="RW">RW</option>
          <option value="dW">dW</option>
          <option value="Rd">Rd</option>
          <option selected value="dd">dd</option>
          <option value="Rx">R-</option>
          <option value="dx">d-</option>
          <option value="xx">--</option>
        </select>
        <input type="submit" name="perm_add" value="add" class="button" />
    </form>
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

    function vf_printinfotopic($title, $description, $owner, $date, $reading, $posting) {
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
        Anyone can access: $reading <br />
        Anyone can post: $posting <br />
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

    function vf_startchatpanel() {
        echo '<div class="panelframe-right">';
        echo '<div class="panelframe">';
    }

    function vf_endchatpanel() {
        echo '</div>';
        echo '</div>';
        
        echo '<div id="nextSetOfContent"></div>';
        echo '</div>';
    }

?>
