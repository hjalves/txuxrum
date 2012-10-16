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
    
    /* print chat item */
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
        
?>
