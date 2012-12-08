-- Functions

DROP FUNCTION getChatrooms(userid integer) CASCADE;
DROP FUNCTION searchChatrooms(userid integer, title varchar, owner varchar) CASCADE;

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


