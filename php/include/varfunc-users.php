<?php /* Global vars and functions - USERS */
    /* stop execution ifnot included */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* print search user header */
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

    /* print search user result */
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

    /* print search user footer */
    function vf_printsearchfooter($username, $name, $age, $location) {
    echo <<<END
</div>
END;
    }
?>
