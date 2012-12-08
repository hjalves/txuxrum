-- Dripping wiews
DROP VIEW lastmsg CASCADE;
DROP VIEW chattotalmsg CASCADE;
DROP VIEW usertotalmsg CASCADE;
DROP VIEW chatrating CASCADE;
DROP VIEW chatrooms_extended CASCADE;
DROP VIEW current_permissions CASCADE;
DROP VIEW users_permissions CASCADE;
DROP VIEW guest_permissions CASCADE;
DROP VIEW chatrooms_extended_user CASCADE;

-- Último post por chatroom
CREATE VIEW lastmsg AS
  SELECT roomid, MAX(msgid) "msgid"
  FROM messages
  GROUP BY roomid;

-- Número de posts por chatroom
CREATE VIEW chattotalmsg AS
  SELECT roomid, COUNT(*) "numposts"
  FROM messages
  GROUP BY roomid;

-- Número de posts por user
CREATE VIEW usertotalmsg AS
  SELECT userid, COUNT(*) "numposts"
  FROM messages
  GROUP BY userid;

-- Média de rating por chatroom
CREATE VIEW chatrating AS
  SELECT roomid, SUM(value)/COUNT(*)::float "mean"
  FROM ratings
  GROUP BY roomid;

-- Chatrooms com muito mais informacao associada
CREATE VIEW chatrooms_extended AS
  SELECT chatrooms.*, owners.username "owner",
         posters.username "lastposter",
         messages.posttime "lastposttime",
         messages.msgtext "lastmsgtext",
         chatrating.mean "rating"
  FROM chatrooms
  LEFT JOIN lastmsg ON chatrooms.roomid = lastmsg.roomid
  LEFT JOIN messages ON lastmsg.msgid = messages.msgid
  LEFT JOIN users "owners" ON chatrooms.ownerid = owners.userid
  LEFT JOIN users "posters" ON messages.userid = posters.userid
  LEFT JOIN chatrating ON chatrooms.roomid = chatrating.roomid;

-- Vista das permissões atuais dos utilizadores
CREATE VIEW users_permissions AS
  SELECT u.userid "userid",
         c.roomid "roomid",
         (coalesce(pp.canread, c.readingperm, TRUE)
          OR c.ownerid = u.userid) "canread",
         (coalesce(pp.canpost, c.postingperm, TRUE)
          OR c.ownerid = u.userid) AND NOT c.closed "canpost"
  FROM chatrooms c
  CROSS JOIN users u
  LEFT JOIN (SELECT userid, roomid, canread, canpost
             FROM permissions) pp
  ON (c.roomid = pp.roomid AND u.userid = pp.userid);

-- Vista das permissões do convidado (user não autenticado)
CREATE VIEW guest_permissions AS
  SELECT 0 "userid",
         c.roomid "roomid",
         coalesce(c.readingperm, FALSE) "canread",
         FALSE "canpost"
  FROM chatrooms c;

-- Vista das permissões atuais
CREATE VIEW current_permissions AS
  SELECT * FROM users_permissions
    UNION ALL
  SELECT * FROM guest_permissions;

-- Chatrooms extended mais informacao respetiva do utilizador (permissions + rating)
CREATE VIEW chatrooms_extended_user AS
  SELECT cr.*, p.userid, p.canread, p.canpost
  FROM chatrooms_extended cr
  INNER JOIN current_permissions p
  ON p.roomid = cr.roomid;

