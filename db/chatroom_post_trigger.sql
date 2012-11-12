
CREATE OR REPLACE FUNCTION post_permission_check()
RETURNS trigger
AS $$

DECLARE
    perm_rec permissions%ROWTYPE;

BEGIN

    SELECT * INTO perm_rec FROM permissions WHERE userid = NEW.userid AND roomid = NEW.roomid;

    IF (NOT perm_rec.canpost OR perm_rec.banned)
        THEN
            RAISE EXCEPTION 'user does not have permission to post';
    END IF;
    
    RETURN NEW;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER chatroom_post_trigger 
BEFORE INSERT OR UPDATE OR DELETE ON messages
FOR EACH ROW EXECUTE PROCEDURE post_permission_check();



