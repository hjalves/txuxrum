<?php /* SQL Queries */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    function sql_query_chatrooms() {
		$query = 'SELECT Title, RoomID, Username, to_char(CreationDate, \'DD-Mon-YYYY, HH24:MI\') FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID ORDER BY RoomID DESC';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		return $result;
    }

    function sql_search_users($username, $name, $birthday, $age, $mail, $country, $city){
        
        if(!$birthday)
        {
            if($age)
            {
                $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE username ILIKE $1 AND name ILIKE $2 AND date_part(\'year\',age(Birthday)) = $3 AND mail ILIKE $4 AND location ILIKE $5 AND location ILIKE $6';
                $result = pg_query_params($query, array("%$username%", "%$name%", $age, "%$mail%", "%$country%", "%$city%"));
            }
            else
            {
                $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE username ILIKE $1 AND name ILIKE $2 AND mail ILIKE $3 AND location ILIKE $4 AND location ILIKE $5';
                $result = pg_query_params($query, array("%$username%", "%$name%", "%$mail%", "%$country%", "%$city%"));
            }
        }
        else
        {
            if($age)
            {
                $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE username ILIKE $1 AND name ILIKE $2 AND birthday = $3 AND date_part(\'year\',age(Birthday)) = $4 AND mail ILIKE $5 AND location ILIKE $6 AND location ILIKE $7';
                $result = pg_query_params($query, array("%$username%", "%$name%", $birthday, $age, "%$mail%", "%$country%", "%$city%"));
            }
            else
            {
                $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE username ILIKE $1 AND name ILIKE $2 AND birthday = $3 AND mail ILIKE $4 AND location ILIKE $5 AND location ILIKE $6';
                $result = pg_query_params($query, array("%$username%", "%$name%", $birthday, "%$mail%", "%$country%", "%$city%"));
            }
        }
        return $result;
    }


/*    function sql_search_users($username, $name, $birthday, $age, $mail, $country, $city){
        $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE username ILIKE $1 AND name ILIKE $2 OR mail = $3 AND location ILIKE $4 AND location ILIKE $5';
        $result = pg_query_params($query, array("%$username%", "%$name%", $mail, "%$country%", "%$city%"));
        return $result;
    }
*/
    function sql_query_chatrooms_search($usr, $tit) {
		$query = 'SELECT Title, RoomID, Username, CreationDate FROM chatrooms, users WHERE chatrooms.OwnerID = users.UserID AND Title ILIKE $1 AND chatrooms.Ownerid IN (SELECT userid FROM users WHERE username ILIKE $2) ORDER BY title ASC';
		$result = pg_query_params($query, array("%$tit%", "%$usr%")) or die('Query failed: ' . pg_last_error());
		return $result;
    }

    function sql_query_chatroom($id) {
        $query = 'SELECT Title, Description FROM Chatrooms WHERE RoomID = $1';
        $result = pg_query_params($query, array($id)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_messages($chatroomid) {
        $query = 'SELECT COALESCE(Username,\'[SIGSEGV]\'), to_char(PostTime, \'DD-Mon-YYYY, HH24:MI:SS\'), MsgText FROM messages LEFT JOIN users USING (userid) WHERE RoomID = $1 ORDER BY MsgID ASC';
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
