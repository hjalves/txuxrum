<?php /* Global vars and functions - CHATROOM */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* print chatroom header */
    function vf_printchatheader($chatroom) {
        $title = $chatroom ? $chatroom['title'] : "Access Denied";
        $description = $chatroom ? $chatroom['description'] : "";
        $error = $chatroom ? "" : " error";
        echo <<<END

    <div class="textframe-title$error">
        $title
        <div class="textframe-subtitle">
            $description
        </div>
    </div>
    
END;
    }

    /* print chatroom message item */
    function vf_printchatmsg($message, $attachments) {
        $userlink = vf_usertolink($message['username']);
        echo <<<END
<div class="textframe-inside chatmsg">
    <div class="chatmsg-header">
        <div class="chatmsg-from">
            $userlink
        </div>
        <div class="chatmsg-date">
            $message[date]
        </div>
        <div id="nextSetOfContent"></div>
    </div>
    <div class="chatmsg-msg">
        $message[msgtext]
    </div>
    
END;
        if ($attachments)
            vf_printattachments($attachments);
        echo "</div>";
    }

    /* print multiple attachments */
    function vf_printattachments($attachments) {
        echo "<div class=\"chatmsg-attachments\">";
        foreach ($attachments as $a) {
            // echo $a['docid']
            $docid = $a['docid'];
            $filename = $a['filename'];
            echo  "<a class=\"attachlink\" href=\"/~txux/uploaded_files/$filename\" target=\"_blank\"> <b>✗</b> $filename </a> <br>";
        }
        echo "</div>";
    }

    /* print chatroom post form */
    function vf_printchatpost() {
        echo <<<END
<form method="POST" enctype="multipart/form-data">
    <div class="textframe postbox">
        <div class="postbox-text">
            <textarea rows="4" cols="50" name="text" class="input postbox-textarea"></textarea>
        </div>
        <div class="postbox-attach">
            <label for="file">Attach files:</label>
            <input type="file" name="files[]" multiple id="file" class="file"/>
            <span class="postbox-submit">
                <input type="submit" name="post" value="post" class="button" />
            </span>
        </div>
    </div>
</form>
    
END;
    }

    function vf_printratetopic($rating) {
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Is this topic relevant?
    </div>
    <form method="POST" class="panelframe-item-body">
        <input type="submit" name="rating" value="no" class="button rate" />
        <input type="submit" name="rating" value="maybe" class="button rate" />
        <input type="submit" name="rating" value="yes" class="button rate" />
        <input type="submit" name="rating" value="n/a" class="button rate" />
    </form>
</div>
END;
        // <div class="panelframe-item-body">
        //echo "You currently don't think so :("    
        //echo "You currently think so! :)"
        //echo "You currently think it might be."
        //echo "You didn't express your opinion."

    }


    function vf_printeditperm($reading, $posting) {
        $rt = $rd = $rf = $pt = $pf = "";
        $sel = " selected";
        switch ($reading) {
            case 'f': $rf = $sel; break;
            case 't': $rt = $sel; break;
            default:  $rd = $sel;
        }
        switch ($posting) {
            case 'f': $pf = $sel; break;
            default:  $pt = $sel;
        }
        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        Generic permissions
    </div>
    <form method="POST" class="panelframe-item-body">
        <select name="permval" class="select perm">
            <option value="t"$rt>Anyone can access</option>
            <option value="d"$rd>Users can access</option>
            <option value="f"$rf>Restricted access</option>
        </select>
        <input type="submit" name="readingperm" value="edit" class="button" />
    </form>
    <form method="POST" class="panelframe-item-body">
        <select name="permval" class="select perm">
            <option value="t"$pt>Users can post</option>
            <option value="f"$pf>Restricted posting</option>
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
    if (!$permissions)
        echo "No individual permissions specified.";

        echo <<<END
    </div>
    <div class="panelframe-item-title">
        Edit permissions
    </div>
    <form method="POST" class="panelframe-item-body">
        <input type="text" name="perm_user" class="input" id="perminput" />
        <select name="perm_value" class="select perm">
          <option value="RW">[RW] access & post</option>
          <option value="dW">[dW] post</option>
          <option value="Rd">[Rd] access</option>
          <option selected value="dd">[dd] default</option>
          <option value="Rx">[Rx] only access</option>
          <option value="dx">[dx] no post</option>
          <option value="xx">[xx] banned</option>
        </select>
        <input type="submit" name="perm_add" value="edit" class="button" />
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
    <form method="POST" class="panelframe-item-body">
        <input type="submit" name="close" value="close topic" class="button" />
        <input type="submit" name="open" value="open topic" class="button" />
    </form>
</div>
END;
    }

    function vf_printinfotopic($cr) {
        $link = vf_usertolink($cr['owner']);
        $postmsg = $cr['canpost'] == 't' ? "You <b>can</b> post like a boss" : "You <b>cannot</b> post";
        $closed = $cr['closed'] == 't' ? "Topic is <b>closed</b> <br />" : "";

        echo <<<END
<div class="panelframe-item">
    <div class="panelframe-item-title">
        About this topic
    </div>
    <div class="panelframe-item-body">
        Title: $cr[title] <br />
        Description: $cr[description] <br />
        Owner: $link <br />
        Created on: $cr[date] <br />
        Last post on: $cr[lastposttime] <br />
        Number of posts: $cr[numposts] <br />
        Rating: $cr[rating] <br />
        $postmsg <br />
        $closed

        <!-- Anyone can access: $cr[readingperm] <br /> -->
        <!-- Anyone can post: $cr[postingperm] <br /> -->
        <!-- Am I the owner?: $cr[iamowner] <br /> -->
        
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
    }

?>
