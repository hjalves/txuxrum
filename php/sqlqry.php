<?php /* SQL Queries */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    function sql_query_chatrooms($user, $title) {
        $query = ' SELECT chatrooms.title,                                          '
               . '        chatrooms.roomid,                                         '
               . '        Coalesce(owners.username, \'null\') "owner",              '
               . '        To_char(chatrooms.creationdate, \'DD-Mon-YYYY, HH24:MI\'),'
               . '        Coalesce(posters.username, \'null\') "poster",            '
               . '        To_char(messages.posttime, \'DD-Mon, HH24:MI:SS\'),       '
               . '        left(messages.msgtext, 40),                               '
               . '        left(chatrooms.description, 50)                           '
               . ' FROM   chatrooms                                                 '
               . '        LEFT JOIN lastmsg                                         '
               . '               ON chatrooms.roomid = lastmsg.roomid               '
               . '        LEFT JOIN messages                                        '
               . '               ON lastmsg.msgid = messages.msgid                  '
               . '        LEFT JOIN users "owners"                                  '
               . '               ON chatrooms.ownerid = owners.userid               '
               . '        LEFT JOIN users "posters"                                 '
               . '               ON messages.userid = posters.userid                ';
        if ($user || $title) {
            $query .= " WHERE chatrooms.title ILIKE $1 AND owners.username ILIKE $2 ";
            $query .= " ORDER BY chatrooms.title ASC";
            $result = pg_query_params($query, array("%$title%", "%$user%")) or die('Query failed: ' . pg_last_error());
        } else {
            $query .= " ORDER BY chatrooms.roomid DESC";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        }
        return $result;
    }
    
    function sql_search_users($username, $name, $sex, $mail, $location, $birthday, $agemin, $agemax, $birthage){
        $sqlwhere = "";
        if ($username)
            $sqlwhere .= "username ILIKE '$username' AND ";
        if ($name)
            $sqlwhere .= "name ILIKE '$name' AND ";
        if ($sex)
            $sqlwhere .= "male = $sex AND ";
        if ($mail)
            $sqlwhere .= "mail ILIKE '$mail' AND ";
        if ($location)
            $sqlwhere .= "location ILIKE '$location' AND ";
        if ($birthage == "age" && $agemin && $agemax)
            $sqlwhere .= "date_part('year',age(Birthday)) BETWEEN $agemin AND $agemax AND ";
        if ($birthday && $birthage == "birth")
            $sqlwhere .= "birthday = '$birthday' AND ";

        if (!$sqlwhere)
            return sql_query_users();

        $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE '
                . substr($sqlwhere, 0, -5);

        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

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
        $query = 'SELECT Username, Name, Male, Mail, Location, Birthday, date_part(\'year\',age(Birthday)), Usernamepublic, Profilepublic FROM users WHERE Username = $1';
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
        $result = pg_query_params($query, array($username, $mail)) or die('Query failed: ' . pg_last_error());
        if(pg_fetch_row($result, null)) {
            return 1;
        } else {
            $cmd = 'INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ($1, md5($2), $3, $4, $5, $6, $7);';
            pg_query_params($cmd, array($username, $password, $name, $ismale, $mail, $location, $birhtday));
            return 0;
        }
    }

    function sql_profile_update($username, $password, $name, $sex, $mail, $location, $birthday, $usernamepublic, $profilepublic) {
        $sqlset = "";
        if ($password)
            $sqlset .= "password = '$password', ";
        if ($name)
            $sqlset .= "name = '$name', ";
        if ($sex)
            $sqlset .= "male = '$sex', ";
        if ($mail)
            $sqlset .= "mail = '$mail', ";
        if ($location)
            $sqlset .= "location = '$location', ";
        if ($birthday)
            $sqlset .= "birthday = '$birthday', ";
        if ($usernamepublic)
            $sqlset .= "usernamepublic = '$usernamepublic', ";
        if ($profilepublic)
            $sqlset .= "profilepublic = '$profilepublic', ";

        if (!$sqlset)
            return;

        $query = "UPDATE users SET "
                . substr($sqlset, 0, -2)
                . " WHERE username = '$username'";

        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }
?>
