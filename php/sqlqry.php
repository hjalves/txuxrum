<?php /* SQL Queries */
    
    /* EXAMPLE - select all from $1 */
    function sql_selectall($table) {
        $result = pg_query($GLOBALS["dblink"], "SELECT * FROM " . $table . ";");
        
        return $result;
    }
    
?>
