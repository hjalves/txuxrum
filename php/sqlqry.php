<?php /* SQL Queries */
    
    /* EXAMPLE - select all from $1 */
    function sql_selectall($table) {
        global $dblink;
        $result = pg_query($dblink, "SELECT * FROM " . $table . ";");
        return $result;
    }
    
    function sql_query_chatrooms() {
		$query = 'SELECT Title, RoomID, Username, CreationDate FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID ORDER BY RoomID DESC';
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

    function sql_query_user($username) {
        $query = 'SELECT Username, Name, Male, Mail, Location, Birthday, date_part(\'year\',age(Birthday)) FROM users WHERE Username = $1';
        $result = pg_query_params($query, array($username)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_user_id($userid) {
        $query = 'SELECT Username FROM users WHERE UserID = $1';
        $result = pg_query_params($query, array($userid));
        return $result;
    }

    function sql_login($username, $password) {
        $query = 'SELECT UserID FROM users WHERE username=$1 AND password=md5($2)';
        $result = pg_query_params($query, array($username, $password)) or die('Query failed: ' . pg_last_error());
        return $result;
    }
    
    function sql_post_message($userid, $roomid, $msgtext) {
        $query = 'INSERT INTO messages (UserID, RoomID, MsgText) VALUES ($1, $2, $3)';
        $result = pg_query_params($query, array($userid, $roomid, $msgtext)) or die('Insert failed: ' . pg_last_error());
        return $result;
    }

    function sql_reg_user($username, $password, $name, $ismale, $mail, $location, $birhtday){
        $query = 'SELECT userid FROM users WHERE username ILIKE $1 OR mail LIKE $2';
        $result = pg_query_params($query, array($username, $mail)) or die('couldn\'t validade user data');
        if(pg_fetch_row($result, null)){
            echo 'username or e-mail in use';
            return 1;
        }else{
            $cmd = 'INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ($1, md5($2), $3, $4, $5, $6, $7);';
            pg_query_params($cmd, array($username, $password, $name, $ismale, $mail, $location, $birhtday));
            return 0;
        }
    }
    
?>
