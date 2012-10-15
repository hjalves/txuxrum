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
<table width="100%" border="1px" cellspacing="0px" cellpadding="0px">
    <tr>
        <td width="75%">
            <div><a href="$atitle">$title</a></div>
            <div>$user - $date</div>
        </td>
        <td>
            <div>more info</div>
            <div>more options</div>
        </td>
    </tr>
</table>
END;
    }
        
?>
