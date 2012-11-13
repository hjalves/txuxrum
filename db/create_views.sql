-- Faz associação entre o id da ultima mensagem postada e o id do chatroom
DROP VIEW lastmsg CASCADE;
DROP VIEW chatrooms_lastposts CASCADE;

CREATE VIEW lastmsg AS
  SELECT messages.roomid, max(messages.msgid) AS msgid
  FROM messages
  JOIN chatrooms ON messages.roomid = chatrooms.roomid
  GROUP BY messages.roomid;

-- Chatrooms com os ultimos posts
CREATE VIEW chatrooms_lastposts AS
  SELECT chatrooms.*, owners.username "owner",
         posters.username "lastposter",
         messages.posttime "lastposttime",
         messages.msgtext "lastmsgtext"
  FROM chatrooms
  LEFT JOIN lastmsg ON chatrooms.roomid = lastmsg.roomid
  LEFT JOIN messages ON lastmsg.msgid = messages.msgid
  LEFT JOIN users "owners" ON chatrooms.ownerid = owners.userid
  LEFT JOIN users "posters" ON messages.userid = posters.userid
  ORDER BY coalesce(messages.posttime, creationdate) DESC;
