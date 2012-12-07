-- Dripping wiews
DROP VIEW lastmsg CASCADE;
DROP VIEW chattotalmsg CASCADE;
DROP VIEW usertotalmsg CASCADE;
DROP VIEW chatrating CASCADE;
DROP VIEW chatrooms_lastposts CASCADE;

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

-- Chatrooms com os ultimos posts
CREATE VIEW chatrooms_lastposts AS
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
  LEFT JOIN chatrating ON chatrooms.roomid = chatrating.roomid
  ORDER BY coalesce(messages.posttime, creationdate) DESC;

