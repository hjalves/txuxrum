-- Functions

DROP FUNCTION getChatrooms(userid integer) CASCADE;
DROP FUNCTION searchChatrooms(userid integer, title varchar, owner varchar) CASCADE;
DROP FUNCTION deleteUserData(uid integer) CASCADE;

-- Devolve as chatrooms em que user tem permissão para ler posts
CREATE FUNCTION getChatrooms(userid integer)
RETURNS SETOF chatrooms_extended_user
AS $$
    SELECT * FROM chatrooms_extended_user
    WHERE canread AND userid = COALESCE($1,0)
    ORDER BY coalesce(lastposttime, creationdate) DESC
$$ LANGUAGE SQL;


-- Efetua pesquisa às chatrooms em que user tem permissão para ler
-- TODO: devia ser mais elaborado
CREATE FUNCTION searchChatrooms(userid integer, title varchar, owner varchar)
RETURNS SETOF chatrooms_extended_user
AS $$
    SELECT * FROM getChatrooms($1)
    WHERE title ILIKE $2 AND owner ILIKE $3
$$ LANGUAGE SQL;


CREATE FUNCTION deleteUserData(uid integer)
RETURNS void
AS $$

--'apaga' os dados pessoais
	UPDATE users SET deleted='t', 
					 usernamepublic='t', 
					 profilepublic='t', 
					 male=null, 
					 name=null, 
					 mail=null, 
					 location = null, 
					 birthday=null
				WHERE 
					 userid = $1;

--apaga as chatrooms criadas pelo utilizador nas quais não houve interação com outros utilizadores
--não sei se justifica, é um caso a pensar!
			DELETE FROM messages WHERE roomid = 
			(SELECT DISTINCT roomid FROM chatrooms 
			WHERE ownerid=$1 
			AND (SELECT COUNT(msgid) from messages where messages.roomid = chatrooms.roomid) 
			<= (SELECT COUNT(msgid) from messages where messages.roomid = chatrooms.roomid AND messages.userid = chatrooms.ownerid));

			DELETE FROM chatrooms 
			WHERE ownerid=$1 
			AND (SELECT COUNT(msgid) from messages where messages.roomid = chatrooms.roomid) 
			<= (SELECT COUNT(msgid) from messages where messages.roomid = chatrooms.roomid AND messages.userid = chatrooms.ownerid);


$$ LANGUAGE SQL;
