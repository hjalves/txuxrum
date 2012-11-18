<?php /* SQL Queries */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    function sql_get_chatrooms_pages($user, $title) {
        $perpage = 10;
        if ($user || $title) {
            $query = 'SELECT COUNT(*)
                      FROM (SELECT roomid
                            FROM   chatrooms
                            LEFT JOIN users
                                ON chatrooms.ownerid = users.userid
                            WHERE title ILIKE $1 AND username ILIKE $2) "b"';
            $result = pg_query_params($query, array("%$title%", "%$user%")) or die('Query failed: ' . pg_last_error());
        } else {
            $result = pg_query('SELECT COUNT(*) FROM chatrooms') or die('Query failed: ' . pg_last_error());
        }
        $line = pg_fetch_row($result, null);
        return ceil($line[0]/$perpage);
    }

    function sql_get_userid($username) {
        $query = 'SELECT UserID FROM users WHERE Username = $1';
        $result = pg_query_params($query, array($username));
        $line = pg_fetch_row($result, null);
        return $line[0];
    }

    function sql_countnewmsg($userid) {
        $query = 'SELECT count(*) FROM privatemessages WHERE readtime IS NULL AND receiverid = $1 AND sendtime < current_timestamp';
        $result = pg_query_params($query, array($userid));
        $line = pg_fetch_row($result, null);
        return $line[0];
    }

    function sql_query_chatrooms($page, $user, $title) {
        $perpage = 10;
        $query = ' SELECT title,
                          roomid,
                          owner,
                          To_char(creationdate, \'DD-Mon-YYYY, HH24:MI\'),
                          lastposter "poster",
                          To_char(lastposttime, \'DD-Mon, HH24:MI:SS\'),
                          CASE WHEN char_length(lastmsgtext) <= 40 THEN lastmsgtext
                               ELSE left(lastmsgtext, 40) || \'...\' END,
                          CASE WHEN char_length(description) <= 40 THEN description
                               ELSE left(description, 40) || \'...\' END
                   FROM   chatrooms_lastposts';

        if ($user || $title) {
            $query .= ' WHERE title ILIKE $1 AND owner ILIKE $2 ';
            $query .= ' LIMIT $3 OFFSET $4 ';
            $offset = $perpage * $page;
            $result = pg_query_params($query, array("%$title%", "%$user%", "$perpage", "$offset")) or die('Query failed: ' . pg_last_error());
        } else {
            $query .= ' LIMIT $1 OFFSET $2 ';
            $offset = $perpage * $page;
            $result = pg_query_params($query, array("$perpage", "$offset")) or die('Query failed: ' . pg_last_error());
        }
        return $result;
    }

    function sql_search_users($username, $name, $sex, $mail, $location, $birthday, $agemin, $agemax, $birthage){
        
        $sqlwhere = "";
        
        if ($username){
            $username = pg_escape_literal($username);
            $sqlwhere .= "username ILIKE $username AND ";
        }if ($name){
            $name = pg_escape_literal($name);
            $sqlwhere .= "name ILIKE $name AND ";
        }if ($sex){
            $sqlwhere .= "male = $sex AND ";
        }if ($mail){
            $mail = pg_escape_literal($mail);
            $sqlwhere .= "mail ILIKE $mail AND ";
        }if ($location){
            $location = pg_escape_literal($location);
            $sqlwhere .= "location ILIKE $location AND ";
        }if ($birthage == "age" && $agemin && $agemax){
            $sqlwhere .= "date_part('year',age(Birthday)) BETWEEN $agemin AND $agemax AND ";
        }if ($birthday && $birthage == "birth"){
            $birthday = pg_escape_literal($birthday);
            $sqlwhere .= "birthday = $birthday AND ";
            
        }if (!$sqlwhere)
            return sql_query_users();

        $query = 'SELECT username, name, date_part(\'year\',age(Birthday)), Location FROM users WHERE '
                . substr($sqlwhere, 0, -5);

        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_chatroom($id) {
        $query = 'SELECT Title, Description FROM Chatrooms WHERE RoomID = $1';
        $result = pg_query_params($query, array($id)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_messages($chatroomid) {
        $query = 'SELECT Username,
                         To_char(PostTime, \'DD-Mon-YYYY, HH24:MI:SS\'),
                         MsgText
                  FROM   messages LEFT JOIN users USING (userid) WHERE RoomID = $1 ORDER BY MsgID ASC';
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

    function sql_new_topic($userid, $title, $description) {
        $query = 'INSERT INTO chatrooms (OwnerID, Title, Description) VALUES ($1, $2, $3)';
        $result = pg_query_params($query, array($userid, $title, $description)) or die ('Insert failed: ' . pg_last_error());
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
        
        if($username)   $username = pg_escape_literal($username);
        if($password)   $password = pg_escape_literal($password);
        if($name)       $name = pg_escape_literal($name);
        if($mail)       $mail = pg_escape_literal($mail);
        if($location)   $location = pg_escape_literal($location);
        if($birthday)   $birthday = pg_escape_literal($birthday);
        
        $sqlset = "";
        
        if ($password)
            $sqlset .= "password = md5($password), ";

        $sqlset .= "name = $name, ";
        $sqlset .= "male = $sex, ";
        $sqlset .= "mail = $mail, ";
        $sqlset .= "location = $location, ";
        $sqlset .= "birthday = $birthday, ";
        $sqlset .= "usernamepublic = $usernamepublic, ";
        $sqlset .= "profilepublic = $profilepublic";

        if (!$sqlset)
            return;

        $query = "UPDATE users SET "
                . $sqlset
                . " WHERE username = $username";

        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_message_get($userid) {
        $query = '  SELECT CASE WHEN privatemessages.receiverid = $1 THEN \'rec\'
                                ELSE \'sent\' END "direction",
                           CASE WHEN privatemessages.receiverid = $1 THEN senders.username
                                ELSE receivers.username END,
                           privatemessages.msgtext,
                           To_char(privatemessages.sendtime, \'DD-Mon, HH24:MI:SS\'),
                           To_char(privatemessages.readtime, \'DD-Mon, HH24:MI:SS\')
                    FROM   privatemessages
                    LEFT JOIN users "receivers"
                           ON privatemessages.receiverid = receivers.userid
                    LEFT JOIN users "senders"
                           ON privatemessages.senderid = senders.userid
                    WHERE  senderid = $1 OR receiverid = $1 AND 
                           privatemessages.sendtime < current_timestamp
                    ORDER BY sendtime DESC';

        $result = pg_query_params($query, array($userid)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_message_getchat($userida, $useridb) {
        $useridb = sql_get_userid($useridb);
        $query = '  SELECT CASE WHEN privatemessages.receiverid = $1 THEN \'rec\'
                                ELSE \'sent\' END "direction",
                           CASE WHEN privatemessages.receiverid = $1 THEN senders.username
                                ELSE receivers.username END,
                           privatemessages.msgtext,
                           To_char(privatemessages.sendtime, \'DD-Mon, HH24:MI:SS\'),
                           To_char(privatemessages.readtime, \'DD-Mon, HH24:MI:SS\')
                    FROM   privatemessages
                    LEFT JOIN users "receivers"
                           ON privatemessages.receiverid = receivers.userid
                    LEFT JOIN users "senders"
                           ON privatemessages.senderid = senders.userid
                    WHERE (senderid = $1 AND receiverid = $2) OR
                          (senderid = $2 AND receiverid = $1) AND
                          privatemessages.sendtime < current_timestamp
                    ORDER BY sendtime DESC';

        $result = pg_query_params($query, array($userida, $useridb)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_message_send($fromid, $to, $date, $time, $text) {
        $to = sql_get_userid($to);
        
        if($date && $time){
            $ts = $date." ".$time;
            $query = 'INSERT INTO privatemessages (senderid, receiverid, msgtext, sendtime) VALUES ($1, $2, $3, $4)';
            $result = pg_query_params($query, array($fromid, $to, $text, $ts)) or die('Query failed: ' . pg_last_error());
        }else{
            $query = 'INSERT INTO privatemessages (senderid, receiverid, msgtext) VALUES ($1, $2, $3)';
            $result = pg_query_params($query, array($fromid, $to, $text)) or die('Query failed: ' . pg_last_error());
        }
    }

    function sql_update_setreadtime_all($userid) { // TODO resolve RETURNING workaround
        $query = 'UPDATE privatemessages SET readtime = current_timestamp WHERE readtime IS NULL AND receiverid = $1 AND sendtime < current_timestamp RETURNING current_timestamp';
        $result = pg_query_params($query, array($userid)) or die ('Update failed: ' . pg_last_error());
        $line = pg_fetch_row($result, null);
        return $line[0];
    }

    function sql_update_setreadtime_user($userid, $user) {
        $user = sql_get_userid($user);
        $query = 'UPDATE privatemessages SET readtime = now() WHERE readtime IS NULL AND receiverid = $1 AND senderid = $2 AND sendtime < current_timestamp';
        $result = pg_query_params($query, array($userid, $user)) or die ('Update failed: ' . pg_last_error());
    }
?>
