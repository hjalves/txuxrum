-- Uma view para fazer associação entre o id da ultima mensagem postada e o id do chatroom
CREATE view lastmsg
  SELECT messages.roomid, max(messages.msgid) AS msgid
  FROM messages
  JOIN chatrooms ON messages.roomid = chatrooms.roomid
  GROUP BY messages.roomid;