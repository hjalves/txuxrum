<?php /* Global vars and functions - FORUM */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

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
                echo "<span class=\"button page-selected\">$i</span>";
            else
                echo "<a href=\"?$get\" class=\"button page-link\">$i</a>";
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
                By owner
            </div>
            <div class="textframe-ival">
                <input type="text" name="user" value="$user" class="input" />
            </div>
            <div id="nextSetOfContent"></div>
        </div>
        <div class="textframe-item">
            <div class="textframe-ivar">
                By title
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
            <input type="submit" name="newtopic" value="create" class="button" />
        </div>
    </div>
</form>
END;
    }
?>
