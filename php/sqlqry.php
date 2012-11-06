<?php /* SQL Queries */
    
    /* EXAMPLE - select all from $1 */
    function sql_selectall($table) {
        global $dblink;
        $result = pg_query($dblink, "SELECT * FROM " . $table . ";");
        return $result;
    }
    
    function sql_query_chatrooms() {
		$query = 'SELECT Title, RoomID, Username, CreationDate FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		return $result;
    }

    function sql_query_chatrooms_search($usr, $tit) {
		$query = 'SELECT Title, RoomID, Username, CreationDate FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID AND Title ILIKE $1 AND chatrooms.Ownerid IN (SELECT userid FROM users WHERE username ILIKE $2) ORDER BY title ASC';
		$result = pg_query_params($query, array("%$tit%", "%$usr%")) or die('Query failed: ' . pg_last_error());
		return $result;
    }

    function sql_query_chatroom($id) {
        $query = 'SELECT Title FROM Chatrooms WHERE RoomID = $1';
        $result = pg_query_params($query, array($id)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_messages($chatroomid) {
        $query = 'SELECT Username, to_char(PostTime, \'DD-Mon-YYYY, HH24:MI:SS\'), MsgText FROM messages, users WHERE RoomID = $1 AND messages.UserID = users.UserID ORDER BY MsgID ASC';
        $result = pg_query_params($query, array($chatroomid)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_users() {
        $query = 'SELECT Username, Name, date_part(\'year\',age(Birthday)), Location FROM users';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

?>
