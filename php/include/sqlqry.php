<?php /* SQL Queries */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    function sql_edit_title($userid, $roomid, $title) {
        $query = 'UPDATE chatrooms SET title = $1 WHERE roomid = $2 AND ownerid = $3';
        $result = pg_query_params($query, array($title, $roomid, $userid));
    }

    function sql_edit_description($userid, $roomid, $description) {
        $query = 'UPDATE chatrooms SET description = $1 WHERE roomid = $2 AND ownerid = $3';
        $result = pg_query_params($query, array($description, $roomid, $userid));
    }

    // isto esta uma confusao de metodos e convecoes... tem de se resolver
    function sql_edit_reading_permission($userid, $roomid, $readingperm) {
        $query = 'UPDATE chatrooms SET readingperm = $1 WHERE roomid = $2 AND ownerid = $3';
        $result = pg_query_params($query, array($readingperm, $roomid, $userid));
    }

    function sql_edit_posting_permission($userid, $roomid, $postingperm) {
        $query = 'UPDATE chatrooms SET postingperm = $1 WHERE roomid = $2 AND ownerid = $3';
        $result = pg_query_params($query, array($postingperm, $roomid, $userid));
    }

    function sql_get_user_suggestions($user) {
        $query = 'SELECT username FROM users WHERE username ILIKE $1 ORDER BY username';
        $result = pg_query_params($query, array("$user%"));
        return $result;
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

    function sql_query_chatroom($userid, $chatroomid) {
        $query = 'SELECT Title, Description, Owner, To_char(creationdate, \'DD-Mon-YYYY, HH24:MI\'), readingperm, postingperm FROM getChatrooms($1) WHERE RoomID = $2';
        $result = pg_query_params($query, array($userid, $chatroomid)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_query_chatrooms($userid, $page, $title, $owner) {
        $perpage = 10;
        $select = 'title, roomid, owner, to_char(creationdate, \'DD-Mon-YYYY, HH24:MI\'),
                   lastposter, to_char(lastposttime, \'DD-Mon, HH24:MI:SS\'),
                   CASE WHEN char_length(lastmsgtext) <= 40 THEN lastmsgtext
                    ELSE left(lastmsgtext, 40) || \'...\' END,
                   CASE WHEN char_length(description) <= 40 THEN description
                    ELSE left(description, 40) || \'...\' END';
        $offset = $perpage * $page;
        
        if ($title || $owner) {
            // Para pesquisa
            $query = 'SELECT ' . $select . ' FROM searchChatrooms($1, $2, $3) LIMIT $4 OFFSET $5';
            $result = pg_query_params($query, array($userid, "%$title%", "%$owner%", $perpage, $offset)) or die('Query failed: ' . pg_last_error());
        } else {
            // Sem pesquisa
            $query = 'SELECT ' . $select . ' FROM getChatrooms($1) LIMIT $2 OFFSET $3';
            $result = pg_query_params($query, array($userid, $perpage, $offset)) or die('Query failed: ' . pg_last_error());
        }
        return $result;
    }

    function sql_get_chatrooms_pages($userid, $title, $owner) {
        $perpage = 10;
        if ($title || $owner) {
            // Para pesquisa
            $query = 'SELECT count(*) FROM searchChatrooms($1, $2, $3)';
            $result = pg_query_params($query, array($userid, "%$title%", "%$owner%")) or die('Query failed: ' . pg_last_error());
        } else {
            // Sem pesquisa
            $query = 'SELECT count(*) FROM getChatrooms($1)';
            $result = pg_query_params($query, array($userid)) or die('Query failed: ' . pg_last_error());
        }
        $line = pg_fetch_row($result, null);
        return ceil($line[0]/$perpage);
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

    function sql_query_messages($chatroomid) {
        $query = 'SELECT Username,
                         To_char(PostTime, \'DD-Mon-YYYY, HH24:MI:SS\'),
                         MsgText
                  FROM   messages
                  LEFT JOIN users USING (userid)
                  WHERE RoomID = $1
                  ORDER BY MsgID ASC';
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
    
    /* functions */
    function sql_message_getnew($userid, $readtime) {
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
                    WHERE  (senderid = $1 OR receiverid = $1) AND 
                           (privatemessages.sendtime < current_timestamp) AND
                           (privatemessages.readtime = $2)
                    ORDER BY sendtime DESC';

        $result = pg_query_params($query, array($userid, $readtime)) or die('Query failed: ' . pg_last_error());
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

    function sql_query_permissions($roomid) {
        $query = 'SELECT username, canread, canpost FROM permissions JOIN users ON users.userid = permissions.userid WHERE roomid = $1';
        $result = pg_query_params($query, array($roomid)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    function sql_update_permission($username, $roomid, $readperm, $writeperm) {
        // se readperm e writeperm forem null apaga o registo
        if (!$readperm && !$writeperm) {
            $query = 'DELETE FROM permissions WHERE userid IN (SELECT userid FROM users WHERE username = $1) AND roomid = $2';
            $result = pg_query_params($query, array($username, $roomid)) or die('Query failed: ' . pg_last_error());
            return $result;
        }

        // faz um update em cond normais (ou tenta fazer)
        $query = 'UPDATE permissions
                      SET canread = $3, canpost = $4
                      WHERE userid IN (SELECT userid FROM users WHERE username = $1) AND roomid = $2';
        $result = pg_query_params($query, array($username, $roomid, $readperm, $writeperm)) or die('Query failed: ' . pg_last_error());
        if (pg_affected_rows($result) > 0)
            return $result;
        
        // insert caso update falhe
        $query = 'INSERT INTO permissions (userid, roomid, canread, canpost)
                     SELECT userid, $2, $3, $4
                     FROM users WHERE username = $1';
        $result = pg_query_params($query, array($username, $roomid, $readperm, $writeperm)) or die('Query failed: ' . pg_last_error());
        return $result;
    }

?>
