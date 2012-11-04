<?php /* SQL Queries */
    
    /* EXAMPLE - select all from $1 */
    function sql_selectall($table) {
        $result = pg_query($GLOBALS["dblink"], "SELECT * FROM " . $table . ";");
        
        return $result;
    }
    
    function sql_query_chatrooms() {
		$query = 'SELECT title, roomid, username, creationdate FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		return $result;
    }

?>
