-- Functions

DROP FUNCTION getChatrooms(userid integer) CASCADE;
DROP FUNCTION searchChatrooms(userid integer, title varchar, owner varchar) CASCADE;

-- Devolve as chatrooms em que user tem permissão para ler posts
CREATE FUNCTION getChatrooms(userid integer)
RETURNS SETOF chatrooms_lastposts
AS $$
    SELECT cr.* FROM chatrooms_lastposts cr
    LEFT JOIN (SELECT roomid, canread
               FROM permissions
               WHERE userid = $1 ) rdperm
    ON (cr.roomid = rdperm.roomid)
    WHERE (rdperm.canread = TRUE OR rdperm.canread IS NULL)
    ORDER BY coalesce(lastposttime, creationdate) DESC
$$ LANGUAGE SQL;


-- Efetua pesquisa às chatrooms em que user tem permissão para ler
CREATE FUNCTION searchChatrooms(userid integer, title varchar, owner varchar)
RETURNS SETOF chatrooms_lastposts
AS $$
    SELECT * FROM getChatrooms($1)
    WHERE title ILIKE $2 AND owner ILIKE $3
$$ LANGUAGE SQL;


