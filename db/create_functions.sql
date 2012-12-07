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
               WHERE userid = $1) rdperm
    ON (cr.roomid = rdperm.roomid)
    WHERE ((coalesce(rdperm.canread, cr.readingperm, TRUE) OR
        cr.ownerid = $1) AND ($1 <> 0 OR cr.readingperm = TRUE))
    ORDER BY coalesce(lastposttime, creationdate) DESC
$$ LANGUAGE SQL;


-- Efetua pesquisa às chatrooms em que user tem permissão para ler
-- TODO: devia ser mais elaborado
CREATE FUNCTION searchChatrooms(userid integer, title varchar, owner varchar)
RETURNS SETOF chatrooms_lastposts
AS $$
    SELECT * FROM getChatrooms($1)
    WHERE title ILIKE $2 AND owner ILIKE $3
$$ LANGUAGE SQL;


